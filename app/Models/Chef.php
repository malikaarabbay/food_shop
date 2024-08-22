<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Chef
 *
 * @property int $id
 * @property string $image
 * @property string $name
 * @property string $title
 * @property string|null $fb
 * @property string|null $in
 * @property string|null $x
 * @property string|null $web
 * @property int $show_at_home
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Chef active()
 * @method static Builder|Chef newModelQuery()
 * @method static Builder|Chef newQuery()
 * @method static Builder|Chef query()
 * @method static Builder|Chef showAtHome()
 * @method static Builder|Chef whereCreatedAt($value)
 * @method static Builder|Chef whereFb($value)
 * @method static Builder|Chef whereId($value)
 * @method static Builder|Chef whereImage($value)
 * @method static Builder|Chef whereIn($value)
 * @method static Builder|Chef whereName($value)
 * @method static Builder|Chef whereShowAtHome($value)
 * @method static Builder|Chef whereStatus($value)
 * @method static Builder|Chef whereTitle($value)
 * @method static Builder|Chef whereUpdatedAt($value)
 * @method static Builder|Chef whereWeb($value)
 * @method static Builder|Chef whereX($value)
 * @mixin \Eloquent
 */
class Chef extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'title',
        'fb',
        'in',
        'x',
        'web',
        'show_at_home',
        'status',
    ];

    /**
     * Scope a query to only include active chefs.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    /**
     * Scope a query to only include home page chefs.
     */
    public function scopeShowAtHome(Builder $query): void
    {
        $query->where('show_at_home', 1);
    }
}
