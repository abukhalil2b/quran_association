<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>اضافة بيانات الشهادة  </h4>
                    <h5>{{$course->title}}</h5>
                </div>
                <form method="post" action="{{route('certificate.store',['course'=>$course->id,'gender'=>$gender])}}" enctype="multipart/form-data">
                @csrf
               
                <div class="card-body">
                    @if($gender=='male')
                        @include('certificate._male')
                    @elseif($gender=='female')
                        @include('certificate._female')
                    @endif
                </div>
                <div class="card-body">
                    <button class="btn btn-info btn-block">حفظ</button>
                </div>
                
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>