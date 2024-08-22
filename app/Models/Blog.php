<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Blog
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property string $image
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BlogCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BlogComment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\User $user
 * @method static Builder|Blog active()
 * @method static Builder|Blog newModelQuery()
 * @method static Builder|Blog newQuery()
 * @method static Builder|Blog query()
 * @method static Builder|Blog whereCategoryId($value)
 * @method static Builder|Blog whereCreatedAt($value)
 * @method static Builder|Blog whereDescription($value)
 * @method static Builder|Blog whereId($value)
 * @method static Builder|Blog whereImage($value)
 * @method static Builder|Blog whereSeoDescription($value)
 * @method static Builder|Blog whereSeoTitle($value)
 * @method static Builder|Blog whereSlug($value)
 * @method static Builder|Blog whereStatus($value)
 * @method static Builder|Blog whereTitle($value)
 * @method static Builder|Blog whereUpdatedAt($value)
 * @method static Builder|Blog whereUserId($value)
 * @mixin \Eloquent
 */
class Blog extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'category_id',
        'image',
        'title',
        'slug',
        'description',
        'seo_title',
        'seo_description',
        'status',
    ];

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    /**
     * Get the user that owns the blog.
     */
    function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the blog.
     */
    function category() : BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     * Get the blog comments.
     */
    function comments() : HasMany
    {
        return $this->hasMany(BlogComment::class, 'blog_id', 'id');
    }
}
