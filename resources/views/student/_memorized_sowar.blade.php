<div class="container">
	<div class="row">
		<div class="col-lg-12">

			<div class="py-4">
			   <h5 class="mt-3">
			    السور التي يحفظها 

			    @if(auth()->user()->userType=='teacher')
			    <div class="pull-left">
			        <a href="{{route('student.memorized_sowar.create',['student'=>$student->id])}}">
			        + إدارة
			        </a>
			    </div>
			    @endif
			    
			   </h5>
			    <div class="card">
			        <div class="card-body">
			            @foreach($memorizedSowars as $sowar)
			            {{$sowar->sowar->title}}
			            <a class="pull-left text-red-400" href="{{route('student.memorized_sowar.delete',['memorizedSowar'=>$sowar->id])}}">
			                	حذف
			            </a>
			            @endforeach
			        </div>
			    </div>
			</div>

		</div>
	</div>
</div>