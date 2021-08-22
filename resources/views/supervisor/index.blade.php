<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @foreach($supervisors as $supervisor)
            <div class="card mt-2  px-1 py-1">
                <div class="display-flex">
                    <img class="avatar" src="{{asset('img/avatar/avatar.png')}}" alt="avatar">
                    <div class="namecontainer">
                        <span class="name">{{$supervisor->accountOwner->name}}</span>
                        <span class="nametitle">{{$supervisor->usercenter()->name}}</span>
                    </div>
                </div>
                <div><small class="text-info">{{$supervisor->title}}</small></div>
                <div>الهاتف:  <small>{{$supervisor->accountOwner->phone}}</small></div>
                <div>البريد الالكتروني:  <small>{{$supervisor->accountOwner->email}}</small></div>
            </div>
            <a class="btn" href="">تعديل</a>
            <a class="btn" href="">حذف</a>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
