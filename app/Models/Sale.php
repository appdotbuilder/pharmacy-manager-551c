<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Sale
 *
 * @property int $id
 * @property string $invoice_number
 * @property int|null $customer_id
 * @property int $user_id
 * @property float $subtotal
 * @property float $tax_amount
 * @property float $discount_amount
 * @property float $total_amount
 * @property float $paid_amount
 * @property float $balance_amount
 * @property string $payment_status
 * @property string $payment_method
 * @property string $sale_type
 * @property bool $is_return
 * @property int|null $original_sale_id
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer|null $customer
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Sale|null $originalSale
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SaleItem> $items
 * @property-read int|null $items_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Sale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereBalanceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereIsReturn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereOriginalSaleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereSaleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'invoice_number',
        'customer_id',
        'user_id',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'paid_amount',
        'balance_amount',
        'payment_status',
        'payment_method',
        'sale_type',
        'is_return',
        'original_sale_id',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance_amount' => 'decimal:2',
        'is_return' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the customer that owns the sale.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user that created the sale.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the original sale (for returns).
     */
    public function originalSale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'original_sale_id');
    }

    /**
     * Get the items for the sale.
     */
    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}