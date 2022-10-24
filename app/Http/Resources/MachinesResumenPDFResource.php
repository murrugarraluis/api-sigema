<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MachinesResumenPDFResource extends JsonResource
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
            "serie_number" => $this->serie_number,
            "name" => $this->name,
            "brand" => $this->brand,
            "model" => $this->model,
            "maintenance_number" => $this->maintenance_sheets()->count(),
            "amount" => $this->maintenance_sheets->sum(function ($sheet) {
                return $sheet->maintenance_sheet_details->sum(function($detail){
                    return ($detail->price * $detail->quantity);
                });
            })
        ];
    }
}
