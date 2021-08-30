<x-app-layout>

<div class="container">
	<div class="row mt-3">
        <div class="col-md-12">
        	{{__('females')}}
            <form action="{{route('circle.student.store')}}" method="post">
				@csrf
				<div class="form-group mt-3">
					<input type="hidden" name="circle_id" value="{{$circle->id}}">
					@foreach($femalestudents as $student)
					<div>
						<input type="checkbox" name="student_ids[]" value="{{$student->id}}">
						{{$student->name}}
					</div>
					@endforeach
                    @if(count($femalestudents))
					<button class="btn btn-outline-secondary btn-block">اضافة الطلاب إلى {{$circle->title}}</button>
                    @else
                    <center class="alert alert-warning"><h4>لا يوجد طلبة</h4></center>
                    @endif
				</div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
