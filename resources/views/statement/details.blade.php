<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>التاريخ</td>
                    <td>البيان</td>
                    <td>العملية</td>
                    <td>المبلغ</td>
                    <td>المرفقات</td>
                    <td>إدارة</td>
                </tr>
                @foreach($statements as $statement)
                <tr class="{{$statement->state=='income'?'':'btn-secondary'}}">
                    <td>{{$statement->date}}</td>
                    <td>
                        <small>{{$statement->details}}</small>
                    </td>
                    <td>{{$statement->state=='income'?'إيرادات':'مصروفات'}}</td>
                    <td>{{abs($statement->amount)}}</td>
                    <td>
                        <a href="">{{__('download')}}</a>
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
