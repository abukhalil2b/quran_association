<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                @foreach($teachers as $teacher)
                 <div class="card mt-2  px-1 py-1">
                    <div class="display-flex">
                        <img class="avatar" src="{{asset('img/avatar/avatar.png')}}" alt="avatar">
                        <div class="namecontainer">
                            <span class="name">{{$teacher->accountOwner->name}}</span>
                            <span class="nametitle">{{$teacher->usercenter()->name}}</span>
                        </div>
                    </div>
                    <div><small class="text-info">{{$teacher->title}}</small></div>
                    <div>الهاتف:  <small>{{$teacher->accountOwner->phone}}</small></div>
                    <div>البريد الالكتروني:  <small>{{$teacher->accountOwner->email}}</small></div>
                </div>
                <a href="{{route('user.teacher.show',['teacher'=>$teacher->id])}}">
                الحلقات {{$teacher->circles->count()}}
                </a>
                <a class="btn" href="{{route('user.teacher.edit',['teacher'=>$teacher->id])}}">تعديل</a>
                <a class="btn" href="">حذف</a>
            
                @endforeach
        </div>
    </div>
</div>
</x-app-layout>
