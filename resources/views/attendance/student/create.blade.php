<x-app-layout>
<form action="{{route('attendance.student.store')}}" method="post" >
	@csrf
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h4 class="alert alert-secondary"><small class="text-info">الحلقة: </small>{{$circle->title}}</h4>

			@if(count($students))
			@foreach($students as $student)
				<div class="mt-1 " style="display: grid; grid-template-columns: 80% 20%">
					<input type="hidden" name="studentIds[]" value="{{$student->id}}">
					<div> {{$student->name}} </div>
					<select name="presents[]"  class="form-control">
						<option value="0">غائب</option>
						<option value="1">حاضر</option>
					</select>
				</div>
				<div class="divider"></div>

			@endforeach
			<input type="hidden" name="circle_id" value="{{$circle->id}}">
			<button type="submit" class="btn btn-outline-secondary mt-2 btn-block">حفظ</button>
			@else
			<center class="alert alert-warning">لايوجد طلبة</center>
			@endif
		</div>
	</div>
</div>
</form>
</x-app-layout>