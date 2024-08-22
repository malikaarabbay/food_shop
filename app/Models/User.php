<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ADMIN = 'admin';
    const USER = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the addresses.
     *
     * @return HasMany
     */
    public function addresses() : HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get the addresses by auth user.
     *
     * @return Collection
     */
    function getAddressesByUser() : Collection
    {
        return $this->addresses()->where('user_id', auth()->user()->id)->get();
    }

    /**
     * Get the orders
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    /**
     * Get the orders by auth user
     * @return HasMany
     */
    function ordersByUser() : HasMany
    {
        return $this->orders()->where('user_id', auth()->user()->id);
    }

    /**
     * Get orders by user
     * @return Collection
     */
    function getOrdersByUser() : Collection
    {
        return $this->ordersByUser()->get();
    }

    /**
     * Count orders by user.
     * @return int
     */
    function countOrdersByUser() : int
    {
        return $this->ordersByUser()->count();
    }

    /**
     * Check if super admin
     * @return bool
     */
    function isSuperAdmin() : bool
    {
        return $this->role == self::ADMIN && $this->id == 1;
    }

    /**
     * Check if admin
     * @return bool
     */
    function isAdmin() : bool
    {
        return $this->role == self::ADMIN;
    }

    /**
     * Check if user
     * @return bool
     */
    function isUser() : bool
    {
        return $this->role == self::USER;
    }
}
