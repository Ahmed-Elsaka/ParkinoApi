<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'status'=>$this->status,
            'message'=>"success",
            'user'=>[
                'user_name'=>$this->user_name,
                'user_email'=>$this->email,
                'phone_number' =>$this->phone_number,
                'points' => $this->points,
                'cards'=>$this->no_of_cards,
                'garages'=>$this->no_of_garages,
            ]
        ];
    }
}
