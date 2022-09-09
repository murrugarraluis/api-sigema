<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "document_number" => $this->document_number,
            "name" => $this->name,
            "lastname" => $this->lastname,
            "personal_email" => $this->personal_email,
            "phone" => $this->phone,
            "address" => $this->address,
            "user" => $this->user,
            "position" => $this->position,
            "document_type" => $this->document_type,
        ];
    }
}
