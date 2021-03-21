<x-app-layout>
<div class="container">
    <div class="row">
        @foreach($years as $year)
        <div class="col-md-12">
        	<h5>{{$year->title}}</h5>
            @foreach($year->semesters as $semester)
            <li>{{$semester->title}}</li>
            @endforeach
        	<a href="{{route('semester.create',['year'=>$year->id])}}">
        	<span class="plus-icon">+</span>
        		 اضافة فصل جديد
        	</a>
            <hr>
        </div>
        @endforeach
    </div>
</div>
</x-app-layout>
