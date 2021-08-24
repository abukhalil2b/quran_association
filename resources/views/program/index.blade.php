<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>الإسم</td>
                    <td>إدارة</td>
                </tr>
                @foreach($programs as $program)
                <tr>
                    <td class="display-flex">
                        <div class="namecontainer">
                            <span class="name"></span>
                            <span class="name">{{$program->title}} - {{$program->building->title}}</span>
                            <span class="name">
                                @if($program->semester)
                                {{$program->semester->title}} - {{$program->semester->year->title}}
                                @else
                                برنامج مستمر
                                @endif
                            </span>
                        </div>
                    </td>
                    <td>
                        <a class="btn" href="{{route('program.edit',['program'=>$program->id])}}">تعديل</a>
                        <a class="btn" href="{{route('program.prepare_for_delete',['program'=>$program->id])}}">حذف</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
</x-app-layout>
