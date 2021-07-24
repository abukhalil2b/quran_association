<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Student;
use App\Models\Teacher;
class TeacherCircleWithStudentResource extends JsonResource
{

    public function toArray($request)
    {
       // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'circleTitle'=>$this->title,
            'teacherId'=>$this->teacher_id,
            'supervisorId'=>$this->supervisor_id,
            'supervisorName'=>$this->supervisor->accountOwner->name,
            'programTitle'=>$this->program->title,
            'programId'=>$this->program_id,
            'students'=>TeacherStudentResource::collection($this->students),
        ];
    }
}
