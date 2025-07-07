<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UrlShort extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "url"=>$this->url,
            "shortCode"=>$this->short_code,
            "createdAt"=>$this->created_at,
            "updatedAt"=>$this->updated_at,
            $this->mergeWhen($request->routeIs('shorturl.show-with-statistic'), [
                "accessCount"=>$this->access_count
            ])
        ];
    }
}
