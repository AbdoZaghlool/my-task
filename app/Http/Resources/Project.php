<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Project extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => (string)$this->name,
            'start_at' => $this->start_at->format('Y-m-d H:i'),
            'end_at' => $this->end_at->format('Y-m-d H:i'),
            'creator_id' => (int)$this->creator_id,
            'creator_name' => @$this->creator->name,
            'tasks'  => Task::collection($this->tasks)
        ];
    }
}