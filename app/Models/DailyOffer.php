<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\DailyOffer
 *
 * @property int $id
 * @property int $product_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static Builder|DailyOffer active()
 * @method static Builder|DailyOffer newModelQuery()
 * @method static Builder|DailyOffer newQuery()
 * @method static Builder|DailyOffer query()
 * @method static Builder|DailyOffer whereCreatedAt($value)
 * @method static Builder|DailyOffer whereId($value)
 * @method static Builder|DailyOffer whereProductId($value)
 * @method static Builder|DailyOffer whereStatus($value)
 * @method static Builder|DailyOffer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DailyOffer extends Model
{
    use HasFactory;

    public $fillable = ['product_id', 'status'];

    /**
     * Get the product that owns the daily offer.
     */
    function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope a query to only include active daily offers.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }
}
