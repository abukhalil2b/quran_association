<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    نقل [ {{$student->name}} ] إلى
					<form method="post" action="{{route('student.transfer.supervisorscope.store')}}">
						@csrf
	                    <select name="receiverSupervisorId" class="form-control mt-1">
	                    	@foreach($supervisors as $supervisor)
	                    	<option value="{{$supervisor->id}}">{{$supervisor->user->name}}</option>
	                    	@endforeach
	                    </select>
	                    <input type="hidden" name="student_id" value="{{$student->id}}">
                        <button class="btn btn-primary btn-block mt-1" type="submit">نقل</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
