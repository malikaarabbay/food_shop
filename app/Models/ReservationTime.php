<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReservationTime
 *
 * @property int $id
 * @property string $start_time
 * @property string $end_time
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|ReservationTime active()
 * @method static Builder|ReservationTime newModelQuery()
 * @method static Builder|ReservationTime newQuery()
 * @method static Builder|ReservationTime query()
 * @method static Builder|ReservationTime whereCreatedAt($value)
 * @method static Builder|ReservationTime whereEndTime($value)
 * @method static Builder|ReservationTime whereId($value)
 * @method static Builder|ReservationTime whereStartTime($value)
 * @method static Builder|ReservationTime whereStatus($value)
 * @method static Builder|ReservationTime whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReservationTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'status'
    ];

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }
}
