<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        اضافة حساب لمستخدم موجود 
                        <span class="pull-left">
                            <a href="{{route('user.trainer.new.create')}}">
                                + مستخدم جديد
                            </a>
                        </span>
                    </h4>
                </div>
                <div class="card-body">
					<form method="post" action="{{route('user.trainer.store')}}">
					@csrf
                    <table class="table">
                        <tr>
                            <td>إختر مستخدم</td>
                            <td>
                                <select name="user_id" class="form-control mt-1">
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
						<tr>
                    		<td>الإسم</td>
                    		<td>
                                <input name="title" class="form-control mt-1" placeholder="تعريف قصير">
                            </td>
                    	</tr>
                        <tr>
                            <td colspan="2">
                                <button class="btn btn-info btn-block">حفظ</button>
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
