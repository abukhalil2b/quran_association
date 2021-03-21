<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>الإسم</td>
                    <td>الجنس</td>
                    <td>إدارة</td>
                </tr>
                @foreach($students as $student)
                <tr>
                    <td>
                        {{$student->name}}
                    </td>
                    <td>
                       {{__($student->gender)}}
                    </td>
                    <td>
                        <a class="btn" href="">تعديل</a>
                        <a class="btn" href="">حذف</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
</x-app-layout>
