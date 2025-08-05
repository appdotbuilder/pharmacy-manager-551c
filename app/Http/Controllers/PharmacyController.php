<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\CashBook;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class PharmacyController extends Controller
{
    /**
     * Display the pharmacy dashboard.
     */
    public function index()
    {
        // Get dashboard statistics
        $totalProducts = Product::active()->count();
        $lowStockProducts = Product::lowStock()->active()->count();
        $totalCustomers = Customer::active()->count();
        $todaySales = Sale::whereDate('created_at', Carbon::today())->sum('total_amount');
        
        // Recent sales
        $recentSales = Sale::with(['customer', 'user'])
            ->latest()
            ->limit(5)
            ->get();
            
        // Low stock products
        $lowStockItems = Product::with('category')
            ->lowStock()
            ->active()
            ->limit(10)
            ->get();
            
        // Top selling products
        $topProducts = Product::with('category')
            ->whereHas('saleItems')
            ->withSum('saleItems', 'quantity')
            ->orderBy('sale_items_sum_quantity', 'desc')
            ->limit(5)
            ->get();

        return Inertia::render('pharmacy-dashboard', [
            'stats' => [
                'totalProducts' => $totalProducts,
                'lowStockProducts' => $lowStockProducts,
                'totalCustomers' => $totalCustomers,
                'todaySales' => number_format($todaySales, 2),
            ],
            'recentSales' => $recentSales,
            'lowStockItems' => $lowStockItems,
            'topProducts' => $topProducts,
        ]);
    }

    /**
     * Show sales management.
     */
    public function store(Request $request)
    {
        // This will handle various actions based on request type
        $action = $request->input('action');
        
        switch ($action) {
            case 'quick_sale':
                return $this->handleQuickSale($request);
            case 'add_stock':
                return $this->handleStockUpdate($request);
            case 'cash_entry':
                return $this->handleCashEntry($request);
            default:
                return back()->with('error', 'Invalid action');
        }
    }

    /**
     * Handle quick sale creation.
     */
    protected function handleQuickSale(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,card,transfer,credit',
        ]);

        // Create or find customer
        $customer = null;
        if ($request->customer_name) {
            $customer = Customer::firstOrCreate(
                ['name' => $request->customer_name],
                ['phone' => '', 'is_active' => true]
            );
        }

        // Generate invoice number
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad((string)(Sale::count() + 1), 4, '0', STR_PAD_LEFT);

        // Calculate totals
        $subtotal = 0;
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            $subtotal += $product->selling_price * $item['quantity'];
        }

        $total = $subtotal; // Add tax/discount logic here if needed

        // Create sale
        $sale = Sale::create([
            'invoice_number' => $invoiceNumber,
            'customer_id' => $customer?->id,
            'user_id' => auth()->id(),
            'subtotal' => $subtotal,
            'total_amount' => $total,
            'paid_amount' => $request->payment_method === 'credit' ? 0 : $total,
            'balance_amount' => $request->payment_method === 'credit' ? $total : 0,
            'payment_status' => $request->payment_method === 'credit' ? 'unpaid' : 'paid',
            'payment_method' => $request->payment_method,
            'sale_type' => 'general',
        ]);

        // Create sale items and update stock
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            
            // Create sale item
            $sale->items()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $product->selling_price,
                'total_price' => $product->selling_price * $item['quantity'],
            ]);

            // Update stock
            $previousStock = $product->stock_quantity;
            $product->decrement('stock_quantity', $item['quantity']);
            
            // Record stock movement
            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'out',
                'quantity' => $item['quantity'],
                'previous_stock' => $previousStock,
                'new_stock' => $previousStock - $item['quantity'],
                'reference_type' => 'sale',
                'reference_id' => $sale->id,
                'user_id' => auth()->id(),
            ]);
        }

        return back()->with('success', 'Sale created successfully! Invoice: ' . $invoiceNumber);
    }

    /**
     * Handle stock update.
     */
    protected function handleStockUpdate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:in,adjustment',
            'notes' => 'nullable|string',
        ]);

        $product = Product::find($request->product_id);
        $previousStock = $product->stock_quantity;
        
        if ($request->type === 'in') {
            $product->increment('stock_quantity', $request->quantity);
            $newStock = $previousStock + $request->quantity;
        } else {
            $product->update(['stock_quantity' => $request->quantity]);
            $newStock = $request->quantity;
        }

        // Record stock movement
        StockMovement::create([
            'product_id' => $product->id,
            'type' => $request->type,
            'quantity' => $request->type === 'in' ? $request->quantity : ($newStock - $previousStock),
            'previous_stock' => $previousStock,
            'new_stock' => $newStock,
            'reference_type' => 'adjustment',
            'notes' => $request->notes,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Stock updated successfully!');
    }

    /**
     * Handle cash book entry.
     */
    protected function handleCashEntry(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'nullable|string|max:255',
            'payment_method' => 'required|string|max:255',
        ]);

        CashBook::create([
            'transaction_date' => Carbon::today(),
            'description' => $request->description,
            'type' => $request->type,
            'amount' => $request->amount,
            'category' => $request->category,
            'payment_method' => $request->payment_method,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Cash entry recorded successfully!');
    }
}