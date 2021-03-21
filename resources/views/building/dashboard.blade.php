<x-app-layout>
<div class="container">

	<div class="row">
		<div class="col-md-12">
			@if(session('status'))
		        <center class="alert alert-{{session('status','info')}}">
		            <b>{{session('message')}}</b>
		        </center>
		    @endif
		</div>
	</div>

    <div class="row">
        <div class="col-md-12">
           <div class="card">
           	<div class="card-body">
              <h2 class="text-center text-red-900">{{$building->title}}</h2>
              @if($semester)
              <div class="text-purple-400">{{$semester->title}}</div>
           		<small>{{$semester->year->title}}</small>
              @endif
           	</div>
           </div>
        </div>
    </div>

    <div class="row">
      <div class="col-md-12 mt-3">
        <div class="card">
          <a class="px-3" href="{{route('program.create',['building'=>$building->id])}}">
              <span class="plus-icon">+</span> إضافة برنامج
          </a>
          <div class="card-body">
            @foreach($programs as $program)
            <h6>
              <a href="{{route('program.dashboard',['program'=>$program])}}">
              البرنامج: {{$program->title}} - <small> {{$program->semester->title}} </small>
              </a>
            </h6>
            <hr>
            @endforeach
          </div>
        </div>
      </div>
    </div>

</div>
</x-app-layout>
