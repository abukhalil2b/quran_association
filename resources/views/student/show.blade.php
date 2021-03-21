<x-app-layout>
<div class="container">
    <div class="row">
    	<div class="col-md-4">
    		<h5><span class="text-primary">حلقات الطالب: </span>{{$student->name}}</h5>
    	</div>
    	<div class="col-md-12">
    		@foreach($circles as $key => $circle)
            <div class="card mt-3">
                <a class="alert alert-secondary" href="{{route('student.circle.show',['circle'=>$circle->id])}}">
                 [{{$key+1}}] {{$circle->title}} 
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
                        {{$circle->program->semester->year->title}} -
                        {{$circle->program->semester->title}}
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

            <div class="py-4">
               <h5 class="mt-3"> التقارير المرسلة</h5>

                <div class="card">
                    <div class="card-body">
                        @foreach($programReports as $report)
                        <div>
                            {{$report->donedate}} | 
                            {{__($report->meeting)}} | 
                            {{$report->mission}} | 
                            
                            {{$report->evaluation}} | 
                            {{$report->note}} 
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="py-4">
                <h5 class="mt-3">
                    الأجزاء التي يحفظها
                    <div class="pull-left">
                        <a href="{{route('student.memorized_juz.create',['student'=>$student->id])}}">+ إدارة</a>
                    </div>
                </h5>
                <div class="card">
                    <div class="card-body">
                        @foreach($memorizedJuzs as $juz)
                        <div>
                            {{$juz->juz->title}}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="py-4">
               <h5 class="mt-3">
                السور التي يحفظها 
                <div class="pull-left">
                    <a href="{{route('student.memorized_sowar.create',['student'=>$student->id])}}">
                    + إدارة
                    </a>
                </div>
               </h5>
                <div class="card">
                    <div class="card-body">
                        @foreach($memorizedSowars as $sowar)
                        <div>
                            {{$sowar->sowar->title}}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>


    		<div class="card my-5">
                <div class="card-body">
                    <form action="{{route('student.mark.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                مجموع الدرجات : {{$student->marks->where('circle_id',$circle->id)->sum('point')}}
                                <div class="divider"></div>
                                <div class="text-primary">إضافة درجات</div>
                            </div>
                            <div class="col-md-4">
                                الدرجة
                                 <input type="number" name="point" class="form-control">
                            </div>
                            <div class="col-md-4">
                                حدد المناسبة
                                 <select class="form-control" name="cate">
                                     <option>الحضور في الوقت</option>
                                     <option>متميز في السلوك</option>
                                 </select>
                            </div>
                            <div class="col-md-4">
                                <input type="hidden" name="circle_id" value="{{$circle->id}}">
                                <input type="hidden" name="student_id" value="{{$student->id}}">
                                 <button class="btn bnt-sm btn-outline-primary mt-4"> حفظ </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    		@endforeach
    	</div>

    </div>
</div>
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
