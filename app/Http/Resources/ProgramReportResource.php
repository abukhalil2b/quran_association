<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'studentId'=>$this->student_id,
            'teacherId'=>$this->teacher_id,
            'circleTitle'=>$this->circle->title,
            'studentName'=>$this->student->name,
            'teacherName'=>$this->teacher->accountOwner->name,
            
            'donedate'=>$this->donedate?$this->donedate:'',
            'tobedonedate'=>$this->tobedonedate?$this->tobedonedate:'',
            'todaymission'=>$this->todaymission?$this->todaymission:'',
            'nextmission'=>$this->nextmission?$this->nextmission:'',
            'evaluation'=>$this->evaluation?$this->evaluation:'',
            'note'=>$this->note?$this->note:'',
            'fathernote'=>$this->fathernote?$this->fathernote:'',
        ];
    }
}
