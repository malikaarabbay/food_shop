<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderPlacedNotification
 *
 * @property int $id
 * @property string $message
 * @property int $order_id
 * @property int $seen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPlacedNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPlacedNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPlacedNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPlacedNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPlacedNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPlacedNotification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPlacedNotification whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPlacedNotification whereSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPlacedNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderPlacedNotification extends Model
{
    use HasFactory;

    protected $fillable = ['seen'];
}
