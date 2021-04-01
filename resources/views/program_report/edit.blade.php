<x-app-layout>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="py-4">
			   <h5 class="mt-3"> التقارير المرسلة</h5>
			    <div class="card">
			        <div class="card-body">
						<form action="{{route('program_report.update',['programReport'=>$programReport->id])}}" method="post">
							@csrf
							<textarea style="height:80px;" class="form-control" name="mission">{{$programReport->mission}}</textarea>
							<button class="btn btn-info btn-block mt-3">حفظ</button>
						</form>
			        </div>
			    </div>
			</div>

		</div>
	</div>
</div>
</x-app-layout>