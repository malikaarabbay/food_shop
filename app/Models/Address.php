<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property int $user_id
 * @property int $delivery_id
 * @property string $firstname
 * @property string|null $lastname
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Delivery $delivery
 * @method static Builder|Address byAuthUser()
 * @method static Builder|Address newModelQuery()
 * @method static Builder|Address newQuery()
 * @method static Builder|Address query()
 * @method static Builder|Address whereAddress($value)
 * @method static Builder|Address whereCreatedAt($value)
 * @method static Builder|Address whereDeliveryId($value)
 * @method static Builder|Address whereEmail($value)
 * @method static Builder|Address whereFirstname($value)
 * @method static Builder|Address whereId($value)
 * @method static Builder|Address whereLastname($value)
 * @method static Builder|Address wherePhone($value)
 * @method static Builder|Address whereType($value)
 * @method static Builder|Address whereUpdatedAt($value)
 * @method static Builder|Address whereUserId($value)
 * @mixin \Eloquent
 */
class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'delivery_id',
        'firstname',
        'lastname',
        'email',
        'phone',
        'address',
        'type',
    ];

    /**
     * Get the delivery area that owns the address.
     */
    function delivery() : BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    /**
     * Scope a query to only include logged user's addresses.
     */
    public function scopeByAuthUser(Builder $query): void
    {
        $query->where('user_id', auth()->user()->id);
    }
}
