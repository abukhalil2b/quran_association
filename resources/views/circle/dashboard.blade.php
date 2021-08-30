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
    <div class="col-md-3">
          <a class="btn-block" href="{{route('circle.teacher.create',['circle'=>$circle])}}">
            <span class="plus-icon">+</span> إضافة مدرس للحلقة
          </a>
    </div>
    <div class="col-md-3">
          <a class="btn-block" href="{{route('circle.supervisor.create',['circle'=>$circle])}}">
            <span class="plus-icon">+</span> إضافة مشرف للحلقة
          </a>
          </div>
    <div class="col-md-3">
          <a class="btn-block" href="{{route('circle.malestudent.create',['circle'=>$circle])}}">
            <span class="plus-icon">+</span> إضافة طلاب للحلقة ( {{__('males')}} )
          </a>
    </div>
    <div class="col-md-3">
          <a class="btn-block" href="{{route('circle.femalestudent.create',['circle'=>$circle])}}">
            <span class="plus-icon">+</span> إضافة طلاب للحلقة ( {{__('females')}} )
          </a>
    </div>

</div>

<div class="container">
    <div class="row">

      <div class="col-md-12">
        <div  class="text-primary">قائمة الطلاب المسجلون في الحلقة</div>
        <ol>
        	@foreach($students as $student)
        	<div>
            <div class="text-sm">
              <a href="{{route('student.show',['student'=>$student->id,'circle'=>$circle->id])}}">[{{$student->id}}] {{$student->name}}</a>
              <a href="{{route('student.transfer.create',['student'=>$student->id,'circle'=>$circle->id])}}" class="pull-left">{{__('transfer')}}</a>
              <div class="divider"></div>
            </div>
           
          </div>
        	@endforeach
        </ol>
        <hr>
      </div>

      <div class="col-md-12">
        <div  class="text-primary">الحضور والغياب</div>
        <ol>
        @foreach($attendances as $attendance)
          <div>
            {{$attendance->student->name}} 
            <div class="pull-left">
              @if($attendance->present)
              <div class="text-green-400">حاضر</div>
              @else
              <div class="text-red-300">غائب</div>
              @endif
            </div>
          </div>
        @endforeach
        </ol>
      </div>


    </div>
</div>
</x-app-layout>
