<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h4>كتابة التقرير</h4>
                </div>
                <div class="card-body">
					<form method="post" action="{{route('statement.store')}}">
						@csrf
                    <table class="table">
						<tr>
                    		<td>التأريخ</td>
                    		<td>
                          		<input type="date" name="date" value="{{date('Y-m-d',time())}}" class="form-control">
                            </td>
                    	</tr>
                    	<tr>
                    		<td>العملية</td>
                    		<td>
                    			<select name="state" class="form-control">
                    				<option value="income">إيرادات</option>
                    				<option value="expense">مصروفات</option>
                    			</select>
                    		</td>
                    	</tr>
                    	<tr>
                    		<td>المبلغ</td>
                    		<td><input type="number" step="0.1" name="amount" class="form-control"></td>
                    	</tr>
                        <tr>
                            <td>مرفق</td>
                            <td>
                                <small class="text-red-400">لاتعمل حاليا</small>
                                <input type="file" name="file" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>البيان</td>
                            <td><input name="details" class="form-control"></td>
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
        <div class="col-md-12">
        	<div class="alert alert-info mt-1">الأشهر</div>
            <div class="alert alert-warning">
                <form action="{{route('statement.search')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col">
                            من
                            <input type="date" name="fromDate" class="form-control">
                        </div>
                        <div class="col">
                            إلى
                            <input type="date" name="toDate" class="form-control">
                        </div>
                        <div class="col">
                            المصروفات
                            <input type="radio" name="state" class="state" value="expense">
                            الإيرادات
                            <input type="radio" name="state" class="state" value="income">
                            الكل
                            <input type="radio" name="state" class="state" value="" checked>
                            <button class="btn btn-warning btn-block">بحث</button>
                        </div>
                    </div>
                </form>
            </div>
            @foreach($months as $month)
            <a href="{{route('statement.details',['date'=>$month->date])}}" >
        	<div class="alert alert-warning">
                الشهر <b>{{$month->month}} </b>
                (العدد: {{$month->count($month->date)}})
                <span class="text-sm"> التاريخ: {{$month->date}}</span>
            </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
