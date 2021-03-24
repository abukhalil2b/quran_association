<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="py-4">
			   <h5 class="mt-3"> التقارير المرسلة</h5>
			    <div class="card">
			        <div class="card-body">
			            @foreach($programReports as $report)
			            <div>
			                {{$report->donedate}} | 
			                {{__($report->meeting)}} | 
			                {{$report->mission}} | 
			                
			                {{$report->evaluation}} | 
			                {{$report->note}} 
			            </div>
			            @endforeach
			        </div>
			    </div>
			</div>

		</div>
	</div>
</div>