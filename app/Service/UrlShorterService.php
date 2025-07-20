<?php

namespace App\Service;

use App\Models\UrlShort;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function getAllUserShortLinksPaginated(User $user, String $query='', int $itemPerPage=10): LengthAwarePaginator{
        return $user->shortUrls()->whereLike('short_code', $query.'%')->paginate($itemPerPage);
    }

    public function getUrl(String $short_code): UrlShort{
        return UrlShort::where('short_code', $short_code)->firstOrFail();
    }

    public function generateShortUrlCode(): String{
        do {
            $code = Str::random(6);
        } while (UrlShort::where('short_code', $code)->exists());
        return $code;
    }

    public function storeUrl(User $user, $data){
        return $user->shortUrls()->create($data);
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
