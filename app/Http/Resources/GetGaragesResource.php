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
            [
                "garage_id" => "12345666",
                "garage_name"=>"Anwar Al Madinah",
                "available" => "0" ,
                "reserved" => "0" ,
                "latitude" => "36.3658",
                "longitude" => "30.963",
                "image" => "http://41.44.0.137:8000/sayed-fucken-test/1.jpg",
                "distance" => "1km from centre",
                "slotnumbers" => "40 Slots ",
                "price" => "5P",
                "stars" => "3",
                "emptyslots" => "10",
            ],
            [
                "garage_id" => "12345666",
                "garage_name"=>"Anwar Al Madinah",
                "available" => "0" ,
                "reserved" => "0" ,
                "latitude" => "36.3658",
                "longitude" => "30.963",
                "image" => "http://zamep.eu/wp-content/uploads/2017/11/default-no-image.png",
                "distance" => "0.6km from centre",
                "slotnumbers" => "10 Slots",
                "price" => "5P",
                "stars" => "3",
                "emptyslots" => "15",
            ]

        ];

    }
}
