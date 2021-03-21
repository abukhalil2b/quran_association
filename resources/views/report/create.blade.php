<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{route('report.store')}}" method="post" >
                @csrf
                <table class="table table-bordered table-striped">
                    <tr>
                        <td >
                            الموضوع
                            <input name="title" value="تصفية شهر نوفمبر 2020 لمركز ولاية العامرات" class="form-control text-center">
                        </td>
                        <td>
                            التاريخ
                            <input type="date" name="date" value="" class="form-control text-center">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            الرصيد الموجود في الحساب
                            <input type="number" id="inbank" name="inbank" value="0" class="form-control text-center">
                        </td>
                        <td>
                           مجموع الإيرادات
                           <input type="number" id="totalRevenues" name="totalRevenues" value="0" class="form-control text-center">
                        </td>

                    </tr>
                    <tr>
                        <td>
                           مجموع المصروفات
                           <input type="number" id="totalExpenses" name="totalExpenses" value="0" class="form-control text-center">
                        </td>
                        <td >
                            نسبة الجمعية %
                            <input type="number" name="tax" value="0" class="form-control text-center">
                        </td>
                    </tr>
                    <tr>

                        <td>
                           الرصيد الحالي المتبقي
                           <input id="balance" type="number" name="balance" value="0" class="form-control text-center">
                        </td>
                        <td >
                            <button class="btn btn-block btn-primary" type="">حفظ التقرير</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table">
            <tr>
               <td> التأريخ </td>
               <td>  العنوان </td>
               <td>  الرصيد في البنك </td>
               <td>  مجموع المصروفات</td>
               <td>  مجموع الإيرادات</td>
               <td>  نسبة الجمعية</td>
               <td>  الرصيد المتبقي </td>
               <td>  ملحوظات</td>
               <td>  الملف </td>
            </tr>
            @foreach($reports as $report)
            <tr>
               <td> {{$report->date}}</td>
               <td> {{$report->title}}</td>
               <td> {{$report->inbank}}</td>
               <td> {{$report->totalExpenses}}</td>
               <td> {{$report->totalRevenues}}</td>
               <td> {{$report->tax}}</td>
               <td> {{$report->balance}}</td>
               <td> {{$report->note}}</td>
               <td>
                <a href="">print</a>
               </td>
            </tr>
            @endforeach
            </table>
        </div>
    </div>
</div>

<script>
    var balanceValue = document.getElementById('balance').value;
    var inbankValue = document.getElementById('inbank').value;
$(()=>{

})
</script>
</x-app-layout>