<x-app-layout>
<div class="container">
    <div class="row">
        @foreach($semesters as $semester)
        <div class="col-md-12">
        	{{$semester->title}}
        	<b>{{$semester->year->title}}</b>
        </div>
        @endforeach
    </div>
</div>
</x-app-layout>
