<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetGaragesResource extends JsonResource
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
            'status'=>1,
            [
                "garage_id" => "12345666",
                "available" => "0" ,
                "reserved" => "0" ,
                "latitude" => "36.3658",
                "longitude" => "30.963",
                "image" => "http://google.com/image.jpeg",
                "distance" => "5K",
                "soltsnumber" => "10",
                "price" => "5$",
                "stars" => "3",
                "emptyslots" => "3",
            ],
            [
            "garage_id"=> "12345666",
            "available" => "0" ,
            "reserved" => "0" ,
            "latitude" => "36.3658",
            "longitude" => "30.963",
            "image" => "http://google.com/image.jpeg",
            "distance" => "5K",
            "soltsnumber" => "10",
            "price" => "5$",
            "stars" => "3",
            "emptyslots" => "3",
            ]

        ];







    }
}
