<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
					<form method="post" action="{{route('user.update',['user'=>$user->id])}}">
						@csrf
                        <div class="form-group">
                            {{__('name')}}
                            <input name="name" class="form-control" value="{{$user->name}}">
                        </div>
                        <div class="form-group">
                            {{__('phone')}}
                            <input name="phone" type="number" class="form-control" value="{{$user->phone}}">
                        </div>
                        <div class="form-group">
                            <select name="active" class="form-control">
                            	<option @if($user->active=='1') selected @endif value="1">{{__('active')}}</option>
                            	<option @if($user->active=='0') selected @endif value="0">{{__('deactive')}}</option>
                            </select>
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
