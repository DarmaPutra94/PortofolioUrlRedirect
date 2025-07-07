<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UrlShort extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'short_code',
        'access_count'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
