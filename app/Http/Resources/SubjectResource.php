<?php

namespace App\Http\Resources;

use App\Actions\DisplayDateWithCurrentLang;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        $arr = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'year_id' => $this->year_id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'college_year' => CollegeYearResource::make($this->whenLoaded('year')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
        if(app()->getLocale()!='all'){
            $arr['name'] = DisplayDateWithCurrentLang::display($this->name);
            $arr['info'] = DisplayDateWithCurrentLang::display($this->info);
        }
        return $arr;
    }
}
