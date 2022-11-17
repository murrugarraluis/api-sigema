<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyNotificationsResources extends JsonResource
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
			"machine" => [
				"name" => $this->machine->name,
			],
			"message" => $this->message,
			"date_send_notification" => $this->date_send_notification,
			"is_view" => $this->pivot->is_view
		];
	}
}
