
<div class="container">
    <div class="row">
    	
        <div class="col-md-6">
    		<h4 class="alert alert-info">تقارير المالية</h4>
    		@foreach($finance_reports as $finance_report)
    		<div>{{$finance_report->title}}</div>
    		@endforeach

        </div>
        <div class="col-md-6">

    		<h4 class="alert alert-info">السجلات اليومية</h4>
    		@foreach($dailyrecords as $dailyrecord)
    		<div class="text-sm">
                <a href="{{route('attendance.dashboard',['dailyrecord'=>$dailyrecord->id])}}">
                <div class="">{{$dailyrecord->title}} -
                    {{$dailyrecord->circle->title}} -
                    {{$dailyrecord->created_at->diffForHumans()}}</div>
                </a>
            </div>
    		@endforeach

        </div>
        <div class="col-md-6">
    		<h4 class="alert alert-info">أماكن الدراسة
            | (العدد: {{count($buildings)}}) |
              <a href="{{route('building.create')}}">
                + إضافة ماكن الدراسة
              </a>
            </h4>
    		@foreach($buildings as $building)
    		<div class="card mt-2 mb-2 px-2">
                <a href="{{route('building.dashboard',['building'=>$building->id])}}">
                     {{$building->title}}
                </a>
            </div>
    		@endforeach

        </div>
        <div class="col-md-6">
            <h4 class="alert alert-info">
            المشرفين | (العدد: {{count($supervisors)}}) | <a href="{{route('user.supervisor.create')}}">+ إضافة مشرف</a>
    		</h4>
    		@foreach($supervisors as $key =>  $supervisor)
            <div class="card mt-2 mb-2 px-2">
                 <a href="{{route('supervisor.dashboard',['supervisor'=>$supervisor->id])}}">
                   <div>الاسم: {{$supervisor->accountOwner->name}}</div>
                   <div><small class="text-info">{{$supervisor->title}}</small></div>
                   <div>الهاتف:  <small>{{$supervisor->accountOwner->phone}}</small></div>
                </a>
                <div>البريد الالكتروني:  <small>{{$supervisor->accountOwner->email}}</small></div>
            </div>
    		@endforeach
        </div>

        <div class="col-md-6">

    		<h4 class="alert alert-info">
            المدرسين | <a href="{{route('user.teacher.create')}}">+ إضافة مدرس</a>
            </h4>
            <h5>ذكور | (العدد: {{count($maleTeachers)}}) </h5>
            @foreach($maleTeachers as $key =>  $teacher)
            <div class="card mt-2 mb-2 px-2">
                <a href="{{route('user.teacher.show',['teacher'=>$teacher->id])}}">
                    <div>الاسم: {{$teacher->accountOwner->name}}</div>
                     <div><small class="text-info">{{$teacher->title}}</small></div>
                     <div>الهاتف:  <small>{{$teacher->accountOwner->phone}}</small></div>
                </a>
                <div>البريد الالكتروني:  <small>{{$teacher->accountOwner->email}}</small></div>
            </div>
            @endforeach

            <h5>إناث | (العدد: {{count($femaleTeachers)}}) </h5>
    		@foreach($femaleTeachers as $key =>  $teacher)
    		<div class="card mt-2 mb-2 px-2">
                <a href="{{route('user.teacher.show',['teacher'=>$teacher->id])}}">
                    <div>الاسم: {{$teacher->accountOwner->name}}</div>
                     <div><small class="text-info">{{$teacher->title}}</small></div>
                     <div>الهاتف:  <small>{{$teacher->accountOwner->phone}}</small></div>
                </a>
                <div>البريد الالكتروني:  <small>{{$teacher->accountOwner->email}}</small></div>
            </div>
    		@endforeach

        </div>

        <div class="col-md-6">
            <h4 class="alert alert-info">
            الطلاب | <a href="{{route('student.create')}}">+ إضافة طلاب</a>
            </h4>
            <h5>زكور  | (العدد: {{count($maleStudents)}}) </h5>
            @foreach($maleStudents as $key => $student)
            <div class="card mt-2 mb-2 px-2">
                <div>رقم الطالب: {{$student->id}}</div>
                <div>الاسم: {{$student->name}}</div>
                <div>الهاتف: {{$student->phone}}</div>
            </div>
            @endforeach
            <h5>إناث  | (العدد: {{count($femaleStudents)}}) </h5>
            @foreach($femaleStudents as $key => $student)
            <div class="card mt-2 mb-2 px-2">
                <div>رقم الطالب: {{$student->id}}</div>
                <div>الاسم: {{$student->name}}</div>
                <div>الهاتف: {{$student->phone}}</div>
            </div>
            @endforeach

        </div>

        <div class="col-md-6">
    		<h4 class="alert alert-info">
            المدربين | (العدد: {{count($trainers)}}) | <a href="{{route('user.trainer.create')}}">+ إضافة مدرب</a>
            </h4>
    		@foreach($trainers as $trainer)
    		<div class="card mt-2 mb-2 px-2">
                {{$trainer->accountOwner->name}} - {{$trainer->title}}
                <small>{{$trainer->accountOwner->email}}</small>
            </div>
    		@endforeach
        </div>

        <div class="col-md-6">

    		<h4 class="alert alert-info">المتدربين</h4>
    		@foreach($trainees as $trainee)
    		<div>{{$trainee->accountOwner->name}} - {{$trainee->title}}</div>
    		@endforeach
        </div>

        <div class="col-md-6">

            <h4 class="alert alert-info">
                صلاحيات
                
            </h4>
            <div class="card mt-2 mb-2 px-2">
                 <a href="{{route('permission.about.student')}}">قدرة المدرسين على فتح سجل الحضور والغياب للطلاب</a>
            </div>
           
        </div>

    </div>
</div>
