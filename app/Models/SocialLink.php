<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SocialLink
 *
 * @property int $id
 * @property string $icon
 * @property string $name
 * @property string $link
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|SocialLink active()
 * @method static Builder|SocialLink newModelQuery()
 * @method static Builder|SocialLink newQuery()
 * @method static Builder|SocialLink query()
 * @method static Builder|SocialLink whereCreatedAt($value)
 * @method static Builder|SocialLink whereIcon($value)
 * @method static Builder|SocialLink whereId($value)
 * @method static Builder|SocialLink whereLink($value)
 * @method static Builder|SocialLink whereName($value)
 * @method static Builder|SocialLink whereStatus($value)
 * @method static Builder|SocialLink whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'name',
        'link',
        'status'
    ];

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }
}
