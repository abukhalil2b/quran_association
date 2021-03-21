
<div class="container">
    <div class="row">

    	<div class="col-md-12">
	    	<div >
	    		<h4><span class="text-primary">الإسم: </span>{{$loggedUser->name}}</h4>
				<span class="text-primary">الوصف: </span>{{$supervisor->title}}
	    	</div>
			<div>
				<span class="text-primary">المركز التابع له: </span>{{$usercenter->name}}
	    	</div>

    	</div>

		<div class="col-md-12">
			<hr>
			<span class="text-primary">المدرسين التابعين للمركز</span>
			<a class="pull-left" href="{{route('user.teacher.create')}}"><span class="plus-icon">+</span> إضافة مدرس</a>
	    	<ol>
	    	@foreach($teachers as $teacher)
	    	<li>{{$teacher->accountOwner->name}}</li>
	    	@endforeach
	    	</ol>
    	</div>

		<div class="col-md-12">
			<hr>
			<span class="text-primary">الطلاب التابعين للمركز</span>
			<a class="pull-left" href="{{route('student.create')}}"><span class="plus-icon">+</span> إضافة طالب</a>
	    	<ol>
	    	@foreach($students as $student)
	    	<li>{{$student->name}}</li>
	    	@endforeach
	    	</ol>
    	</div>

    	<div class="col-md-12">
    		<hr>
	    	<div>
				<h4 class="text-primary">البرامج: </h4>
				@foreach($circles as $circle)
					<div class="card mt-3">

						<a href="{{route('circle.dashboard',['circle'=>$circle->id])}}">
						<div class="alert alert-secondary">

	                        <small class="text-primary">البرنامج: </small>{{$circle->program->title}} -
	    	    			<small class="text-primary">الحلقة: </small>{{$circle->title}}

	                    </div>
	                    </a>


	                    <div class="px-1">
	    	    			<small class="text-primary">الفصل: </small>{{$circle->program->semester->title}} -
	    	    			<small class="text-primary">السنة الدراسية: </small>{{$circle->program->semester->year->title}}
	                    </div>
						<div class="divider"></div>
						<div class="px-1">
	                        <small class="text-primary">المشرف على الحلقة: </small>{{$circle->supervisor->accountOwner->name}}
	                    </div>
						<div class="px-1">
							<small class="text-primary">المدرس: </small>
							@if($circle->teacher)
							{{$circle->teacher->accountOwner->name}}
							@else
							لا يوجد مدرس
							@endif
						</div>
						<div class="divider"></div>
						<div class="px-1">
							<small class="text-primary">الطلاب: </small>
							@foreach($circle->students as $student)
							<div>{{$student->name}}</div>
							@endforeach
						</div>
					</div>
				@endforeach
	    	</div>
    	</div>

    </div>
</div>

