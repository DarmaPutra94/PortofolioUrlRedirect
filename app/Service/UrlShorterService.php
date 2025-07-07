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

    public function getUrl($short_code){
        $short_url = UrlShort::where('short_code', $short_code)->firstOrFail();
        return $short_url;
    }

    public function generateShortUrlCode(){
        do {
            $code = Str::random(6);
        } while (UrlShort::where('short_code', $code)->exists());
        return $code;
    }

    public function storeUrl(User $user, $data){
        $short_url = $user->shortUrls()->create($data);
        return $short_url;
    }

    public function updateUrl(UrlShort $short_url, $data){
        $short_url->update($data);
        return $short_url;
    }

    public function deleteUrl(UrlShort $short_url){
        $short_url->delete();
        return $short_url;
    }

    public function increaseAccesCount(UrlShort $short_url){
        $short_url->access_count++;
        $short_url->save();
        return $short_url;
    }
}
