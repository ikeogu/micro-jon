<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
         'job_title' => $this->job_title,
         'job_category' =>$this->job_category,
         'job_type'=> $this->job_type,
         'job_condition' => $this->job_condition,
         'business'=> User::find($this->user_id)->name,
         'view_more' => "/api/job/".$this->id
        ];
    }
}