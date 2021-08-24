<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>اضافة حلقة  جديد لـ {{$program->title}}</h4>
                </div>
                <div class="card-body">
					<form method="post" action="{{route('circle.store')}}">
						@csrf
                        <div class="form-group">
                            {{__('title')}}
                            <input name="title" class="form-control" >
                        </div>
                        <div class="form-group">
                            {{__('timestart')}}
                            <input name="timestart" class="form-control" type="time" >
                        </div>
                        <div class="form-group">
                            {{__('duration')}}
                            <input name="duration" class="form-control" value="1"> 
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="program_id" value="{{$program->id}}">
                            <div class="row">
                                <div class="col-md-6">
                                    @if(auth()->user()->userType!='supervisor')
                                    {{__('supervisor')}} الحلقة
                                    <select name="supervisor_id" class="form-control" >
                                        @foreach($supervisors as $supervisor)
                                        <option value="{{$supervisor->id}}">
                                            {{$supervisor->accountOwner->name}} -
                                            {{$supervisor->title}} -
                                            {{$supervisor->usercenter()->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    {{__('teacher')}} الحلقة
                                    <select name="teacher_id" class="form-control" >
                                        @foreach($teachers as $teacher)
                                        <option value="{{$teacher->id}}">
                                            {{$teacher->accountOwner->name}} -
                                            {{$teacher->title}} -
                                            {{$teacher->usercenter()->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-info btn-block  mt-3">{{__('save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
