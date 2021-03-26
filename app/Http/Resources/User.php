<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => (int)$this->id,
            'name' => (string)$this->name,
            'email' => (string)$this->email,
            'phone_number' => (string)$this->phone_number,
            'api_token' => (string)$this->api_token,
            'image' => asset($this->image),
        ];
    }
}