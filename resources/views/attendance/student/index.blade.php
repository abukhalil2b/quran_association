<x-app-layout>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			{{$circle->title}}
			@foreach($attendances as $attend)
				<div class="card mt-2">
					<a href="{{route('attendance.student.edit',['attendance'=>$attend->id])}}">
						<div class="px-1 py-1">{{$attend->student->name}}</div>
					</a>
				</div>
			@endforeach
		</div>
	</div>
</div>
</x-app-layout>