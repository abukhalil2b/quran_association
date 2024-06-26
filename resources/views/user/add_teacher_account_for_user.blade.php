<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>اضافة حساب  {{__('teacher')}} لـ {{$supervisor->accountOwner->name}}</h4>
                </div>
                <div class="card-body">
					<form method="post" action="{{route('add_teacher_account_for_user.store')}}">
					@csrf
                    <table class="table">
                        <tr>
                    		<td>وصف</td>
                    		<td>
                              <input name="title" class="form-control mt-1" placeholder="تعريف قصير">
                            </td>
                    	</tr>
                        <tr>
                            <td colspan="2">
                            	<input type="hidden" name="supervisor_id" value="{{$supervisor->id}}">
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
