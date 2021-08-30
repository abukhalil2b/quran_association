<div class="col-md-12">
    ذكور
    @foreach($malestudents as $student)
    <div class="card mt-1">
       <span class="px-1 "> ({{$student->id}}) {{$student->name}}</span>
        <div class="px-1">
            {{$student->phone}}
            <div  class="text-xs pt-2 {{$student->active?'text-success':'text-danger'}}">
                <a class="px-2" href="{{route('student.edit',['student'=>$student->id])}}">تعديل</a>
                <a class="px-2" href="{{route('student.active.toggle',['student'=>$student->id])}}">تعطيل وتفعيل</a>
                <a class="px-2" href="{{route('student.active.toggle',['student'=>$student->id])}}">تعطيل وتفعيل</a>
                ({{$student->active?'مفعل':'معطل'}})
            </div>
        </div>
        <small class=" mr-3 text-info">{{__('circles')}}: {{$student->circles->count()}}</small>
    </div>
    @endforeach
</div>