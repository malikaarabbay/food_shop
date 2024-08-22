<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $title
 * @property int $category_id
 * @property string $image
 * @property string $short_description
 * @property string $description
 * @property float $price
 * @property float $offer_price
 * @property int $quantity
 * @property string|null $sku
 * @property string $slug
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property int $show_at_home
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Option> $options
 * @property-read int|null $options_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductGallery> $productImages
 * @property-read int|null $product_images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductRating> $reviews
 * @property-read int|null $reviews_count
 * @method static Builder|Product active()
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product showAtHome()
 * @method static Builder|Product whereCategoryId($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereImage($value)
 * @method static Builder|Product whereOfferPrice($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereQuantity($value)
 * @method static Builder|Product whereSeoDescription($value)
 * @method static Builder|Product whereSeoTitle($value)
 * @method static Builder|Product whereShortDescription($value)
 * @method static Builder|Product whereShowAtHome($value)
 * @method static Builder|Product whereSku($value)
 * @method static Builder|Product whereSlug($value)
 * @method static Builder|Product whereStatus($value)
 * @method static Builder|Product whereTitle($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'image',
        'short_description',
        'description',
        'price',
        'offer_price',
        'quantity',
        'sku',
        'slug',
        'seo_title',
        'seo_description',
        'status',
        'show_at_home',
    ];

    /**
     * Get the category that owns the product.
     */
    function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The options that belong to the product.
     */
    function options() : BelongsToMany
    {
        return $this->belongsToMany(Option::class, 'product_options');
    }

    /**
     * Get the product images.
     */
    function productImages() : HasMany
    {
        return $this->hasMany(ProductGallery::class);
    }

    /**
     * Get the reviews for the product.
     */
    function reviews() : HasMany
    {
        return $this->hasMany(ProductRating::class, 'product_id', 'id');
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
