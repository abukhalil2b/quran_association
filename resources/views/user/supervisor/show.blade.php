
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
	    	<div>
	    		{{$teacher->accountOwner->name}} 
	    		<small>{{$teacher->accountOwner->email}}</small>
	    	</div>
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

    	<h4 class="text-primary">البرامج: </h4>
		@include('user.supervisor._program')
		@include('user.supervisor._quraterly_program')

    </div>
</div>

