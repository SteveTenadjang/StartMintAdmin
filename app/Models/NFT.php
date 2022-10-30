<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class NFT extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author_name','media_link','media_type','title',
        'max_quantity','price','description','blockchain_type',
        'created_by'
    ];

    public function creator():BelongsTo
    { return $this->belongsTo(User::class, 'created_by'); }
}
