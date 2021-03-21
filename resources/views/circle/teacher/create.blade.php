<x-app-layout>
<div class="container">
	<div class="row mt-3">
        <div class="col-md-12">
            <form action="{{route('circle.teacher.store')}}" method="post">
				@csrf
				<div class="form-group mt-3">
					<select name="teacher_id" class="form-control">
						@foreach($teachers as $teacher)
						<option value="{{$teacher->id}}"> {{$teacher->accountOwner->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group mt-3">
					<button class="btn btn-outline-secondary btn-block">تعيين مدرس لـ {{$circle->title}}</button>
				</div>
				<div class="form-group mt-3">
					<input type="hidden" name="circle_id" value="{{$circle->id}}">
				</div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
