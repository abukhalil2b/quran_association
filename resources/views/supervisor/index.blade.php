<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>الإسم</td>
                    <td>إدارة</td>
                </tr>
                @foreach($supervisors as $supervisor)
                <tr>
                    <td class="display-flex">
                        <a href="{{route('supervisor.dashboard',['supervisor'=>$supervisor->id])}}">
                        <img class="avatar" src="{{asset('img/avatar/avatar.png')}}" alt="avatar">
                        </a>
                        <div class="namecontainer">
                            <span class="name">{{$supervisor->accountOwner->name}}</span>
                            <span class="nametitle">{{$supervisor->usercenter()->name}}</span>
                        </div>

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
