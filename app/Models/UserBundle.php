<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBundle extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'bundle_id','status'];

    public function user(): BelongsTo
    { return $this->belongsTo(User::class); }

    public function bundle(): BelongsTo
    { return $this->belongsTo(Bundle::class); }
}
