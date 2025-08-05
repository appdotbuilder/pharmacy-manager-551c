import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

interface Product {
    id: number;
    name: string;
    sku: string;
    category: {
        name: string;
    };
    stock_quantity: number;
    minimum_stock: number;
    selling_price: number;
    unit: string;
}

interface Sale {
    id: number;
    invoice_number: string;
    total_amount: number;
    payment_method: string;
    customer?: {
        name: string;
    };
    user: {
        name: string;
    };
    created_at: string;
}

interface Props {
    stats: {
        totalProducts: number;
        lowStockProducts: number;
        totalCustomers: number;
        todaySales: string;
    };
    recentSales: Sale[];
    lowStockItems: Product[];
    topProducts: Product[];
    [key: string]: unknown;
}

export default function PharmacyDashboard({ 
    stats, 
    recentSales, 
    lowStockItems, 
    topProducts 
}: Props) {
    const [showQuickSale, setShowQuickSale] = useState(false);
    const [showStockUpdate, setShowStockUpdate] = useState(false);
    const [showCashEntry, setShowCashEntry] = useState(false);
    const [quickSaleData, setQuickSaleData] = useState({
        customer_name: '',
        items: [{ product_id: '', quantity: 1 }],
        payment_method: 'cash'
    });
    const [stockData, setStockData] = useState({
        product_id: '',
        quantity: 0,
        type: 'in',
        notes: ''
    });
    const [cashData, setCashData] = useState({
        description: '',
        type: 'income',
        amount: 0,
        category: '',
        payment_method: 'cash'
    });

    const handleQuickSale = () => {
        router.post('/', {
            action: 'quick_sale',
            ...quickSaleData
        }, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                setShowQuickSale(false);
                setQuickSaleData({
                    customer_name: '',
                    items: [{ product_id: '', quantity: 1 }],
                    payment_method: 'cash'
                });
            }
        });
    };

    const handleStockUpdate = () => {
        router.post('/', {
            action: 'add_stock',
            ...stockData
        }, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                setShowStockUpdate(false);
                setStockData({
                    product_id: '',
                    quantity: 0,
                    type: 'in',
                    notes: ''
                });
            }
        });
    };

    const handleCashEntry = () => {
        router.post('/', {
            action: 'cash_entry',
            ...cashData
        }, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                setShowCashEntry(false);
                setCashData({
                    description: '',
                    type: 'income',
                    amount: 0,
                    category: '',
                    payment_method: 'cash'
                });
            }
        });
    };

    const addSaleItem = () => {
        setQuickSaleData(prev => ({
            ...prev,
            items: [...prev.items, { product_id: '', quantity: 1 }]
        }));
    };

    const removeSaleItem = (index: number) => {
        setQuickSaleData(prev => ({
            ...prev,
            items: prev.items.filter((_, i) => i !== index)
        }));
    };

    const updateSaleItem = (index: number, field: string, value: string | number) => {
        setQuickSaleData(prev => ({
            ...prev,
            items: prev.items.map((item, i) => 
                i === index ? { ...item, [field]: value } : item
            )
        }));
    };

    return (
        <AppShell>
            <Head title="Pharmacy Dashboard" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex justify-between items-center">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white">
                            🏥 Pharmacy Dashboard
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400 mt-1">
                            Manage your pharmacy operations efficiently
                        </p>
                    </div>
                    <div className="flex space-x-3">
                        <button
                            onClick={() => setShowQuickSale(true)}
                            className="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                        >
                            💰 Quick Sale
                        </button>
                        <button
                            onClick={() => setShowStockUpdate(true)}
                            className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                        >
                            📦 Update Stock
                        </button>
                        <button
                            onClick={() => setShowCashEntry(true)}
                            className="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                        >
                            💳 Cash Entry
                        </button>
                    </div>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                        <div className="flex items-center">
                            <div className="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <span className="text-2xl">📦</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Products</p>
                                <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats.totalProducts}</p>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                        <div className="flex items-center">
                            <div className="p-2 bg-red-100 dark:bg-red-900 rounded-lg">
                                <span className="text-2xl">⚠️</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Low Stock Items</p>
                                <p className="text-2xl font-bold text-red-600">{stats.lowStockProducts}</p>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                        <div className="flex items-center">
                            <div className="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                                <span className="text-2xl">👥</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Customers</p>
                                <p className="text-2xl font-bold text-gray-900 dark:text-white">{stats.totalCustomers}</p>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                        <div className="flex items-center">
                            <div className="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                                <span className="text-2xl">💰</span>
                            </div>
                            <div className="ml-4">
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Today's Sales</p>
                                <p className="text-2xl font-bold text-gray-900 dark:text-white">${stats.todaySales}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Main Content Grid */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Recent Sales */}
                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            📊 Recent Sales
                        </h3>
                        <div className="space-y-3">
                            {recentSales.map((sale) => (
                                <div key={sale.id} className="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <p className="font-medium text-gray-900 dark:text-white">
                                            {sale.invoice_number}
                                        </p>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">
                                            {sale.customer?.name || 'Walk-in Customer'} • {sale.payment_method}
                                        </p>
                                    </div>
                                    <div className="text-right">
                                        <p className="font-medium text-green-600">${sale.total_amount}</p>
                                        <p className="text-xs text-gray-500">
                                            {new Date(sale.created_at).toLocaleDateString()}
                                        </p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Low Stock Alert */}
                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            ⚠️ Low Stock Alert
                        </h3>
                        <div className="space-y-3">
                            {lowStockItems.map((product) => (
                                <div key={product.id} className="flex justify-between items-center p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                                    <div>
                                        <p className="font-medium text-gray-900 dark:text-white">
                                            {product.name}
                                        </p>
                                        <p className="text-sm text-gray-600 dark:text-gray-400">
                                            {product.category.name} • SKU: {product.sku}
                                        </p>
                                    </div>
                                    <div className="text-right">
                                        <p className="font-medium text-red-600">
                                            {product.stock_quantity} {product.unit}
                                        </p>
                                        <p className="text-xs text-gray-500">
                                            Min: {product.minimum_stock} {product.unit}
                                        </p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>

                {/* Top Products */}
                <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        🔥 Top Selling Products
                    </h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        {topProducts.map((product) => (
                            <div key={product.id} className="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h4 className="font-medium text-gray-900 dark:text-white">
                                    {product.name}
                                </h4>
                                <p className="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    ${product.selling_price} • Stock: {product.stock_quantity}
                                </p>
                                <div className="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                    <div 
                                        className="bg-blue-600 h-2 rounded-full"
                                        style={{ width: '75%' }}
                                    ></div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>

            {/* Quick Sale Modal */}
            {showQuickSale && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            💰 Quick Sale
                        </h3>
                        <div className="space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Customer Name (Optional)
                                </label>
                                <input
                                    type="text"
                                    value={quickSaleData.customer_name}
                                    onChange={(e) => setQuickSaleData(prev => ({ ...prev, customer_name: e.target.value }))}
                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                    placeholder="Enter customer name"
                                />
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Items
                                </label>
                                {quickSaleData.items.map((item, index) => (
                                    <div key={index} className="flex space-x-2 mb-2">
                                        <input
                                            type="text"
                                            placeholder="Product ID"
                                            value={item.product_id}
                                            onChange={(e) => updateSaleItem(index, 'product_id', e.target.value)}
                                            className="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                        />
                                        <input
                                            type="number"
                                            placeholder="Qty"
                                            value={item.quantity}
                                            onChange={(e) => updateSaleItem(index, 'quantity', parseInt(e.target.value) || 1)}
                                            className="w-20 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                            min="1"
                                        />
                                        {quickSaleData.items.length > 1 && (
                                            <button
                                                onClick={() => removeSaleItem(index)}
                                                className="px-2 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md"
                                            >
                                                ❌
                                            </button>
                                        )}
                                    </div>
                                ))}
                                <button
                                    onClick={addSaleItem}
                                    className="text-blue-600 hover:text-blue-700 text-sm font-medium"
                                >
                                    + Add Item
                                </button>
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Payment Method
                                </label>
                                <select
                                    value={quickSaleData.payment_method}
                                    onChange={(e) => setQuickSaleData(prev => ({ ...prev, payment_method: e.target.value }))}
                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                >
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="credit">Credit</option>
                                </select>
                            </div>
                        </div>

                        <div className="flex space-x-3 mt-6">
                            <button
                                onClick={handleQuickSale}
                                className="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                            >
                                Create Sale
                            </button>
                            <button
                                onClick={() => setShowQuickSale(false)}
                                className="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* Stock Update Modal */}
            {showStockUpdate && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            📦 Update Stock
                        </h3>
                        <div className="space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Product ID
                                </label>
                                <input
                                    type="text"
                                    value={stockData.product_id}
                                    onChange={(e) => setStockData(prev => ({ ...prev, product_id: e.target.value }))}
                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                    placeholder="Enter product ID"
                                />
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Type
                                </label>
                                <select
                                    value={stockData.type}
                                    onChange={(e) => setStockData(prev => ({ ...prev, type: e.target.value }))}
                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                >
                                    <option value="in">Stock In</option>
                                    <option value="adjustment">Adjustment</option>
                                </select>
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Quantity
                                </label>
                                <input
                                    type="number"
                                    value={stockData.quantity}
                                    onChange={(e) => setStockData(prev => ({ ...prev, quantity: parseInt(e.target.value) || 0 }))}
                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                    min="0"
                                />
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Notes
                                </label>
                                <textarea
                                    value={stockData.notes}
                                    onChange={(e) => setStockData(prev => ({ ...prev, notes: e.target.value }))}
                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                    rows={3}
                                    placeholder="Optional notes"
                                />
                            </div>
                        </div>

                        <div className="flex space-x-3 mt-6">
                            <button
                                onClick={handleStockUpdate}
                                className="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                            >
                                Update Stock
                            </button>
                            <button
                                onClick={() => setShowStockUpdate(false)}
                                className="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* Cash Entry Modal */}
            {showCashEntry && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            💳 Cash Book Entry
                        </h3>
                        <div className="space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Description
                                </label>
                                <input
                                    type="text"
                                    value={cashData.description}
                                    onChange={(e) => setCashData(prev => ({ ...prev, description: e.target.value }))}
                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                    placeholder="Enter description"
                                />
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Type
                                </label>
                                <select
                                    value={cashData.type}
                                    onChange={(e) => setCashData(prev => ({ ...prev, type: e.target.value }))}
                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                >
                                    <option value="income">Income</option>
                                    <option value="expense">Expense</option>
                                </select>
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Amount
                                </label>
                                <input
                                    type="number"
                                    step="0.01"
                                    value={cashData.amount}
                                    onChange={(e) => setCashData(prev => ({ ...prev, amount: parseFloat(e.target.value) || 0 }))}
                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                    min="0"
                                />
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Category
                                </label>
                                <input
                                    type="text"
                                    value={cashData.category}
                                    onChange={(e) => setCashData(prev => ({ ...prev, category: e.target.value }))}
                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                    placeholder="e.g., Sales, Utilities, etc."
                                />
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Payment Method
                                </label>
                                <select
                                    value={cashData.payment_method}
                                    onChange={(e) => setCashData(prev => ({ ...prev, payment_method: e.target.value }))}
                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                >
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="transfer">Bank Transfer</option>
                                    <option value="check">Check</option>
                                </select>
                            </div>
                        </div>

                        <div className="flex space-x-3 mt-6">
                            <button
                                onClick={handleCashEntry}
                                className="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                            >
                                Add Entry
                            </button>
                            <button
                                onClick={() => setShowCashEntry(false)}
                                className="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </AppShell>
    );
}