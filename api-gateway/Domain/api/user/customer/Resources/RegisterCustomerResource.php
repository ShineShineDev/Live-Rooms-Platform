<?php

namespace Domain\api\user\customer\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterCustomerResource extends JsonResource
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
            'uuid' => $this->uuid,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "phone" => $this->phone,
            "gender" => $this->gender,
            "dob" => $this->dob,
            "post_code" => $this->post_code,
            "address" => $this->address,
            "avator" => $this->avator,
        ];
    }
}












