<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CashBook
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $transaction_date
 * @property string $description
 * @property string $type
 * @property float $amount
 * @property string|null $category
 * @property string|null $reference_number
 * @property string $payment_method
 * @property string|null $notes
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook whereTransactionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook income()
 * @method static \Illuminate\Database\Eloquent\Builder|CashBook expense()
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class CashBook extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cash_book';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'transaction_date',
        'description',
        'type',
        'amount',
        'category',
        'reference_number',
        'payment_method',
        'notes',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that created the cash book entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include income entries.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    /**
     * Scope a query to only include expense entries.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }
}