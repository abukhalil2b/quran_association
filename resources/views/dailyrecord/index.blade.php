<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
             @if(session('status'))
		        <center class="alert alert-info">
		            <b>{{session('status')}}</b>
		        </center>
		    @endif
            <div class="card">
                <div class="card-body">
                	@foreach($dailyrecords as $dailyrecord)
                    <span class="text-gray-500">{{$dailyrecord->title}}</span>
                    <span class="text-gray-800">{{$dailyrecord->circle->title}}</span>
                    <span class="text-blue-800">{{$dailyrecord->circle->program->title}}</span>
                    <span class="text-gray-300 pull-left">{{$dailyrecord->created_at->diffForHumans()}}</span>
                    <hr>
                	@endforeach
                </div>
            </div>
        </div>

    </div>
</div>
</x-app-layout>
