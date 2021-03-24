<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{$teacher->accountOwner->name}}
                </div>
                <div class="card-body">
                    <a class="btn btn-sm btn-info" href="">تعديل</a>
                    
                </div>
            </div>
            <h5 class="mt-5">الحلقات</h5>
            @foreach($circles as $circle)
            <div class="card">
                <div class="card-header">
                    {{$circle->title}}
                </div>
                <div class="p-3">الطلاب</div>
                <div class="card-body">
                    @foreach($circle->students as $key => $student)
                    <div> ({{$key+1}}) {{$student->name}}</div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
