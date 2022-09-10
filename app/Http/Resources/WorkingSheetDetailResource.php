<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkingSheetDetailResource extends JsonResource
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
            'id'=>$this->id,
            'date_start'=>$this->date_start,
            'date_end'=>$this->date_end,
            'description'=>$this->description,
            'machine'=>new WorkingSheetMachineResource($this->machine)
        ];
    }
}
