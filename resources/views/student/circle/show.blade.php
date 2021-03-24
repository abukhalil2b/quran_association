<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 >
                	{{$circle->title}} - الدرجات
                </h5>
                @include('student._mark')
                @foreach($marks as $mark)
                <div class="divider">{{$mark->student->name}} - {{$mark->point}} <span class="pull-left px-1">{{$mark->cate}}</span></div>
                @endforeach
            </div>
        </div>
    </div>
</div>

</x-app-layout>

