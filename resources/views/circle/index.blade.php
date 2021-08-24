<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>الإسم</td>
                    <td>إدارة</td>
                </tr>
                @foreach($circles as $circle)
                <tr>
                    <td >
                         <span class="name">{{$circle->title}}</span>
                    </td>
                    <td>
                        <a class="btn"  href="{{route('circle.edit',['circle'=>$circle->id])}}">تعديل</a>
                        <a class="btn" href="{{route('confirm_circle_delete',['circle'=>$circle->id])}}">حذف</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
<script>
	
</script>
</x-app-layout>
