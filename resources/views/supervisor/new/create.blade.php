<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>اضافة مشرف  جديد  </h4>
                </div>
                <div class="card-body">

					<form method="post" action="{{route('user.supervisor.new.store')}}">
					@csrf
                    <table class="table">
						<tr>
                    		<td>الإسم</td>
                    		<td>
                          <input name="name" class="form-control" placeholder="الإسم">
                          <input name="title" class="form-control mt-1" placeholder="تعريف قصير">
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
                    		<td>الإيميل</td>
                    		<td><input name="email" class="form-control"></td>
                    	</tr>
                    	<tr>
                    		<td>كلمة المرور</td>
                    		<td><input name="password" class="form-control"></td>
                    	</tr>
                    	<tr>
                    		<td>الهاتف</td>
                    		<td><input type="number" name="phone" class="form-control"></td>
                    	</tr>
                    	<tr>
                    		<td>الرقم المدني</td>
                    		<td><input type="number" name="nationalId" class="form-control"></td>
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
