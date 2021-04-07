<div class="container">
	<div class="row">
		<div class="col-lg-12">

			<div class="py-4">
			    <h5 class="mt-3">
			        الأجزاء التي يحفظها
			        @if(auth()->user()->userType=='teacher')
			        <div class="pull-left">
			            <a href="{{route('student.memorized_juz.create',['student'=>$student->id])}}">+ إدارة</a>
			        </div>
			        @endif
			    </h5>
			    <div class="card">
			        <div class="card-body">
			            @foreach($memorizedJuzs as $juz)
			            <div>
			            	{{$juz->juz->title}}
			                <a class="pull-left text-red-400" href="{{route('student.memorized_juz.delete',['memorizedjuz'=>$juz->id])}}">
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