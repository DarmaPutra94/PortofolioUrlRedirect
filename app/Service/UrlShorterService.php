<?php

namespace App\Service;

use App\Models\UrlShort;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UrlShorterService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function hashUrl($url){
        $hashed_url = Hash::make("sha256", $url);
        return $hashed_url;
    }

    public function generateShortUrlCode(){
        do {
            $code = Str::random(4);
        } while (UrlShort::where('short_code', $code)->exists());
        return $code;
    }

    public function storeUrl(User $user, $data){
        $user->shortUrls()->create($data);
        return $user->shortUrls;
    }

    public function updateUrl($shortcode, $data){
        $short_url = UrlShort::where("shortcode", $shortcode)->firstOrFail();
        $short_url->update($data);
        return $short_url;
    }
}
