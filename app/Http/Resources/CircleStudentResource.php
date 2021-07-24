<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CircleStudentResource extends JsonResource
{

    public function toArray($request)
    {
       // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'teacherId'=>$this->teacher->id,
            'teacher'=>$this->teacher->accountOwner->name,
            'canWriteHisReport'=>$this->pivot->can_write_his_report,
        ];
    }
}
