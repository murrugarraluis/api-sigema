<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkingHourResource extends JsonResource
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
            'date_time_start' => $this->date_time_start,
            'date_time_end' => $this->date_time_end,
            'date_time_diff' => $this->date_time_diff(),

        ];
    }

    function date_time_diff()
    {
        $datetime1 = date_create($this->date_time_start);
        $datetime2 = date_create($this->date_time_end);
        $interval = date_diff($datetime1, $datetime2);
        return [
            'hours' => $interval->format('%h'),
            'minutes' => $interval->format('%i'),
            'secons' => $interval->format('%s'),
        ];
    }
}
