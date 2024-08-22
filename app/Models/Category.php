<?php

namespace App\Models;

use App\Http\Requests\Admin\CategoryCreateRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Str;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property int $status
 * @property int $show_at_home
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static Builder|Category active()
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category showAtHome()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereShowAtHome($value)
 * @method static Builder|Category whereSlug($value)
 * @method static Builder|Category whereStatus($value)
 * @method static Builder|Category whereTitle($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'status', 'show_at_home'];

    /**
     * Get the products.
     */
    public function products() : HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the products at home page.
     */
    function productsAtHome()
    {
        return $this->products()->where(['show_at_home' => 1, 'status' => 1])
            ->orderBy('id', 'DESC')->take(8)
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    /**
     * Scope a query to only include home page categories.
     */
    public function scopeShowAtHome(Builder $query): void
    {
        $query->where('show_at_home', 1);
    }
}
