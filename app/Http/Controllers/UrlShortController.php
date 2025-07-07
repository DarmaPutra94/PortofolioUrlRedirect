<?php

namespace App\Http\Controllers;

use App\Models\UrlShort;
use App\Models\User;
use App\Service\UrlShorterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UrlShortController extends Controller
{
    private $url_shorter_service_manager;

    public function __construct() {
        $this->url_shorter_service_manager = new UrlShorterService();
    }
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
        $data = (object) $request->validate(['url'=>'required|active_url']);
        Gate::authorize('create', UrlShort::class);
        $short_code = $this->url_shorter_service_manager->generateShortUrlCode();
        $short_url = $this->url_shorter_service_manager->storeUrl(Auth::user(), [
            "url"=>$data->url,
            "short_code"=>$short_code
        ]);
        return $short_url->toResource();
    }



    /**
     * Display the specified resource.
     */
    public function show($short_code)
    {
        $short_url = $this->url_shorter_service_manager->getUrl($short_code);
        Gate::authorize('view', $short_url);
        return $short_url->toResource();
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
        $data = (object) $request->validate(['url'=>'required|active_url']);
        $short_url = $this->url_shorter_service_manager->getUrl($short_code);
        Gate::authorize('update', $short_url);
        $short_url = $this->url_shorter_service_manager->updateUrl($short_url, [
            "url"=>$data->url,
        ]);
        return $short_url->toResource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($short_code)
    {
        $short_url = $this->url_shorter_service_manager->getUrl($short_code);
        Gate::authorize('delete', $short_url);
        $this->url_shorter_service_manager->deleteUrl($short_url);
        return response()->json([], 204);
    }

    public function redirect($short_code){
        $short_url = $this->url_shorter_service_manager->getUrl($short_code);
        $short_url = $this->url_shorter_service_manager->increaseAccesCount($short_url);
        return redirect($short_url->url);
    }
}
