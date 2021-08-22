<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @foreach($buildings as $building)
            <div class="card mt-2 mb-2 px-2">
                <a href="{{route('building.dashboard',['building'=>$building->id])}}">
                     {{$building->title}}
                     <small class="text-gray-400">{{$building->user->name}}</small>
                </a>
                <hr>
                <a href="{{route('building.show_delete_form',['building'=>$building->id])}}">حذف</a>
            </div>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
