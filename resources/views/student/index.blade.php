<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>الإسم</td>
                    <td>الهاتف</td>
                    <td>الجنس</td>
                    <td>إدارة</td>
                </tr>
                @foreach($students as $student)
                <tr>
                    <td>
                        {{$student->name}}
                    </td>
                    <td>
                        {{$student->phone}}
                    </td>
                    <td>
                       {{__($student->gender)}}
                    </td>
                    <td  class="{{$student->active?'text-success':'text-danger'}}">
                        <a class="btn" href="{{route('student.edit',['student'=>$student->id])}}">تعديل</a>
                        <a class="btn" href="{{route('student.active.toggle',['student'=>$student->id])}}">تعطيل وتفعيل</a>
                        ({{$student->active?'مفعل':'معطل'}})
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
</x-app-layout>
