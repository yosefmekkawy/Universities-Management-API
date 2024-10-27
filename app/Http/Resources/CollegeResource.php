<?php

namespace App\Http\Resources;

use App\Actions\DisplayDateWithCurrentLang;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollegeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $arr = [
            'id' => $this->id,
            'name' => $this->name,
            'info' => $this->info,
            'government'=>GovernmentResource::make($this->whenLoaded('government')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
        if(app()->getLocale()!='all'){
            $arr['name'] = DisplayDateWithCurrentLang::display($this->name);
            $arr['info'] = DisplayDateWithCurrentLang::display($this->info);
        }
        return $arr;
    }
}
