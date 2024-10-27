<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username'=> $this->username,
            'email'=> $this->email,
            'phone'=> $this->phone,
            'type'=> $this->type,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'published_at' => $this->created_at->diffForHumans(),
        ];
        if(isset($this->token)){
            $arr['token'] = $this->token;
        }
        return $arr;
    }
}
