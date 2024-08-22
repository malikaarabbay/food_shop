<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Counter
 *
 * @property int $id
 * @property string $background
 * @property string $counter_icon_one
 * @property string $counter_count_one
 * @property string $counter_name_one
 * @property string $counter_icon_two
 * @property string $counter_count_two
 * @property string $counter_name_two
 * @property string $counter_icon_three
 * @property string $counter_count_three
 * @property string $counter_name_three
 * @property string $counter_icon_four
 * @property string $counter_count_four
 * @property string $counter_name_four
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Counter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Counter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Counter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterCountFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterCountOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterCountThree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterCountTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterIconFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterIconOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterIconThree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterIconTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterNameFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterNameOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterNameThree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterNameTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Counter extends Model
{
    use HasFactory;

    public $fillable = [
        'background',
        'counter_icon_one',
        'counter_count_one',
        'counter_name_one',
        'counter_icon_two',
        'counter_count_two',
        'counter_name_two',
        'counter_icon_three',
        'counter_count_three',
        'counter_name_three',
        'counter_icon_four',
        'counter_count_four',
        'counter_name_four',
    ];
}
