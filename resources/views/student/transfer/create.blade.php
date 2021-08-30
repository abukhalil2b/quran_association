<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{$student->name}}</h4>
                </div>
                <div class="card-body">
					<form method="post" action="{{route('student.transfer.store',['student'=>$student->id,'circle'=>$circle->id])}}">
						@csrf
	                    <div class="row">
	                    	<div class="col-lg-6">
	                    		<select name="circle_id" class="form-control">
			                    	@foreach($availableCircles as $availableCircle)
			                    	<option value="{{$availableCircle->id}}" @if($availableCircle->id==$circle->id) selected @endif >
			                    		{{$availableCircle->title}} -
			                    		{{$availableCircle->program->title}}
			                    	</option>
			                    	@endforeach
			                    </select>
	                    	</div>
	                    	<div class="col-lg-6">
	                    		<button class="btn btn-primary btn-block">{{__('transfer')}}</button>
	                    	</div>
	                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
</x-app-layout>
