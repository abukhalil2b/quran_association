<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model {
	protected $fillable = ['title', 'avatar', 'active', 'owner'];
	public function accountOwner() {
		return $this->belongsTo(User::class, 'owner');
	}
	public function circles() {
		return $this->hasMany(Circle::class);
	}

	public function userSupervisorPermission() {
		return $this->belongsToMany(User::class, 'user_supervisor_permission', 'supervisor_id', 'user_id');
	}

	public function usercenter() {
		$usercenter = User::whereHas('userSupervisorPermission', function ($q) {
			$q->where('user_supervisor_permission.supervisor_id', $this->id);
		})->first();
		if($usercenter){
			return $usercenter;
		}
		abort(404);
	}

	public function checkUserPermission($user) {
		$supervisor = $this->whereHas('userSupervisorPermission', function ($query) use ($user) {
				$query->where([
					'user_supervisor_permission.supervisor_id' => $this->id,
					'user_supervisor_permission.user_id' => $user->id,
				]);
			})->first();
			if (!$supervisor) {
				die('أنت لاتملك الصلاحية');
			}
		return $supervisor;
	}

	
	public function checkSupervisorHasStudent($student){
		$loggedUser = auth()->user();
		if($loggedUser->userType!='supervisor'){
			abort(401);
		}
		$usercenter = $this->usercenter();

        $student = $usercenter->userStudentPermission()->where('user_student_permission.student_id',$student->id)->first();
        if($student){
            return $student;
        }
        abort(401);
    }

}
