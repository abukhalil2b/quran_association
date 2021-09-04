<x-app-layout>
<div class="container">
    <div class="row ">
        <div class="col-md-12">
          <form 
          @if($genderSearch=='male')
          action="{{route('course.student.male_search',['course'=>$course->id])}}"
          @else
          action="{{route('course.student.female_search',['course'=>$course->id])}}"
          @endif
           method="post">
            @csrf
           <h6>البحث عن الطلاب</h6>
            <div class="row">
              <div class="col-md-4"> 
                <input name="search"  class="btn btn-block" placeholder="البحث بالاسم أو الرقم">
              </div>
              <div class="col-md-4"> 
                <input name="created_at" type="checkbox" value="{{date('Y-m-d',time())}}" style="height: 38px;width: 38px; border-radius: 5px"> فقط المسجلين بتاريخ اليوم
              </div>
              <div class="col-md-4">
                <button class="btn btn-outline-secondary btn-block" type="submit">بحث</button>
              </div>
            </div>
          </form>
          <hr>
        	<h5>{{$course->title}}</h5>
          @if(count($students))
           <form action="{{route('course.student.store',['course'=>$course->id,'gender'=>$genderSearch])}}" method="post">
           	@csrf
           	@foreach($students as $student)
           	<div class="">
           		<input type="checkbox" name="studentIds[]" value="{{$student->id}}">
           		({{$student->id}}) {{$student->name}} - <small>ملتحق بـ {{$student->usercenter()->name}}</small>
           	</div>
           	@endforeach
            <button class="btn btn-outline-secondary btn-block">
              سيكون تاريخ الانضمام للدورة: {{date('Y-m-d',time())}} - ({{__('save')}})
            </button>
            </form>
            @endif
        </div>
    </div>
</div>
</x-app-layout>
