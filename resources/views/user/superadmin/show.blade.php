
<link rel="stylesheet" href="{{asset('css/box-style.css')}}">
<div class="container">
    <div class="row">



    	<div class="col-md-12">
			<div class="box box-blue mt-2">
	    		<a class="btn btn-primary btn-sm" href="{{route('year.create')}}">create year</a>
	    		<a class="btn btn-primary btn-sm" href="{{route('usercenter.create')}}">usercenter.create</a>
    		</div>
    	</div>

    	<div class="col-md-12">
			<div class="box box-blue mt-2">
	    		<center class="box-top box-top-blue">
	    			السنوات الدراسية
	    		</center>
	    		@foreach($years as $year)
	    		<div class="px-1 underline">
	    			<a href="{{route('semester.create',['year'=>$year->id])}}">
	    				{{$year->title}} 
	    				<ol>
		    				@foreach($year->semesters as $semester)
		    					<li>{{$semester->title}}</li>
		    				@endforeach
	    				</ol>
	    			</a>
	    		</div>
	    		@endforeach
    		</div>
    	</div>
    	<div class="col-md-12">
			<div class="box box-blue mt-2">
	    		<center class="box-top box-top-blue">
	    			صلاحيات المشرف
	    		</center>
	    		@foreach($supervisorPermissions as $supervisorPermission)
	    		<div class="px-2">{{$supervisorPermission->title}}</div>
	    		@endforeach
    		</div>
    	</div>

    	<div class="col-md-12">
			<div class="box  mt-2">
	    		<center class="box-top ">
	    			صلاحيات المدرس
	    		</center>
	    		@foreach($teacherPermissions as $teacherPermission)
	    		<div class="px-2">{{$teacherPermission->title}}</div>
	    		@endforeach
    		</div>
    	</div>

	    <div class="col-md-12">
	    	<div class="box box-orange mt-2">
	    		<center class="box-top box-top-orange">
	    			صلاحيات الطالب
	    		</center>

	    		@foreach($studentPermissions as $studentPermission)
	    		<div class="px-2">{{$studentPermission->title}}</div>
	    		@endforeach
    		</div>
    	</div>

    	<div class="col-md-12">
	    	<div class="box box-orange mt-2">
	    		<center class="box-top box-top-orange">
	    			المستخدمين للبرنامج
	    		</center>
	    		@foreach($users as $user)
	    			<div class="px-2">
	    				[{{$user->id}}]{{$user->name}} - {{__($user->userType)}} - {{$user->created_at->diffForHumans()}}
	    				<div class="pull-left">
	    					<a href="{{route('user.edit',['user'=>$user->id])}}">تعديل</a>
	    				</div>
	    				<div>{{$user->active?__('active'):__('deactive')}}</div>
	    				<hr>
	    			</div>
	    		@endforeach
    		</div>
    		{{ $users->links() }}
    	</div>

    	<div class="col-md-12">
	    	<div class="box box-orange mt-2">
	    		<center class="box-top box-top-orange">
	    			المشرفين
	    		</center>

	    		@foreach($supervisors as $supervisor)
	    		<div class="px-2">
	    			[{{$supervisor->id}}]{{$supervisor->accountOwner->name}}
	    			<div>{{$supervisor->created_at->diffForHumans()}}</div>

	    			<hr>
	    		</div>
	    		@endforeach
    		</div>
    		{{ $supervisors->links() }}
    	</div>

    	<div class="col-md-12">
	    	<div class="box box-orange mt-2">
	    		<center class="box-top box-top-orange">
	    			المدرسين
	    		</center>

	    		@foreach($teachers as $teacher)
	    		<div class="px-2">
	    			[{{$teacher->id}}]{{$teacher->owner}}  - {{$teacher->created_at->diffForHumans()}} 
	    			<span class="pull-left">
	    				<a href="{{route('edit_teacher_owner',['teacher'=>$teacher->id])}}">تعديل</a>
	    			</span>
	    		</div>
	    		@endforeach
	    		{{ $teachers->links() }}
    		</div>
    	</div>



    </div>
</div>
