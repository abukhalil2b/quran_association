<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
			@foreach($teachers as $teacher)
			<div>
				<span class="text-blue-900">{{$teacher->title}}</span> 
				<span class="text-red-600">{{$teacher->accountOwner->name}}</span>
				
				@if($teacher->canOpenRecordAbout('student'))
					<span class="text-success">يملك الصلاحية</span>
				@else
					<span class="text-warning">لا يملك الصلاحية</span>
				@endif
			
				<a class="btn" href="{{route('permission.about.student.toggle',['teacher'=>$teacher->id])}}">تعديل</a>
			</div>
			@endforeach
        </div>
    </div>
</div>
</x-app-layout>
