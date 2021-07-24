<x-app-layout>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="py-4">
			    <div class="card">
			        <div class="card-body">
			        	<a class="btn btn-danger btn-block mt-3" href="{{route('program_report.delete',['programReport'=>$programReport->id,'student'=>$student->id])}}">
			        		تأكيد الحذف
			        	</a>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</div>
</x-app-layout>