<x-app-layout>
<div class="container">
    <div class="row">
    	<div class="col-md-12">
    		<div class="card">
    			<div class="card-body">
    				{{$course->title}}
    				<hr>
    				ال{{__('teacher')}}
    				{{$course->teacher->accountOwner->name}}
    			</div>
    		</div>
    	</div>
    	<div class="col-md-12 mt-5">
    		<h5>ال{{__('students')}}</h5>
    	</div>
        @foreach($studentsWithCertificates as $student)
        <div class="col-md-4 mt-1">
        	<div class="round-box">
                {{$student->name}}
                <hr>
                <a href="{{route('certificate.show',['course'=>$course->id,'student'=>$student->id])}}">عرض الشهادة</a>
        	</div>
        </div>
        @endforeach
    </div>
</div>
</x-app-layout>