<div class="col-lg-12">
    		<div class="card mt-3">
	    		<div class="card-header">
                    <div>
                        <small class="text-primary">البرنامج: </small>{{$circle->program->title}} -
    	    			<small class="text-primary">الحلقة: </small>{{$circle->title}}
                    </div>
                    <div>
                        <small class="text-primary">المشرف على الحلقة: </small>{{$circle->supervisor->accountOwner->name}}
                    </div>
                    <div>
    	    			<small class="text-primary">الفصل: </small>{{$circle->program->semester->title}} -
    	    			<small class="text-primary">السنة الدراسية: </small>{{$circle->program->semester->year->title}}
                    </div>

                    <div class="card">
                        <div class="card-body">
                           
                            @if($lastDailyrecord)
                            <div>{{$lastDailyrecord->title}}</div>
                            <small>{{$lastDailyrecord->created_at->format('d m Y')}}</small>
                            <a class="pull-left" href="{{route('attendance.student.create',['circle'=>$circle->id])}}">+ اضافة الطلاب في السجل</a>
                            <ol>
                            @foreach($presentStudents as $presentStudent)
                                <small>
                                    <li>
                                    {{$presentStudent->student->name}} - {{$presentStudent->present?'وقت الحضور '. $presentStudent->present_time :' غائب'}}
                                    </li>
                                </small>
                            @endforeach
                            </ol>
                            <div class="text-warning">{{count($presentStudents)===0?'لم يتم تسجيل الحضور والغياب':''}}</div>
                            @else
                            <form method="post" action="{{route('dailyrecord.store')}}">
                            @csrf
                            <input type="hidden" name="title" class="form-control" value="سجل الحضور والغياب ">
                            <input type="hidden" name="circle_id" value="{{$circle->id}}">
                            <input type="hidden" name="about" value="student">
                            <button class="btn btn-sm btn-secondary">+ فتح السجل</button>
                            </form>
                            @endif
                        </div>
                    </div>
                    

	    		</div>
				<div class="card-body">
					الطلاب
					<ol>
					@foreach($circle->students as $student)
						<li>
							<a href="{{route('student.show',['student'=>$student->id])}}">
							{{$student->name}}
							</a>
						</li>
					@endforeach
					</ol>
				</div>
    		</div>
    	</div>