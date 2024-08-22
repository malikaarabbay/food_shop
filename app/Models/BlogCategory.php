<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\BlogCategory
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Blog> $blogs
 * @property-read int|null $blogs_count
 * @method static Builder|BlogCategory active()
 * @method static Builder|BlogCategory newModelQuery()
 * @method static Builder|BlogCategory newQuery()
 * @method static Builder|BlogCategory query()
 * @method static Builder|BlogCategory whereCreatedAt($value)
 * @method static Builder|BlogCategory whereId($value)
 * @method static Builder|BlogCategory whereSlug($value)
 * @method static Builder|BlogCategory whereStatus($value)
 * @method static Builder|BlogCategory whereTitle($value)
 * @method static Builder|BlogCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BlogCategory extends Model
{
    use HasFactory;

    public $fillable = ['title', 'slug', 'status'];

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    /**
     * Get the blogs.
     */
    function blogs() : HasMany
    {
        return $this->hasMany(Blog::class, 'category_id', 'id');
    }
}
