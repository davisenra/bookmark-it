<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookmarkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'visited' => $this->visited_at !== null,
            'visited_at' => $this->visited_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'tags' => $this->whenLoaded('tags', TagResource::collection($this->tags)),
        ];
    }
}
