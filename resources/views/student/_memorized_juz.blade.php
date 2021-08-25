<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="py-4">
			    <h5 class="mt-3">
			        الأجزاء التي يحفظها
			        @if(auth()->user()->userType=='teacher' || auth()->user()->userType=='usercenter')
			        <div class="pull-left">
			            <a href="{{route('student.memorized_juz.create',['student'=>$student->id])}}">
							@if(count($memorizedJuzs))
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
			            @foreach($memorizedJuzs as $juz)
			            <div class="col-lg-2">
			            	<span class="{{$juz->done?'text-success font-bold':'text-secondary'}}">{{$juz->juz->title}}</span>
			            </div>
			            @endforeach
			        </div>
			        </div>
			    </div>
			</div>

		</div>
	</div>
</div>