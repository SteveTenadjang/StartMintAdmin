<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'wallet','status'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token',];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = ['email_verified_at' => 'datetime',];

    public function NFTs(): HasMany
    { return $this->hasMany(NFT::class,'created_by'); }

    public function bundle(): BelongsToMany
    { return $this->belongsToMany(Bundle::class,'user_bundle'); }

    public function userBundles(): HasMany
    { return $this->hasMany(UserBundle::class); }

    public function canCreatedToday(): bool
    {
        return $this->nfts()
            ->whereDay('created_at', date("d"))->count() < 1;
    }
    public function canCreate(): bool
    {
        $bundle = $this->bundle()->first();
        $date = Carbon::now()->subDays($bundle['duration']);
        return $this->nfts()
            ->whereBetween('created_at',[$date,date("d")])
            ->count() < $bundle['limit'];
    }

    public function isFreeAccount(): bool
    { return $this->bundle()->get()->pluck('id')[0] === 1; }
}
