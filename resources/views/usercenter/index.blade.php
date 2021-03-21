<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        	@foreach($usercenters as $usercenter)
        	<div class="alert alert-info mt-5">
        		<h2>{{$usercenter->name}}</h2>
        		@foreach($usercenter->programs as $program)
        		<small><div>{{$program->title}}</div></small>
        		@endforeach
        	</div>
        	@endforeach
        </div>
    </div>
</div>
</x-app-layout>
