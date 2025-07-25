<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlShortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = null;
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "url"=>$this->url,
            "shortCode"=>$this->short_code,
            "createdAt"=>$this->created_at,
            "updatedAt"=>$this->updated_at,
            $this->mergeWhen(($request->routeIs('shorturl.show-with-statistic') || $request->routeIs('shorturl.index-with-statistic')), [
                "accessCount"=>$this->access_count
            ])
        ];
    }
}
