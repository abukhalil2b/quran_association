<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="py-4">
			   <h5 class="mt-3"> التقارير المرسلة</h5>
			    <div class="card">
			        <div class="card-body">
			            @foreach($programReports as $programReport)
			            <div>

			                {{$programReport->donedate}} | 
			                {{__($programReport->meeting)}} | 
			                {{$programReport->mission}} | 
			                
			                {{$programReport->evaluation}} | 
			                {{$programReport->note}} 

			                <a class="pull-left text-red-400" href="{{route('program_report.delete',['programReport'=>$programReport->id])}}">
			                	حذف
			                </a>
			            </div>
			            @endforeach
			        </div>
			    </div>
			</div>

		</div>
	</div>
</div>