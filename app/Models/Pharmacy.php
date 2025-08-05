<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pharmacy
 *
 * @property int $id
 * @property string $name
 * @property string $license_number
 * @property string|null $phone
 * @property string|null $email
 * @property string $address
 * @property string $owner_name
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereLicenseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacy active()
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Pharmacy extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'license_number',
        'phone',
        'email',
        'address',
        'owner_name',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active pharmacies.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}