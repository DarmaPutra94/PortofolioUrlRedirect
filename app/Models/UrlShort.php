<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UrlShort extends Model
{
    protected $fillable = [
        'url',
        'url_hash',
        'short_url',
        'access_count'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
