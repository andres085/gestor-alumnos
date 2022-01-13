<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'rotation_id' => $this->rotation_id,
            'apellido' => $this->apellido,
            'nombre' => $this->nombre,
            'dni' => $this->dni,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'direccion' => $this->direccion
        ];
    }
}
