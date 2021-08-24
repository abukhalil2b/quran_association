<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            	<div class="card-body">
            		<h4>{{__('confirm_delete')}}</h4>
            		<h6>سيتم حذف التقارير عددها ({{$programReportsCount}})</h6>
            		<h6>سيتم فصل الطلاب عددهم({{$studentsCount}})</h6>
            		<h6>سيتم حذف سجل الحضور ({{$dailyrecordsCount}})</h6>
            		<h6>سيتم حذف الدرجات التي حصل عليها الطالب في هذه الحلقة ({{$marksCount}})</h6>
            		<a class="btn  text-danger" href="{{route('circle.destroy',['circle'=>$circle->id])}}">{{__('confirm_delete')}}</a>
            	</div>
            </div>
        </div>
    </div>
</div>
<script>
	
</script>
</x-app-layout>
