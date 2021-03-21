
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
	    			المشرف
	    		</center>
	    		@foreach($supervisorPermissions as $supervisorPermission)
	    		<div class="px-2">{{$supervisorPermission->title}}</div>
	    		@endforeach
    		</div>
    	</div>

    	<div class="col-md-12">
			<div class="box  mt-2">
	    		<center class="box-top ">
	    			المدرس
	    		</center>
	    		@foreach($teacherPermissions as $teacherPermission)
	    		<div class="px-2">{{$teacherPermission->title}}</div>
	    		@endforeach
    		</div>
    	</div>

	    <div class="col-md-12">
	    	<div class="box box-orange mt-2">
	    		<center class="box-top box-top-orange">
	    			الطالب
	    		</center>

	    		@foreach($studentPermissions as $studentPermission)
	    		<div class="px-2">{{$studentPermission->title}}</div>
	    		@endforeach
    		</div>
    	</div>
    </div>
</div>
