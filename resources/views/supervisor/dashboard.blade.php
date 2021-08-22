<x-app-layout>

<div class="container">
    <div class="row">

    	<div class="col-md-6">
    	   <h4>
                <span class="text-primary">المشرف: </span>
                {{$supervisor->accountOwner->name}}
            </h4>
    	</div>

    	<div class="col-md-6">
    		<h5>
                <span class="text-primary">المركز</span>
                {{$usercenter?$usercenter->name:''}}
            </h5>
    	</div>

        <div class="col-md-12">
            <a class="btn btn-sm btn-info" href="{{route('add_teacher_account_for_user.create',['supervisor'=>$supervisor->id])}}">
                    اضافة حساب مدرس
            </a>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="p-3">برامج الفصل: {{$lastSemester->title}}</div>
                <div class="card-body">
                    @foreach($quarterlyPrograms as $program)
                        <h4>البرنامج: {{$program->title}}</h4>
                        @foreach($program->circles as $circle)
                            <h5>الحلقة: {{$circle->title}}</h5>
                            <h6>السنة الدراسية: {{$circle->program->semester->year->title}} / {{$circle->program->semester->title}}</h6>
                        @endforeach
                        <div class="divider"></div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="p-3">برامج مستمرة</div>
                <div class="card-body">
                    @foreach($programs as $program)
                        <h4>البرنامج: {{$program->title}}</h4>
                        @foreach($program->circles as $circle)
                            <h5>الحلقة: {{$circle->title}}</h5>
                        @endforeach
                        <div class="divider"></div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
</x-app-layout>
