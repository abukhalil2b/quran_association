<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        	<form action="{{route('contractor.store')}}" method="post" enctype="multipart/form-data">
        		@csrf
	        	<table class="table table-striped table-bordered">
	        		<tr>
	        			<td>الإسم</td>
	        			<td>الوظيفة</td>
	        			<td>تاريخ الإنضمام</td>
	        			<td>ينتهي العقد</td>
	        			<td>الملف</td>
	        			<td>إدارة</td>
	        		</tr>
	        		<tr>
	        			<td>
	        				<input name="name" value="" class="form-control">
	        			</td>
	        			<td>
	        				<input name="job" value="" class="form-control">
	        			</td>
	        			<td>
							<input name="join" type="date" class="form-control">
	        			</td>
	        			<td>
	        				<input name="endAt" type="date" class="form-control">
	        			</td>
	        			<td>
	        				<input name="file" type="file" class="form-control">
	        			</td>
	        			<td>
	        				<button type="submit" class="btn btn-secondary">حفظ</button>
	        			</td>
	        		</tr>
	        	</table>
        	</form>
        	<hr>
            <table class="table table-bordered table-striped">
                <tr>
                    <td>اسم الموظف</td>
                    <td>الوظيفة</td>
                    <td>تاريخ الإنضمام</td>
                    <td>ينتهي العقد	 بتاريخ</td>
                    <td>الملف</td>
                    <td>إدارة</td>
                </tr>
                @foreach($contractors as $contractor)
                <tr>
                    <td>{{$contractor->name}}</td>
                    <td>{{$contractor->job}}</td>
                    <td>{{$contractor->join}}</td>
                    <td>
                        {{$contractor->endAt}}
                    </td>
                    <td>
                        <a href="{{asset('storage/'.$contractor->file)}}">تنزيل الملف</a>
                    </td>
                    <td>
                        <a class="btn btn2 color1" href="{{route('contractor.edit',['id'=>$contractor->id])}}">تعديل</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
</x-app-layout>