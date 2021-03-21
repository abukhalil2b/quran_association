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
                            اسم الحلقة
                            <input name="title" class="form-control" placeholder="اسم الحلقة">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="program_id" value="{{$program->id}}">
                            @if(auth()->user()->userType!='supervisor')
                            مشرف الحلقة
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
                            <button class="btn btn-info btn-block  mt-3">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
