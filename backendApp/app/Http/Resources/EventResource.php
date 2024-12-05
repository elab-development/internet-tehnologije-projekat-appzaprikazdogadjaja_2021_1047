<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Reference;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class EventResource extends JsonResource
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
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'location' => new LocationResource(Location::find($this->location_id)),
            'category' => new CategoryResource( Category::find($this->category_id) ),
            'reference' => new ReferenceResource(Reference::find($this->reference_id)),
            'url' => $this->url,
            'image' => $this->image,
        ];
    }
}
