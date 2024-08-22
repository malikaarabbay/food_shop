<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Banner
 *
 * @property int $id
 * @property string $title
 * @property string $sub_title
 * @property string $url
 * @property string $banner
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Banner active()
 * @method static Builder|Banner newModelQuery()
 * @method static Builder|Banner newQuery()
 * @method static Builder|Banner query()
 * @method static Builder|Banner whereBanner($value)
 * @method static Builder|Banner whereCreatedAt($value)
 * @method static Builder|Banner whereId($value)
 * @method static Builder|Banner whereStatus($value)
 * @method static Builder|Banner whereSubTitle($value)
 * @method static Builder|Banner whereTitle($value)
 * @method static Builder|Banner whereUpdatedAt($value)
 * @method static Builder|Banner whereUrl($value)
 * @mixin \Eloquent
 */
class Banner extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'sub_title', 'status', 'url', 'banner'];

    /**
     * Scope a query to only include active banners.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }
}
