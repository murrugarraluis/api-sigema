<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkingSheetDetailResource extends JsonResource
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
            'code' => $this->code,
            'date' => $this->date,
            'description' => $this->description,
            'machine' => new WorkingSheetMachineResource($this->machine),
            'working_hours' => WorkingHourResource::collection($this->working_hours),
            'is_open' => $this->is_open,
            'is_pause' => ($this->working_hours()->orderBy('created_at', 'desc')->first()->date_time_end && $this->is_open)
        ];
    }
}
