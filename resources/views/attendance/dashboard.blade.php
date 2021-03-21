<x-app-layout>

<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="alert alert-secondary">{{$dailyrecord->title}} - {{$dailyrecord->circle->title}}</div>
			@foreach($attendances as $attendance)
				<div class="card mt-2">
					<div class="px-1 py-1">
						{{$attendance->student->name}}  - {{$attendance->present?'وقت الحضور '. $attendance->present_time:'غائب'}}
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
</x-app-layout>