<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bundle extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name','limit'];

    public function users(): BelongsToMany
    { return $this->belongsToMany(User::class,'user_bundle'); }

    public function userBundle(): BelongsTo
    { return $this->belongsTo(UserBundle::class); }

    public function userBundles(): HasMany
    { return $this->hasMany(UserBundle::class); }
}
