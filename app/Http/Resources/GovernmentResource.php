<?php

namespace App\Http\Resources;

use App\Actions\DisplayDateWithCurrentLang;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GovernmentResource extends JsonResource
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
            'name' => $this->name,
            'info' => $this->info,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
        if(app()->getLocale()!='all'){
            $arr['name'] = DisplayDateWithCurrentLang::display($this->name);
            $arr['info'] = DisplayDateWithCurrentLang::display($this->info);
        }
        return $arr;
    }
}
