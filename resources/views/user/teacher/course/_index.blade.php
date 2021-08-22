<div class="col-lg-12  mt-1">

	@if($courses)
	@foreach($courses  as $course)
	<div class="card p-2">
		{{$course->title}}
	</div>
	@endforeach
	@else
		<h5>لايوجد دورات</h5>
	@endif
</div>