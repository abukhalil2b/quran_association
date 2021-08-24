<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            	<div class="card-header">
            		خطوات حذف ( {{$building->title}} )
            	</div>
                @if($building->programs()->count())
                <div class="card-body">
                    <h6>يجب عليك أولا حذف البرامج التالية</h6>
                    @foreach($building->programs()->get() as $program)
                    <h5>
                        <a href="{{route('program.prepare_for_delete',['program'=>$program->id])}}">
                            <span class="text-danger font-bold">{{__('delete')}}</span> {{$program->title}}
                        </a>
                    </h5>
                    @endforeach
                </div>
                @else
                <div class="card-body">
                    <a class="text-red-600" href="{{route('building.confirm_building_delete',['building'=>$building->id])}}">
                        تأكيد
                    </a>
                </div>
                
                @endif
            </div>
        </div>

    </div>
</div>
</x-app-layout>