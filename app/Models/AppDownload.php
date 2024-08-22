<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AppDownload
 *
 * @property int $id
 * @property string $image
 * @property string $background
 * @property string $title
 * @property string $short_description
 * @property string|null $play_store_link
 * @property string|null $apple_store_link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AppDownload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppDownload newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppDownload query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppDownload whereAppleStoreLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppDownload whereBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppDownload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppDownload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppDownload whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppDownload wherePlayStoreLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppDownload whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppDownload whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppDownload whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'background',
        'title',
        'short_description',
        'play_store_link',
        'apple_store_link'
    ];
}
