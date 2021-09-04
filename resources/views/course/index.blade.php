<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>اسم الدورة</td>
                    <td>التاريخ</td>
                    <td>حالة الدورة</td>
                    <td>إدارة</td>
                </tr>
                @foreach($courses as $course)
                <tr>
                    <td>{{$course->title}}</td>
                    <td>
                        <div>تبدأ {{$course->startAt}}</div>
                        <div>تنتهي {{$course->endAt}}</div>
                    </td>
                    <td>
                        @if($course->status=='coming') قادمة @endif
                        @if($course->status=='now') جارية @endif
                        @if($course->status=='past') ماضية @endif
                    </td>
                    
                    <td>
                        <a class="btn btn2 color1" href="{{route('course.status.edit',['course'=>$course->id])}}">تعديل حالة الدورة</a>
                        <a class="btn btn2 color1" href="{{route('course.edit',['course'=>$course->id])}}">تعديل</a>
                        <a class="btn btn2 color1" href="{{route('course.detail.create',['course'=>$course->id])}}">التوصيف</a>
                        <a class="btn btn2 color1" href="{{route('course.student.male_index',['course'=>$course->id])}}">المتدربين {{__('males')}}</a>
                        <a class="btn btn2 color1" href="{{route('course.student.female_index',['course'=>$course->id])}}">المتدربين {{__('females')}}</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
</x-app-layout>
