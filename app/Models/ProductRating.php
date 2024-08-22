<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ProductRating
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $rating
 * @property string $review
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User $user
 * @method static Builder|ProductRating authUser()
 * @method static Builder|ProductRating newModelQuery()
 * @method static Builder|ProductRating newQuery()
 * @method static Builder|ProductRating query()
 * @method static Builder|ProductRating whereCreatedAt($value)
 * @method static Builder|ProductRating whereId($value)
 * @method static Builder|ProductRating whereProductId($value)
 * @method static Builder|ProductRating whereRating($value)
 * @method static Builder|ProductRating whereReview($value)
 * @method static Builder|ProductRating whereStatus($value)
 * @method static Builder|ProductRating whereUpdatedAt($value)
 * @method static Builder|ProductRating whereUserId($value)
 * @mixin \Eloquent
 */
class ProductRating extends Model
{
    use HasFactory;

    const STATUS_APPROVED = 1;
    const STATUS_PENDING = 0;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'review',
        'status',
    ];

    /**
     * Get the user that owns the product rating.
     */
    function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the product that owns the product rating.
     */
    function product() : BelongsTo {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * Scope a query to only include logged user wishlists.
     *
     * @param Builder $query
     */
    public function scopeAuthUser(Builder $query): void
    {
        $query->where('user_id', auth()->user()->id);
    }
}
