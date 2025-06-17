<?php

namespace Domain\api\user\common\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotiResource extends JsonResource
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
            "id" => $this->id,
            "title" => $this->title,
            "message" => $this->message,
            'image_url' => $this->image_url ? config("app.domain") . $this->image_url : null,
            "is_read" => $this->is_read,
            "for" => $this->noti_for,
            "description" => $this->description,
            "created_at" => $this->created_at->diffForHumans()
        ];
    }
}
