<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Slider
 *
 * @property int $id
 * @property string $image
 * @property string $title
 * @property string $sub_title
 * @property string $offer
 * @property string $short_description
 * @property string $button_link
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Slider active()
 * @method static \Database\Factories\SliderFactory factory($count = null, $state = [])
 * @method static Builder|Slider newModelQuery()
 * @method static Builder|Slider newQuery()
 * @method static Builder|Slider query()
 * @method static Builder|Slider whereButtonLink($value)
 * @method static Builder|Slider whereCreatedAt($value)
 * @method static Builder|Slider whereId($value)
 * @method static Builder|Slider whereImage($value)
 * @method static Builder|Slider whereOffer($value)
 * @method static Builder|Slider whereShortDescription($value)
 * @method static Builder|Slider whereStatus($value)
 * @method static Builder|Slider whereSubTitle($value)
 * @method static Builder|Slider whereTitle($value)
 * @method static Builder|Slider whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Slider extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'title', 'sub_title', 'offer', 'short_description', 'button_link', 'status'];

    /**
     * Scope a query to only include active sliders.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }
}
