
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
	    	@if($teachers)
			@foreach($teachers as $teacher)
			<div class="card p-2">
				<div> اسم المدرس: {{$teacher->accountOwner->email}} </div>
				<small>{{$teacher->accountOwner->email}}</small>
			</div>
			@endforeach
			@else
				<h5>لايوجد حلقة</h5>
			@endif

    	</div>

		<div class="col-md-12">
			<hr>
			<span class="text-primary">الطلاب التابعين للمركز</span>
			<a class="pull-left" href="{{route('student.create')}}"><span class="plus-icon">+</span> إضافة طالب</a>
			@if($students)
			@foreach($students as $student)
			<div class="card p-2">
				<a href="{{route('student.show',['student'=>$student->id])}}">
				<div>رقم الطالب: {{$student->id}}</div>
				<div> اسم الطالب: {{$student->name}}</div>
				<small> كلمة المرور: {{$student->password}}</small>
				</a>
			</div>
			@endforeach
			@else
				<h5>لايوجد حلقة</h5>
			@endif
    	</div>

    	<h4 class="text-primary">البرامج: </h4>
		@include('user.supervisor._program')
		@include('user.supervisor._quraterly_program')

    </div>
</div>

