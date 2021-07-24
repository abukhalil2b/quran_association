<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'gender',
        'email',
        'password',
        'userType',
        'nationalId', 
        'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
    
    public function traineeAccount() {
        return $this->hasOne(Trainee::class, 'owner');
    }
    public function trainerAccount() {
        return $this->hasOne(Trainer::class, 'owner');
    }

    public function supervisorAccount() {
        return $this->hasOne(Supervisor::class, 'owner');
    }

    public function teacherAccount() {
        return $this->hasOne(Teacher::class, 'owner');
    }

    public function courses() {
        return $this->hasMany(Course::class);
    }

    public function buildings() {
        return $this->hasMany(Building::class);
    }

    public function programs() {
        return $this->hasManyThrough(Program::class, Building::class, 'user_id', 'building_id');
    }

    public function abouts() {
        return $this->hasMany(About::class);
    }

    public function hasAboutPermission($about) {
        return $this->abouts()->where('name', $about)->count();
    }

    public function userFinanceReportPermission() {
        return $this->belongsToMany(FinanceReport::class, 'user_finance_report_permission', 'user_id', 'finance_report_id');
    }
    public function userDailyrecordPermission() {
        return $this->belongsToMany(Dailyrecord::class, 'user_dailyrecord_permission', 'user_id', 'dailyrecord_id');
    }
    public function userBuildingPermission() {
        return $this->belongsToMany(Building::class, 'user_building_permission', 'user_id', 'building_id');
    }
    public function userProgramPermission() {
        return $this->belongsToMany(Program::class, 'user_program_permission', 'user_id', 'program_id');
    }
    public function userMemorizeProgramPermission() {
        return $this->belongsToMany(MemorizeProgram::class, 'user_memorize_program_permission', 'user_id', 'memorize_program_id');
    }
    public function userCirclePermission() {
        return $this->belongsToMany(Circle::class, 'user_circle_permission', 'user_id', 'circle_id');
    }
    public function userSupervisorPermission() {
        return $this->belongsToMany(Supervisor::class, 'user_supervisor_permission', 'user_id', 'supervisor_id');
    }
    public function userTeacherPermission() {
        return $this->belongsToMany(Teacher::class, 'user_teacher_permission', 'user_id', 'teacher_id');
    }
    public function userStudentPermission() {
        return $this->belongsToMany(Student::class, 'user_student_permission', 'user_id', 'student_id');
    }
    public function userTrainerPermission() {
        return $this->belongsToMany(Trainer::class, 'user_trainer_permission', 'user_id', 'trainer_id');
    }

    public function roles() {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'user_permission', 'user_id', 'permission_id');
    }

    public function checkUsercenterHasStudent($student){
        $student = $this->userStudentPermission()->where('user_student_permission.student_id',$student->id)->first();
        if($student){
            return $student;
        }
        abort(401);
    }

}
