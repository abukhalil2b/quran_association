<div class="col-lg-12  mt-1">
    <div class="card p-2">
        <div class="card-body">
            @if($quarterlyProgramLastDailyrecord)
            <div>{{$quarterlyProgramLastDailyrecord->title}}</div>
            <small>{{$quarterlyProgramLastDailyrecord->created_at->format('d m Y')}}</small>
            <a class="pull-left" href="{{route('attendance.student.create',['circle'=>$quarterlyProgramCircle->id])}}">
            + اضافة الطلاب في السجل</a>
            <ol>
            @foreach($quarterlyProgramPresentStudents as $quarterlyProgramPresentStudent)
                <small>
                    <li>
                    {{$quarterlyProgramPresentStudent->student->name}} - {{$quarterlyProgramPresentStudent->present?'وقت الحضور '. $quarterlyProgramPresentStudent->present_time :' غائب'}}
                    </li>
                </small>
           @endforeach
            </ol>
            <div class="text-warning">{{count($quarterlyProgramPresentStudents)===0?'لم يتم تسجيل الحضور والغياب':''}}</div>
            @else
            <form method="post" action="{{route('dailyrecord.store')}}">
                @csrf
                <input type="hidden" name="title" class="form-control" value="سجل الحضور والغياب ">
                <input type="hidden" name="circle_id" value="{{$quarterlyProgramCircle->id}}">
                <input type="hidden" name="about" value="student">
                <button class="btn btn-sm btn-secondary">+ فتح السجل</button>
            </form>
            @endif
        </div>
    </div>
</div>