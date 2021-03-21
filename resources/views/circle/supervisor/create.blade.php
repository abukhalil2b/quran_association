<x-app-layout>
<div class="container">
	<div class="row mt-3">
        <div class="col-md-12">
            <form action="{{route('circle.supervisor.store')}}" method="post">
				@csrf
				<div class="form-group mt-3">
					<select name="supervisor_id" class="form-control">
						@foreach($supervisors as $supervisor)
						<option value="{{$supervisor->id}}"> {{$supervisor->accountOwner->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group mt-3">
					<button class="btn btn-outline-secondary btn-block">تعيين مشرف لـ {{$circle->title}}</button>
					</div>
					<div class="form-group mt-3">
					<input type="hidden" name="circle_id" value="{{$circle->id}}">
				</div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
