<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
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
            'id' => (string)$this->id,
            'from' => [
                        'latitude' => $this->fromlatitude,
                        'longitude' => $this->fromlongitude,
                      ],
            'to' => [
                        'latitude' => $this->tolatitude,
                        'longitude' => $this->tolongitude,
                    ],
            'mode' => $this->mode->modeType,
            'engine' => $this->user->engine->engineType,
            'distance' => $this->distance,
            'traveltime' => $this->traveltime,
            'co2emissions' => $this->co2emission,
            'created_at' => $this->created_at
            ];
    }
}
