<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        	<form method="post" action="{{route('student.memorized_sowar.update',['student'=>$student->id])}}">
				@csrf
            <div class="card">
                <div class="card-header">
                    <h4>الأجزاء التي يحفظها الطالب</h4>
                </div>
                <div class="card-body">
					<div class="row">
						@foreach($studentMemorizedSowars as $key => $sowar)
						<div class="col-lg-2 col-md-3 col-xs-6 col-xs-6">
	                    <input type="checkbox" name="sowarIds[]" value="{{$sowar->id}}" @if($sowar->done) checked @endif>
	                       {{$sowar->sowar->title}}
                    	</div>
                    	@endforeach
                    </div>
                </div>
            </div>
            <input type="hidden" name="student_id" value="{{$student->id}}">
	        <button class="btn btn-info btn-block mt-2">{{__('save')}}</button>
	        </form>
        </div>

    </div>
</div>
</x-app-layout>

	