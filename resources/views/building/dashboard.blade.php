<x-app-layout>
<div class="container">

    <div class="row">
        <div class="col-md-12">
           <div class="card">
           	<div class="card-body">
              <h2 class="text-center text-red-900">{{$building->title}}</h2>
           	</div>
           </div>
        </div>
        <div class="col-lg-6">
          <a class="px-3" href="{{route('program.create',['building'=>$building->id])}}">
              <span class="plus-icon">+</span> إضافة برنامج مستمر
          </a>
        </div>
        <div class="col-lg-6">
          <a class="px-3" href="{{route('program.quarterly.create',['building'=>$building->id])}}">
              <span class="plus-icon">+</span> إضافة برنامج فصلي
          </a>
        </div>
    </div>

    <div class="row">
      <div class="col-md-12 mt-3">
        <h4>البرامج المستمرة</h4>
        @foreach($programs as $program)
          <div class="card mt-1">
            <a href="{{route('program.dashboard',['program'=>$program])}}">
              البرنامج: {{$program->title}}<small>
            </a>
          </div>
        @endforeach
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-12 mt-3">
        <h4>البرامج الفصلية</h4>
        @foreach($quarterlyPrograms as $program)
        <div class="card mt-1">
          <a href="{{route('program.dashboard',['program'=>$program])}}">
          البرنامج: {{$program->title}} - <small> {{$program->semester->title}} </small>
          </a>
        </div>
        @endforeach
      </div>
    </div>

</div>
</x-app-layout>
