<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Reservation
 *
 * @property int $id
 * @property string $reservation_id
 * @property int $user_id
 * @property string $name
 * @property string $phone
 * @property string $date
 * @property string $time
 * @property int $persons
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Reservation active()
 * @method static Builder|Reservation authUser()
 * @method static Builder|Reservation newModelQuery()
 * @method static Builder|Reservation newQuery()
 * @method static Builder|Reservation query()
 * @method static Builder|Reservation whereCreatedAt($value)
 * @method static Builder|Reservation whereDate($value)
 * @method static Builder|Reservation whereId($value)
 * @method static Builder|Reservation whereName($value)
 * @method static Builder|Reservation wherePersons($value)
 * @method static Builder|Reservation wherePhone($value)
 * @method static Builder|Reservation whereReservationId($value)
 * @method static Builder|Reservation whereStatus($value)
 * @method static Builder|Reservation whereTime($value)
 * @method static Builder|Reservation whereUpdatedAt($value)
 * @method static Builder|Reservation whereUserId($value)
 * @mixin \Eloquent
 */
class Reservation extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_COMPLETE = 'complete';
    const STATUS_CANCEL = 'cancel';

    protected $fillable = [
        'reservation_id',
        'user_id',
        'name',
        'phone',
        'date',
        'time',
        'persons',
        'status'
    ];

    /**
     * Scope a query to only include active categories.
     *
     * @param Builder $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    /**
     * Scope a query to only include logged user reservations.
     *
     * @param Builder $query
     */
    public function scopeAuthUser(Builder $query): void
    {
        $query->where('user_id', auth()->user()->id);
    }
}
