<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            	<div class="card-header">
            		{{$building->title}}
            	</div>
                <div class="card-body">
                	<h5>سيتم حذف البرامج</h5>
                	<h5>سيتم حذف الحلقة</h5>
                	<h5>سيتم حذف التقارير</h5>
					<a class="text-red-600" href="{{route('building.confirm_delete',['building'=>$building->id])}}">
						تأكيد
					</a>
                </div>
                <div class="card-body">
                	@foreach($programs as $program)
                	<h5>
                		{{$program->title}}
                		<small>
                			<div class="text-gray-200">
                				@foreach($program->circles as $circle)
                				<div>{{$circle->title}}</div>
                				@endforeach
                			</div>
                		</small>
                	</h5>
                	@endforeach
                </div>
            </div>
        </div>

    </div>
</div>
</x-app-layout>