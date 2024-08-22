<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Delivery
 *
 * @property int $id
 * @property string $area_name
 * @property string $min_delivery_time
 * @property string $max_delivery_time
 * @property float $delivery_fee
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Delivery active()
 * @method static Builder|Delivery newModelQuery()
 * @method static Builder|Delivery newQuery()
 * @method static Builder|Delivery query()
 * @method static Builder|Delivery whereAreaName($value)
 * @method static Builder|Delivery whereCreatedAt($value)
 * @method static Builder|Delivery whereDeliveryFee($value)
 * @method static Builder|Delivery whereId($value)
 * @method static Builder|Delivery whereMaxDeliveryTime($value)
 * @method static Builder|Delivery whereMinDeliveryTime($value)
 * @method static Builder|Delivery whereStatus($value)
 * @method static Builder|Delivery whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Delivery extends Model
{
    use HasFactory;

    protected $fillable = ['area_name', 'min_delivery_time', 'max_delivery_time', 'delivery_fee', 'status'];

    /**
     * Scope a query to only include active addresses.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }
}
