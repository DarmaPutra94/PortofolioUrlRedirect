<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
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

    public function generateAccessToken()
    {
        return $this->createToken('accessToken', ['*'], Carbon::now()->addHour());
    }

    public function generatePlainTextAccessToken()
    {
        return $this->generateAccessToken()->plainTextToken;
    }

    public function generateRefreshToken()
    {
        return $this->createToken('refreshToken', ['auth:refresh'], Carbon::now()->addDays(7));
    }

    public function generatePlainTextRefreshToken()
    {
        return $this->generateRefreshToken()->plainTextToken;
    }


    public function shortUrls() : HasMany{
        return $this->hasMany(UrlShort::class);
    }
}
