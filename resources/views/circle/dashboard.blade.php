<x-app-layout>

<div class="container">
  <div class="row alert alert-info">
      <div class="col-md-12">
        <center >
          <small class="text-primary">الحلقة: </small>{{$circle->title}}
        </center>
      </div>

      <div class="col-md-12">
        <div>
            <small class="text-primary"> المشرف:  </small>
            @if($circle->supervisor)
              {{$circle->supervisor->accountOwner->name}}
            @endif
        </div>
      </div>
      <div class="col-md-12">
        <div>
            <small class="text-primary"> المدرس:  </small>
            @if($circle->teacher)
              {{$circle->teacher->accountOwner->name}}
            @endif
        </div>
      </div>
      <div class="col-md-12">
        <div>
            <small class="text-primary"> البرنامج:  </small>
            @if($circle->program)
              {{$circle->program->title}}
            @endif
        </div>
      </div>
  </div>
</div>

<div class="container">
  <div class="row alert alert-secondary">
    <div class="col-md-4">
          <a class="btn-block" href="{{route('circle.teacher.create',['circle'=>$circle])}}">
            <span class="plus-icon">+</span> إضافة مدرس للحلقة
          </a>
    </div>
    <div class="col-md-4">
          <a class="btn-block" href="{{route('circle.supervisor.create',['circle'=>$circle])}}">
            <span class="plus-icon">+</span> إضافة مشرف للحلقة
          </a>
          </div>
    <div class="col-md-4">
          <a class="btn-block" href="{{route('circle.student.create',['circle'=>$circle])}}">
            <span class="plus-icon">+</span> إضافة طلاب للحلقة
          </a>
    </div>

</div>

<div class="container">
    <div class="row">

      <div class="col-md-12">
        <div  class="text-primary">قائمة الطلاب المسجلون في الحلقة</div>
        <ol>
        	@foreach($circle->students as $student)
        	<div>
            <li class="text-sm">
              <a href="{{route('student.show',['student'=>$student->id])}}">{{$student->name}}</a>
            </li>
          </div>
        	@endforeach
        </ol>
        <hr>
      </div>

      <div class="col-md-12">
        <div  class="text-primary">الحضور والغياب</div>
        <ol>
        @foreach($attendances as $attendance)
          <li>{{$attendance->student->name}} - {{$attendance->present?'وقت الحضور '. $attendance->present_time:'غائب'}}</li>
        @endforeach
        </ol>
      </div>


    </div>
</div>
</x-app-layout>
