<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkingSheetMachineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $date_last_use = $this->working_sheets()->orderBy('date_end', 'desc')->first();
        $date_last_maintenance = $this->maintenance_sheets()->orderBy('date', 'desc')->first();
        return [
            'id' => $this->id,
            'serie_number' => $this->serie_number,
            'name' => $this->name,
            'brand' => $this->brand,
            'model' => $this->model,
            'image' => $this->image ? $this->image->url : null,
            'maximum_working_time' => $this->maximum_working_time,
            'status' => $this->status,

            'date_last_use' => $date_last_use ? date('Y-m-d',strtotime($date_last_use->date_end)) : null,
            'total_hours_used' => $this->time_worked,
            'date_last_maintenance' => $date_last_maintenance ? date('Y-m-d',strtotime($date_last_maintenance->date)) : null,
        ];
    }
}
