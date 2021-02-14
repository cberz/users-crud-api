<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
      'avatar'  => $this->avatar,
      'personal_id' => $this->personal_id,
      'name'  => $this->name,
      'lastname'  => $this->lastname,
      'email'  => $this->email,
      'date_of_birth'  => $this->date_of_birth,
      'age'  => $this->age,
      'is_admin'  => $this->is_admin,
    ];
  }
}
