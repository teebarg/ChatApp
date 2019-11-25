<?php

namespace App\Http\Resources;

class ContinentResource extends BaseResource
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
            'continent_name' => $this->continent_name,
            'continent_alias' => $this->continent_alias,
            $this->mergeWhen($this->countries->count(), [
                'countries' => CountryResource::collection($this->countries),
            ]),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
          ];
    }

}
