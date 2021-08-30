<div class="col-lg-12  mt-1">
	<h6 class="mt-3">الطلاب المسجلون في الحلقة ({{$quarterlyProgramCircle->students->count()}})</h6>
	@if($quarterlyProgramCircle)
	@foreach($quarterlyProgramCircle->students as $student)
	<div class="card p-2 mt-1">
		<a href="{{route('student.show',['student'=>$student->id,'circle'=>$quarterlyProgramCircle->id])}}">
		<div>رقم الطالب: {{$student->id}}</div>
		<div> اسم الطالب: {{$student->name}}</div>
		</a>
	</div>
	@endforeach
	@else
		<h5>لايوجد حلقة</h5>
	@endif
</div>
