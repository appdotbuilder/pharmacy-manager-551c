<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Purchase
 *
 * @property int $id
 * @property string $invoice_number
 * @property string $supplier_name
 * @property string|null $supplier_contact
 * @property float $total_amount
 * @property float $paid_amount
 * @property float $balance_amount
 * @property string $payment_status
 * @property \Illuminate\Support\Carbon $purchase_date
 * @property \Illuminate\Support\Carbon|null $due_date
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseItem> $items
 * @property-read int|null $items_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase query()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereBalanceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase wherePurchaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereSupplierContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereSupplierName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Purchase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'invoice_number',
        'supplier_name',
        'supplier_contact',
        'total_amount',
        'paid_amount',
        'balance_amount',
        'payment_status',
        'purchase_date',
        'due_date',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance_amount' => 'decimal:2',
        'purchase_date' => 'date',
        'due_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the items for the purchase.
     */
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }
}