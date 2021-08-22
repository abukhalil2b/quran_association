<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h5>{{$course->title}}</h5>
            <div class="card">
                <div class="card-header">
                   <h4> 
                    اضافة {{__('student')}} من القائمة
                   </h4>
                </div>
                @if(count($studentsDoesntHaveCourses))
                <div class="card-body">
					<form method="post" action="{{route('certificate.add_student_store',['course'=>$course->id])}}" >
						@csrf
						@foreach($studentsDoesntHaveCourses as $student)
                            <input type="checkbox" name="studentIds[]" value="{{$student->id}}">
                            {{$student->name}}
                         <hr>
                        @endforeach
                        <button class="btn btn-outline-secondary btn-block">حفظ</button>
                    </form>
                </div>
                @endif
                @if($studentsHaveCourses)
                @foreach($studentsHaveCertificates as $student)
                <div class="card-body">
                    <a href="">
                        {{$student->name}}
                    </a>
                </div>
                @endforeach
                @else
                <center>لايوجد {{__('student')}} مسجل سابقا</center>
                @endif
            </div>
            <div class="card-body">
                @foreach($maleTrainees as $student)
                <div class="round-box">{{$student->name}}</div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</x-app-layout>