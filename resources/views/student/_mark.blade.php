@if(auth()->user()->userType=='teacher')
<form action="{{route('student.mark.store')}}" method="post">
@csrf
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card my-5">
				<div class="card-body">
					مجموع الدرجات : {{$student->marks->where('circle_id',$circle->id)->sum('point')}}
					<div class="divider"></div>
					<div class="text-primary">إضافة درجات</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card my-5">
				<div class="card-body">
					الدرجة
					<input type="number" name="point" class="form-control">
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card my-5">
				<div class="card-body">
					حدد المناسبة
					<select class="form-control" name="cate">
						<option>الحضور في الوقت</option>
						<option>متميز في السلوك</option>
					</select>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<input type="hidden" name="circle_id" value="{{$circle->id}}">
			<input type="hidden" name="student_id" value="{{$student->id}}">
			<button class="btn bnt-sm btn-outline-primary mt-4"> حفظ </button>
		</div>
	</div>
</div>

</form>
@endif