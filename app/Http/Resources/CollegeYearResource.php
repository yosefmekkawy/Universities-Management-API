<?php

namespace App\Http\Resources;

use App\Actions\DisplayDateWithCurrentLang;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollegeYearResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'college' => CollegeResource::make($this->whenLoaded('college')),
            'year' => YearResource::make($this->whenLoaded('year')),
            'info' => $this->info,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
