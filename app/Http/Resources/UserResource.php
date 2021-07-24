<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {
    	if($this->userType=='teacher'){
	        return [
	            'userId'=>$this->id,
	            'userName'=>$this->name,
	            'userGender'=>$this->gender,
	            'userType'=>$this->userType,
	            'userPhone'=>$this->phone,
	            'accountId'=>$this->teacherAccount->id,
	            'accountTitle'=>$this->teacherAccount->title,
	            'accountAvatar'=>$this->teacherAccount->avatar,
	            'usercenterName'=>$this->teacherAccount->usercenter()->name
	        ];    		

    	}

    	if($this->userType=='supervisor'){
	        return [
	            'userId'=>$this->id,
	            'userName'=>$this->name,
	            'userGender'=>$this->gender,
	            'userType'=>$this->userType,
	            'userPhone'=>$this->phone,
	            'accountId'=>$this->teacherAccount->id,
	            'accountTitle'=>$this->teacherAccount->title,
	            'accountAvatar'=>$this->teacherAccount->avatar,
	            'usercenterName'=>$this->teacherAccount->usercenter()->name
	        ];    		

    	}

    	return [
	            'userId'=>$this->id,
	            'userName'=>$this->name,
	            'userGender'=>$this->gender,
	            'userType'=>$this->userType,
	            'userPhone'=>$this->phone,
	            'accountId'=>null,
	            'accountTitle'=>null,
	            'accountAvatar'=>null,
	            'usercenterName'=>null
	        ]; 

    }
}
