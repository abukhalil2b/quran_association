<x-app-layout>
<form action="{{route('attendance.student.update')}}" method="post" >
	@csrf
<div class="container">
	<div class="row">
		<div class="col-lg-12">

			@if($errors->any())
                @foreach($errors->all() as $error)
                    <li class="text-danger">{{$error}}</li>
                @endforeach
             @endif

			<div class="mt-1 " style="display: grid; grid-template-columns: 80% 20%">
				<div> {{$attendance->student->name}} </div>
				<select name="present"  class="form-control">
					<option value="0">غائب</option>
					<option value="1">حاضر</option>
				</select>
			</div>
			<div class="divider"></div>
			<input type="hidden" name="attendance_id" value="{{$attendance->id}}">
			<button type="submit" class="btn btn-outline-secondary mt-2 btn-block">حفظ</button>
		</div>
	</div>
</div>
</form>
</x-app-layout>