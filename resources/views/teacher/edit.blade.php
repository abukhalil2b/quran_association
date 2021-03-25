<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>تعديل مدرس</h4>
                </div>
                <div class="card-body">
					<form method="post" action="{{route('user.teacher.update',['teacher'=>$teacher->id])}}">
					@csrf
                    <table class="table">
						<tr>
                    		<td>الإسم</td>
                    		<td>
                              <input value="{{$teacher->accountOwner->name}}" name="name" class="form-control" placeholder="الإسم">
                              <input value="{{$teacher->title}}" name="title" class="form-control mt-1" placeholder="تعريف قصير">
                            </td>
                    	</tr>
                        <tr>
                            <td>الجنس </td>
                            <td>
                              <select name="gender" class="form-control">
                                <option @if($teacher->accountOwner->gender=='male') selected="selected" @endif value="male">{{__('male')}}</option>
                                <option @if($teacher->accountOwner->gender=='female')  selected="selected" @endif value="female">{{__('female')}}</option>
                              </select>
                            </td>
                        </tr>
                    	
                    	<tr>
                    		<td>الهاتف</td>
                    		<td><input value="{{$teacher->accountOwner->phone}}" name="phone" type="number" class="form-control"></td>
                    	</tr>
                    	
                    	<tr>
                    		<td>الرقم المدني</td>
                    		<td><input value="{{$teacher->accountOwner->nationalId}}" type="number" name="nationalId" class="form-control"></td>
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