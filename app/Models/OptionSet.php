<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\OptionSet
 *
 * @property int $id
 * @property int $option_id
 * @property string $title
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Option $option
 * @method static \Illuminate\Database\Eloquent\Builder|OptionSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OptionSet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OptionSet query()
 * @method static \Illuminate\Database\Eloquent\Builder|OptionSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionSet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionSet whereOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionSet wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionSet whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionSet whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OptionSet extends Model
{
    use HasFactory;

    protected $fillable = ['option_id', 'title', 'price'];

    /**
     * Get the option that owns the option set.
     */
    function option() : BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
