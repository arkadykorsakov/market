<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function roles(): BelongsToMany
    {
        return  $this->belongsToMany(Role::class);
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->roles->contains('title', RoleEnum::ADMIN->value);
    }

    public function carts(): HasMany
    {
        return  $this->hasMany(Cart::class, 'user_id', 'id')->whereNull('order_id');
    }

    public function getCartsTotalSumAttribute(): int
    {
        return $this->carts->sum('total_sum');
    }


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_user_cards')->wherePivotNull('order_id');
    }


    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}