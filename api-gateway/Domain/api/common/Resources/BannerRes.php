<?php

namespace Domain\api\common\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerRes extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "desc" => $this->desc,
            "image" => $this->image ? config("app.domain") . $this->image : null,
            "sort" => $this->sort,
            "link" => $this->link,
        ];
    }
}


