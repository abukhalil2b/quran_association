<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CircleResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'teacherId'=>$this->teacher->id,
            'supervisorId'=>$this->teacher->id,
            'programId'=>$this->teacher->id,
            'teacher'=>$this->teacher->accountOwner->name,
        ];
    }
}
