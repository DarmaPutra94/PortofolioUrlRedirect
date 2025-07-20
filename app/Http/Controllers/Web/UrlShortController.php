<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\UrlShort;
use App\Service\UrlShorterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UrlShortController extends Controller
{
    private $url_shorter_service_manager;

    public function __construct()
    {
        $this->url_shorter_service_manager = new UrlShorterService();
    }

    public function store(Request $request)
    {
        $data = (object) $request->validate(['url' => 'required|active_url']);
        Gate::authorize('create', UrlShort::class);
        $short_code = $this->url_shorter_service_manager->generateShortUrlCode();
        $short_url = $this->url_shorter_service_manager->storeUrl(Auth::user(), [
            "url" => $data->url,
            "short_code" => $short_code
        ]);
        return redirect()->route('frontend.create')->with('shortUrl', route('shorturl.redirect', ['short_code'=>$short_url->short_code]))->with('successMessage', 'Created a new shortlink!');
    }

    public function create()
    {
        return view('pages.create');
    }

    public function dashboard(Request $request){
        $user = Auth::user();
        $query = $request->query('short_url') ?? '';
        $short_urls = $this->url_shorter_service_manager->getAllUserShortLinksPaginated($user, $query);
        return view('pages.dashboard', ['shortUrls'=>$short_urls]);
    }
}
