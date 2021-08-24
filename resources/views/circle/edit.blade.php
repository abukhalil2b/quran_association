<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{$circle->title}}
                </div>
                <div class="card-body">
					<form method="post" action="{{route('circle.update',['circle'=>$circle->id])}}">
						@csrf
                        <div class="form-group">
                            {{__('title')}}
                            <input name="title" class="form-control" value="{{$circle->title}}">
                        </div>
                        <div class="form-group">
                            {{__('timestart')}}
                            <input name="timestart" type="time" class="form-control" value="{{$circle->timestart}}">
                        </div>
                        <div class="form-group">
                            {{__('duration')}}
                            <input name="duration" class="form-control" value="{{$circle->duration}}">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info btn-block">{{__('save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
</x-app-layout>
