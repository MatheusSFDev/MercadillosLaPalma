<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\FleaMarket;
use App\Models\Stall;
use App\Models\Order;
use App\Models\Product;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
        'address',
        'phone_number',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
    
    public function fleaMarketsAsAdmin(): BelongsToMany
    {
        return $this->belongsToMany(
            FleaMarket::class,    // Modelo relacionado
            'administrators',     // Tabla pivot
            'user_id',            // FK del usuario en la pivot
            'flea_market_id'      // FK del mercadillo en la pivot
        );
    }

    public function stalls(): HasMany
    {
        return $this->hasMany(Stall::class);
    } 

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    } 

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    } 
}