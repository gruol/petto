<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            "name"              => $this->name,
            // "password"       => $this->password,
            "contact_no"        => $this->contact_no,
            "email"             => $this->email,
            "dob"               => $this->dob,
            "pets"              => $this->Pets,
            "country"           => $this->country,
            "otp"               => $this->otp,
            "is_otp_verified"   => $this->is_otp_verified,
            "otp_created_at"    => $this->otp_created_at,
            "token"             => $this->createToken('myapptoken')->plainTextToken,
            "is_deleted"        => $this->is_deleted,
            "created_at"        => $this->created_at->format('d/m/Y'),
            "updated_at"        => $this->updated_at->format('d/m/Y'),
        ];
    }
}
