<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>اضافة مركز  جديد  </h4>
                </div>
                <div class="card-body">
					<form method="post" action="{{route('usercenter.store')}}">
						@csrf
	                    <table class="table">
	                    	<tr>
	                    		<td>
	                    			اسم المركز
	                    			<input name="name" class="form-control">
	                    		</td>
	                    		<td>
	                    			بريد المركز
	                    			<input name="email" class="form-control">
	                    		</td>
	                    		<td>الرقم السري
	                    			<input name="password" class="form-control">
	                    		</td>
	                    	</tr>
	                        <tr>
	                            <td colspan="3">
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