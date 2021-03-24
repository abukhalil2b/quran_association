<x-app-layout>
<div class="container">

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
              <span class="plus-icon">+</span> إضافة برنامج مستمر
          </a>
          <a class="px-3" href="{{route('program.quarterly.create',['building'=>$building->id])}}">
              <span class="plus-icon">+</span> إضافة برنامج فصلي
          </a>
          <div class="card-body">
            <h4>البرامج المستمرة</h4>
            @foreach($programs as $program)
            <h6>
              <a href="{{route('program.dashboard',['program'=>$program])}}">
              البرنامج: {{$program->title}}<small>
              </a>
            </h6>
            <hr>
            @endforeach
          </div>
          <div class="card-body">
            <h4>البرامج الفصلية</h4>
            @foreach($quarterlyPrograms as $program)
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
