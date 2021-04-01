<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>تعديل طالب</h4>
                </div>
                <div class="card-body">
					<form method="post" action="{{route('student.update',['student'=>$student->id])}}">
						@csrf
	                    <table class="table">
							<tr>
	                    		<td>الإسم</td>
	                    		<td>
		                          <input value="{{$student->name}}" name="name" class="form-control" placeholder="الإسم">
	                            </td>
	                    	</tr>
	                    	<tr>
	                    		<td>رقم الهاتف</td>
	                    		<td>
		                          <input value="{{$student->phone}}" name="phone" type="number" class="form-control" placeholder="رقم الهاتف">
	                            </td>
	                    	</tr>
	                    	<tr>
	                    		<td>كلمة المرور</td>
	                    		<td>
		                          <input value="{{$student->password}}" name="password" type="number" class="form-control" placeholder="رقم الهاتف">
	                            </td>
	                    	</tr>
	                    	<tr>
	                    		<td>الجنس</td>
	                    		<td>
		                          <select name="gender" class="form-control">
		                          	<option @if($student->gender=='male') selected @endif value="male">{{__('male')}}</option>
		                          	<option @if($student->gender=='female') selected @endif value="female">{{__('female')}}</option>
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
