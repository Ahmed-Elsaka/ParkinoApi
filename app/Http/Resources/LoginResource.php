<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'status'=>$this->status,
            'message'=>$this->message,
            'user'=>[
                'user_id'=>$this->id,
                'user_name'=>$this->user_name,
                'user_email'=>$this->email,
                'phone_number'=>$this->phone_number,

            ]
        ];
    }

}
