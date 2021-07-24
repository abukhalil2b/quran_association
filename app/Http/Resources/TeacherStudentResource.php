<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Student;
use App\Models\Teacher;
class TeacherStudentResource extends JsonResource
{

    public function toArray($request)
    {
       // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'password'=>$this->password,
            'gender'=>$this->gender,
            'avatar'=>$this->avatar?$this->avatar:'',
            'usercenter'=>$this->usercenter()->name,
            'circleId'=>$this->pivot->circle_id,
            'writeReport'=>$this->pivot->can_write_his_report==1?true:false,
            'active'=>$this->active==1?true:false,
        ];
    }
}
