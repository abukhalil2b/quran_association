<x-app-layout>
<div class="container">
  <div class="row">
      <div class="col-md-12">
        <h2 class="alert alert-info">
          <small>برنامج: {{$program->title}}</small>
        </h2>
        <a href="{{route('circle.create',['program'=>$program])}}">
          <span class="plus-icon">+</span> إضافة حلقة
        </a>
      </div>
  </div>
</div>

<div class="container">
  <div class="row mt-5 text-secondary">
    @foreach($program->circles as $key => $circle)
    <hr>
        <div class="col-md-12 mt-3">
          <div class="card">
            <div class="card-header">
              <h4>
                <a href="{{route('circle.dashboard',['circle'=>$circle->id])}}">
                ({{$key+1}}) {{$circle->title}}
                </a>
              </h4>
            </div>
            <div class="card-body">

              <h5>
                @if($circle->teacher)
                  <small class="text-primary">المدرس: </small> {{$circle->teacher->accountOwner->name}}
                @else
                  <div class="text-warning">لايوجد مدرس</div>
                @endif
              </h5>

              <h5>
                @if($circle->supervisor)
                <small class="text-primary">المشرف: </small> {{$circle->supervisor->accountOwner->name}}
                <a class="pull-left" href="{{route('circle.supervisor.remove',['circle'=>$circle,'program'=>$program])}}">
                  <div class="text-danger">إزالة المشرف</div>
                </a>
                @else
                <div class="text-warning">لايوجد مشرف</div>
                @endif
              </h5>

              <h5>
                @if($circle->students)
                <small class="text-primary">عدد للطلاب: </small>

               {{$circle->students->count()}} @else <div class="text-warning">لايوجد طالب</div> @endif
              </h5>

            </div>
          </div>
        </div>



    @endforeach
  </div>
</div>
</x-app-layout>