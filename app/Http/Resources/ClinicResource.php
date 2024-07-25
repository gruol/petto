<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClinicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // dd($request);
        return [
            "id"                => $this->id,
            "manager_name"      => $this->manager_name,
            "email"             => $this->email,
            "contact"           => $this->contact,
            "clinic_name"       => $this->clinic_name,
            "address"           => $this->address,
            "city"              => $this->city,
            "picture"           => $this->picture,
            "otp"               => $this->otp,
            "is_otp_verified"   => $this->is_otp_verified,
            "otp_created_at"    => $this->otp_created_at,
            "is_deleted"        => $this->is_deleted,
            "is_approved"       => $this->is_approved,
            "approved_at"       => $this->approved_at,
            "token"             => $this->createToken('myapptoken')->plainTextToken,
            "created_at"        => $this->created_at->format('d/m/Y'),
            "updated_at"        => $this->updated_at->format('d/m/Y'),
        ];
    }
}
