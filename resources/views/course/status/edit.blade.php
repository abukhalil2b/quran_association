<x-app-layout>
	
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			<form action="{{route('course.status.update')}}" method="post" >
				@csrf
				<select class="form-control" name="status">
					<option @if($course->status=='coming') selected @endif value="coming">قادمة</option>}
					<option @if($course->status=='now') selected @endif value="now">جارية</option>
					<option @if($course->status=='past') selected @endif value="past">ماضية</option>}
				</select>
				<input type="hidden" name="id" value="{{$course->id}}">
				<button class="btn btn1 bgcolor1">حفظ التعديل</button>
			</form>
        </div>
    </div>
</div>

</x-app-layout>
