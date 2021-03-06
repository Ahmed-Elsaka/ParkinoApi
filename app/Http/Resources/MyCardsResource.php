<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyCardsResource extends JsonResource
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
                'user_name'=>$this->username,
                'user_email'=>$this->email,

            ]
        ];
    }

}
