<x-app-layout>
<div class="container">
     <h5>{{__('students')}}</h5>
    <div class="row">
        @foreach($students as $student)
        <div class="col-md-4 mt-2">
        	<div class="round-box">
                {{$student->name}}
                <hr>
        	</div>
        </div>
        @endforeach
    </div>
</div>
</x-app-layout>