<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MachinetDetailResource extends JsonResource
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
            'id' => $this->id,
            'serie_number' => $this->serie_number,
            'name' => $this->name,
            'brand' => $this->brand,
            'model' => $this->model,
            'image' => $this->image ? $this->image->path : null,
            'technical_sheet' => $this->technical_sheet ? $this->technical_sheet->path : null,
            'maximum_working_time' => $this->maximum_working_time,
            'articles'=> ArticleResource::collection($this->articles),
            'status' => $this->status,
        ];
    }
}
