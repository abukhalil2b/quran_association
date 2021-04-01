<x-app-layout>
<div class="container">
    <div class="row">
    	<div class="col-md-4">
    		<h5><span class="text-primary">حلقات الطالب: </span>{{$student->name}}</h5>
    	</div>
    	<div class="col-md-12">
            <div class="card mt-3">
                <a class="alert alert-secondary" href="{{route('student.circle.show',['student'=>$student->id,'circle'=>$circle->id])}}">
                 {{$circle->title}} 
                </a>
                <div class="text-info px-3">
                    <small>
                        <div>
                            <span class="text-primary">المدرس: </span>
                            @if($circle->teacher)
                            {{$circle->teacher->accountOwner->name}}
                            @endif
                        </div>
                        <div><span class="text-primary">البرنامج: </span>{{$circle->program->title}}</div>
                        @if($circle->program->semester)
                        {{$circle->program->semester->year->title}} -
                        {{$circle->program->semester->title}}
                        @else
                        برنامج مستمر
                        @endif
                    </small>
                </div>
                @if($circle->teacher)
                <div class="card-body">
                    <form method="post" action="{{route('program_report.store')}}">
                        @csrf
                        <div class="form-group">
                            حدد نوعية اللقاء
                            <select name="meeting" class="form-control" id="js-meeting">
                                <option value="todaymeeting">{{__('todaymeeting')}}</option>
                                <option value="nextmeeting">{{__('nextmeeting')}}</option>
                            </select>
                        </div>
                        <div class="form-group" id="js-toggle-div">
                            تاريخ اللقاء القادم
                            <input type="date" class="form-control" name="tobedonedate">
                        </div>
                        <div class="form-group">
                            المهمة: اكتب اسم السورة أو الآيات أو الصفحات أو الأجزاء أو المتون أو الدروس
                            <textarea name="mission" class="form-control" style="height:80px;"></textarea>
                        </div>
                        
                        <div class="form-group">
                            التقييم
                            <input class="form-control" name="evaluation">
                        </div>
                        <div class="form-group">
                             ملحوظات (إن وجد)
                           <textarea class="form-control" name="note" style="height:80px;"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="circle_id" value="{{$circle->id}}">
                            <input type="hidden" name="teacher_id" value="{{$circle->teacher->id}}">
                            <input type="hidden" name="student_id" value="{{$student->id}}">
                            <button class="btn btn-info btn-block">ارسال</button>
                        </div>
                    </form>
                </div>
                @else
                <center>لا يوجد مدرس</center>
                @endif
            </div>
    		
    	</div>

    </div>
</div>

@include('student._memorized_juz')
@include('student._memorized_sowar')
@include('student._program_report')

<script>
    var jsMeeting = document.getElementById('js-meeting');
    var jsToggleDiv = document.getElementById('js-toggle-div');
     jsToggleDiv.style.display='none';
    jsMeeting.addEventListener('change',()=>{
        if(jsMeeting.value==='nextmeeting')
           jsToggleDiv.style.display='block';
        else
            jsToggleDiv.style.display='none';
    });
</script>
</x-app-layout>
