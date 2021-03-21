<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>التاريخ</td>
                    <td>العملية</td>
                    <td>المبلغ</td>
                    <td>الدورة</td>
                    <td>المرفقات</td>
                    <td>إدارة</td>
                </tr>
                @foreach($statements as $statement)
                <tr>
                    <td>{{$statement->date}}</td>
                    <td>{{$statement->state=='income'?'إيرادات':'مصروفات'}}</td>
                    <td>{{abs($statement->amount)}}</td>
                    <td>{{$statement->course->title}}</td>
                    <td>
                        <a href="">download</a>
                    </td>
                    <td>
                        <a class="btn" href="">تعديل</a>
                        <a class="btn" href="">حذف</a>
                    </td>
                </tr>
                @endforeach
                <tr>
                	<td colspan="6"> <b>المتبقي</b> {{$statements->sum('amount')<0?'0':$statements->sum('amount')}}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
</x-app-layout>
