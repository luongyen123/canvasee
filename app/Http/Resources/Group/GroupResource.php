<?php

namespace App\Http\Resources\Group;

use Illuminate\Http\Resources\Json\JsonResource;


class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'name'=>$this->name,
            'members'=>$this->members->count(),
            'feed_number'=>$this->feeds->count(),
            'href'=>[
                'feeds'=>route('feeds.index',$this->id),
                'members'=>route('members.index',$this->id)
            ]
        ];
       
    }
}
