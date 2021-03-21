<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @foreach($buildings as $building)
            <a href="{{route('building.dashboard',['building'=>$building->id])}}">
                <span class="btn-block">{{$building->title}}</span>
                <small>{{$building->user->name}}</small>
            </a>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
