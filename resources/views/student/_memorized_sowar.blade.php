<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="py-4">
			    <h5 class="mt-3">
			        السور التي يحفظها
			        @if(auth()->user()->userType=='teacher' || auth()->user()->userType=='usercenter')
			        <div class="pull-left">
			            <a href="{{route('student.memorized_sowar.create',['student'=>$student->id])}}">
			            	@if(count($memorizedSowars))
							+ إدارة
							@else
							+ فتح سجل للحفظ جديد
							@endif
			            </a>
			        </div>
			        @endif
			    </h5>
			    <div class="card">
			        <div class="card-body">
			        <div class="row">
			            @foreach($memorizedSowars as $sowar)
			            <div class="col-lg-2">
			            	<span class="{{$sowar->done?'text-success font-bold':'text-secondary'}}">
			            		{{$sowar->sowar->title}}
			            	</span>
			            </div>
			            @endforeach
			        </div>
			        </div>
			    </div>
			</div>

		</div>
	</div>
</div>