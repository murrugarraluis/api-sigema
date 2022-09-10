<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceEmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "document_number" => $this->document_number,
            "name" => $this->name,
            "lastname" => $this->lastname,
            "personal_email" => $this->personal_email,
            "phone" => $this->phone,
            "address" => $this->address,
            "position" => new PositionResource($this->position),
            "document_type" => new DocumentTypeResource($this->document_type),

            'check_in' => $this->pivot->check_in,
            'check_out' => $this->pivot->check_out,
            'attedance' => $this->pivot->attendance,
            'attendance_number' => $this->attendance_sheets()->wherePivot('attendance','asistencia')->count(),
            'absences_number' => $this->attendance_sheets()->wherePivot('attendance','falta')->count(),
        ];
    }
}
