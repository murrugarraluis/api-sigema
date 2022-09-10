<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaintenanceSheetArticlesResource extends JsonResource
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
            'name'=>$this->name,
            'article_type'=>$this->article_type,

            'description'=>$this->pivot->description,
            'price'=>$this->pivot->price,
            'quantity'=>$this->pivot->quantity,
        ];
    }
}
