
<div class="container">
    <div class="row">
    	
        <div class="col-md-6">
    		<h4 class="alert alert-secondary">
                المالية
                <a href="{{route('statement.create')}}">+اضافة بيان</a>     
            </h4>
        </div>
        
        <div class="col-md-6">
    		<h4 class="alert alert-secondary">
                <a href="{{route('dailyrecord.index')}}">السجلات اليومية</a>
            </h4>
    		@foreach($dailyrecords as $dailyrecord)
            @if($dailyrecord->circle)
    		<div class="text-sm">
                <a href="{{route('attendance.dashboard',['dailyrecord'=>$dailyrecord->id])}}">
                <div class="">{{$dailyrecord->title}} -
                    {{$dailyrecord->circle->title}} -
                    {{$dailyrecord->created_at->diffForHumans()}}</div>
                </a>
            </div>
            @endif
    		@endforeach
        </div>


        <div class="col-md-6">
            <h4 class="alert alert-secondary">
                <a href="{{route('course.index')}}">الدورات</a>
                <a class="pull-left" href="{{route('course.create')}}">+ دورة جديدة</a>
            </h4>
        </div>

        <div class="col-md-6">
    		<h4 class="alert alert-secondary">
                <a href="{{route('building.index')}}">أماكن الدراسة</a>
                
            | (العدد: {{count($buildings)}}) |
              <a href="{{route('building.create')}}">
                + إضافة ماكن الدراسة
              </a>
            </h4>
        </div>
        <div class="col-md-6">
            <h4 class="alert alert-secondary">
            <a href="{{route('user.supervisor.index')}}">المشرفين</a> 
            | (العدد: {{count($supervisors)}}) | <a href="{{route('user.supervisor.create')}}">+ إضافة مشرف</a>
    		</h4>

        </div>

        <div class="col-md-6">

    		<h6 class="alert alert-secondary">
                <a href="{{route('user.teacher.male_index')}}">المدرسين ({{__('males')}} : {{count($maleTeachers)}})</a>
                |
                <a href="{{route('user.teacher.female_index')}}">المدرسين ({{__('females')}} : {{count($femaleTeachers)}})</a>
                | 
                <a href="{{route('user.teacher.create')}}">+ إضافة مدرس</a>
            </h6>

        </div>

        <div class="col-md-6">
            <div class="alert alert-secondary">
            <h5>
                <a href="{{route('student.male_index')}}">
                    الطلاب {{__('males')}}
                    (العدد: {{count($malestudents)}}) 
                </a>

                <a href="{{route('student.female_index')}}">
                    الطلاب {{__('females')}}
                    (العدد: {{count($femalestudents)}}) 
                </a>
            </h5>

            <a href="{{route('student.create')}}">+ إضافة طلاب</a>
            </div>

        </div>

        <div class="col-md-6">

            <h4 class="alert alert-secondary">
                صلاحيات
            </h4>
            <div class="card mt-2 mb-2 px-2">
                 <a href="{{route('permission.about.student')}}">قدرة المدرسين على فتح سجل الحضور والغياب للطلاب</a>
            </div>
           
        </div>


        <div class="col-md-6">
            <h4 class="alert alert-secondary">
                <a href="{{route('program.index')}}">{{__('programs')}}</a>
            </h4>
        </div>


        <div class="col-md-6">
            <h4 class="alert alert-secondary">
                <a href="{{route('circle.index')}}">{{__('circles')}}</a>
            </h4>
        </div>

        <div class="col-md-6">
            <h4 class="alert alert-secondary">
                <a href="{{route('program_report.index')}}">التقارير</a>
            </h4>
        </div>

        <div class="col-md-6">
            <h4 class="alert alert-secondary">
                <a href="{{route('student.can-wirte-program-report.index')}}">الطلاب القادرين على كتابة التقرير بأنفسهم</a>
            </h4>
        </div>

    </div>
</div>
