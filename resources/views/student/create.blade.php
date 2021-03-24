<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>اضافة طالب  جديد  للمركز</h4>
                </div>
                <div class="card-body">
					<form method="post" action="{{route('student.store')}}">
						@csrf
	                    <table class="table">
							<tr>
	                    		<td>الإسم</td>
	                    		<td>
		                          <input name="name" class="form-control" placeholder="الإسم">
	                            </td>
	                    	</tr>
	                    	<tr>
	                    		<td>كلمة المرور</td>
	                    		<td>
		                          <input name="password" class="form-control" placeholder="كلمة المرور">
	                            </td>
	                    	</tr>
	                    	<tr>
	                    		<td>الجنس</td>
	                    		<td>
		                          <select name="gender" class="form-control">
		                          	<option value="male">{{__('male')}}</option>
		                          	<option value="female">{{__('female')}}</option>
		                          </select>
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
