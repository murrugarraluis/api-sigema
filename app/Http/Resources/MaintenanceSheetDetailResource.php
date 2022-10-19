<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaintenanceSheetDetailResource extends JsonResource
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
            'id' => $this->id,
            'code'=>$this->code,
            'date' => $this->date,
            'responsible' => $this->responsible,
            'technical' => $this->technical,
            'description' => $this->description,
            'maintenance_type' => new MaintenanceTypeResource($this->maintenance_type),
            'supplier' => new SupplierResource($this->supplier),
            'machine' => new MachineResource($this->machine),
            'ref_invoice_number'=> $request->ref_invoice_number,
            'detail' => MaintenanceSheetArticlesResource::collection($this->maintenance_sheet_details->sortBy('item'))
        ];
    }
}
