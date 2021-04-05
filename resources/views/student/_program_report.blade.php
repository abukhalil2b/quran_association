
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="py-4">
			<h5 class="mt-3"> التقارير المرسلة</h5>
				@foreach($programReports as $programReport)
				<div class="card p-2 mt-2">
					<div class="text-gray-400">{{$programReport->donedate}}</div>
					<div>{{__($programReport->meeting)}} </div>
					<p>
					{!!nl2br($programReport->mission)!!}
					</p>
					<div class="text-blue-800">{{$programReport->evaluation}}</div>
					<div class="text-red-800">{!!nl2br($programReport->note)!!}</div>
					<div class="text-left">
						<a class="text-red-400 mx-2" href="{{route('program_report.delete',['programReport'=>$programReport->id])}}">
						حذف
						</a>
						<a class="text-yellow-600 mx-2" href="{{route('program_report.edit',['programReport'=>$programReport->id])}}">
						تعديل
						</a>
					</div>
					 <small  class="text-gray-400">{{$programReport->created_at->diffForHumans()}}</small>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
