<?php

namespace App\Http\Controllers;

use App\Models\UrlShort;
use App\Models\User;
use App\Service\UrlShorterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UrlShortController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $url_shorter_service_manager = new UrlShorterService();
        $data = (object) $request->validate(['url'=>'required|active_url']);
        $hashed_url = $url_shorter_service_manager->hashUrl($data->url);
        $short_code = $url_shorter_service_manager->generateShortUrlCode();
        $short_url = $url_shorter_service_manager->storeUrl(auth()->user, [
            "url"=>$data->url,
            "url_hash"=>$hashed_url,
            "short_code"=>$short_code
        ]);
        return response()->json($short_url);
    }



    /**
     * Display the specified resource.
     */
    public function show($short_url)
    {
        $url = UrlShort::where("short_url", $short_url)->get();
        return response()->json($url);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UrlShort $urlShort)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $short_code)
    {
        $url_shorter_service_manager = new UrlShorterService();
        $data = (object) $request->validate(['url'=>'required|active_url']);
        $hashed_url = $url_shorter_service_manager->hashUrl($data->url);
        $short_url = $url_shorter_service_manager->updateUrl($short_code, [
            "url"=>$data->url,
            "url_hash"=>$hashed_url,
        ]);
        return response()->json($short_url);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UrlShort $urlShort)
    {
        //
    }
}
