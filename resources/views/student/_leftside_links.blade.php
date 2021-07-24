<small>
    <div  style="float: left;">
    @if($circle->canWriteReport($student))
    يستطيع كتابة التقرير بنفسه
    <div>
        <a class="text-warning" href="{{route('student.circle.disallow-wirte-report',['student'=>$student->id,'circle'=>$circle->id])}}">
        منعه
        </a>
    </div>
    @else
    لا يستطيع كتابة التقرير بنفسه
    <div>
        <a class="text-warning" href="{{route('student.circle.allow-wirte-report',['student'=>$student->id,'circle'=>$circle->id])}}">
        السماح له
        </a>
    </div>
    @endif 
    <hr>
    <div>
        حالة االدراسة: 
        <span id="js-currentStatus">
            <span class="text-primary font-bold">{{__($circle->studentStudyStatus($student))}}</span>
            <span class="text-warning">تغير الحالة</span>
        </span>
        <span id="js-editform">
            <form action="{{route('student.circle.update_status',['student'=>$student->id,'circle'=>$circle->id])}}" method="post">
                @csrf
                <select name="status" class="select-style">
                    <option @if($circle->studentStudyStatus($student) =='studying') selected @endif value="studying">{{__('studying')}}</option>
                    <option @if($circle->studentStudyStatus($student) =='completed') selected @endif value="completed">{{__('completed')}}</option>
                    <option @if($circle->studentStudyStatus($student) =='withdraw') selected @endif value="withdraw">{{__('withdraw')}}</option>
                </select>
                <button type="submit" class="save-btn text-warning">حفظ</button>
            </form>
        </span>
    </div>
    </div>
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

<script>
    var form = document.querySelector('#js-editform');
    var currentStatus = document.querySelector('#js-currentStatus');
    form.style.display='none';
    currentStatus.addEventListener('click',()=>{
        form.style.display='block';
        currentStatus.style.display='none';
    });
</script>

<style>
    .select-style{
        border: none;
        outline: none;
        scroll-behavior: smooth;
    }
    .select-style:focus{
        border: none;
        outline: none;
        scroll-behavior: smooth;
        -webkit-box-shadow: none;
    }
    .save-btn:focus{
        border: none;
        outline: none;
        scroll-behavior: smooth;
        -webkit-box-shadow: none; 
    }
</style>