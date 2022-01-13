<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RotationResource extends JsonResource
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
            'numero' => $this->numero,
            'fecha' => $this->fecha,
            'observaciones' => $this->observaciones,
        ];
    }
}
