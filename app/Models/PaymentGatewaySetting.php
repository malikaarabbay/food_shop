<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentGatewaySetting
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewaySetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewaySetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewaySetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewaySetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewaySetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewaySetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewaySetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewaySetting whereValue($value)
 * @mixin \Eloquent
 */
class PaymentGatewaySetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];
}
