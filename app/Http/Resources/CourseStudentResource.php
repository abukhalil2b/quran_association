<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseStudentResource extends JsonResource
{

    public function toArray($request)
    {
       // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'teacherId'=>$this->teacher->id,
            'teacherName'=>$this->teacher->accountOwner->name,
            'startAt'=>$this->startAt,
            'endAt'=>$this->endAt,
        ];
    }
}
