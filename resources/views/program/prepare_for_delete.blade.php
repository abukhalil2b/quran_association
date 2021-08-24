<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        @if(count($circles))
        <div class="col-md-12">
            <h6>يجب عليك حذف الحلقات التالية</h6>
            @foreach($circles as $circle)
            <div class="card">
                <div class="card-body">
                    <a href="{{route('confirm_circle_delete',['circle'=>$circle->id])}}">
                        <span class="text-danger font-bold">{{__('delete')}}</span>
                     {{$circle->title}}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <a class="btn btn-block btn-danger" href="{{route('program.destroy',['program'=>$program->id])}}">{{__('delete')}}</a>
        @endif
    </div>
</div>
</x-app-layout>