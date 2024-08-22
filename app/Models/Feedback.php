<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Feedback
 *
 * @property int $id
 * @property string $image
 * @property string $name
 * @property string $title
 * @property string $review
 * @property int $rating
 * @property int $show_at_home
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Feedback active()
 * @method static Builder|Feedback newModelQuery()
 * @method static Builder|Feedback newQuery()
 * @method static Builder|Feedback query()
 * @method static Builder|Feedback showAtHome()
 * @method static Builder|Feedback whereCreatedAt($value)
 * @method static Builder|Feedback whereId($value)
 * @method static Builder|Feedback whereImage($value)
 * @method static Builder|Feedback whereName($value)
 * @method static Builder|Feedback whereRating($value)
 * @method static Builder|Feedback whereReview($value)
 * @method static Builder|Feedback whereShowAtHome($value)
 * @method static Builder|Feedback whereStatus($value)
 * @method static Builder|Feedback whereTitle($value)
 * @method static Builder|Feedback whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'title',
        'review',
        'rating',
        'show_at_home',
        'status',
    ];

    /**
     * Scope a query to only include active feedbacks.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    /**
     * Scope a query to only include home page feedbacks.
     */
    public function scopeShowAtHome(Builder $query): void
    {
        $query->where('show_at_home', 1);
    }
}
