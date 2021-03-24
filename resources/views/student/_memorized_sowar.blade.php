<div class="container">
	<div class="row">
		<div class="col-lg-12">

			<div class="py-4">
			   <h5 class="mt-3">
			    السور التي يحفظها 
			    <div class="pull-left">
			        <a href="{{route('student.memorized_sowar.create',['student'=>$student->id])}}">
			        + إدارة
			        </a>
			    </div>
			   </h5>
			    <div class="card">
			        <div class="card-body">
			            @foreach($memorizedSowars as $sowar)
			            <div>
			                {{$sowar->sowar->title}}
			            </div>
			            @endforeach
			        </div>
			    </div>
			</div>

		</div>
	</div>
</div>