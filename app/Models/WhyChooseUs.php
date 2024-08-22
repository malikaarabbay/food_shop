<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WhyChooseUs
 *
 * @property int $id
 * @property string $icon
 * @property string $title
 * @property string $short_description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|WhyChooseUs active()
 * @method static \Database\Factories\WhyChooseUsFactory factory($count = null, $state = [])
 * @method static Builder|WhyChooseUs newModelQuery()
 * @method static Builder|WhyChooseUs newQuery()
 * @method static Builder|WhyChooseUs query()
 * @method static Builder|WhyChooseUs whereCreatedAt($value)
 * @method static Builder|WhyChooseUs whereIcon($value)
 * @method static Builder|WhyChooseUs whereId($value)
 * @method static Builder|WhyChooseUs whereShortDescription($value)
 * @method static Builder|WhyChooseUs whereStatus($value)
 * @method static Builder|WhyChooseUs whereTitle($value)
 * @method static Builder|WhyChooseUs whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WhyChooseUs extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Scope a query to only include active items.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }
}
