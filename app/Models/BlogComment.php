<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\BlogComment
 *
 * @property int $id
 * @property int $blog_id
 * @property int $user_id
 * @property string $comment
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Blog $blog
 * @property-read \App\Models\User|null $user
 * @method static Builder|BlogComment active()
 * @method static Builder|BlogComment newModelQuery()
 * @method static Builder|BlogComment newQuery()
 * @method static Builder|BlogComment query()
 * @method static Builder|BlogComment whereBlogId($value)
 * @method static Builder|BlogComment whereComment($value)
 * @method static Builder|BlogComment whereCreatedAt($value)
 * @method static Builder|BlogComment whereId($value)
 * @method static Builder|BlogComment whereStatus($value)
 * @method static Builder|BlogComment whereUpdatedAt($value)
 * @method static Builder|BlogComment whereUserId($value)
 * @mixin \Eloquent
 */
class BlogComment extends Model
{
    use HasFactory;

    const STATUS_APPROVED = 1;
    const STATUS_PENDING = 0;

    public $fillable = [
        'blog_id',
        'user_id',
        'comment',
        'status',
    ];

    /**
     * Get the blog that owns the blog comment.
     */
    function blog() : BelongsTo
    {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }

    /**
     * Get the user that owns the blog comment.
     */
    function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', self::STATUS_APPROVED);
    }
}
