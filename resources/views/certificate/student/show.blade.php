<x-app-layout>
	<style>
		.show-certificat-img {
    		width: 800px;
		}
	</style>
<div class="container">
    <div class="row">
        <div class="col-lg-12 mt-2">
        	<div class="round-box ">
                {{$course->title}}
                <hr>
                <center>
                	<img src="{{asset('storage/'.$course->pivot->certificate_url)}}" class="show-certificat-img">
                </center>
        	</div>
        </div>
    </div>
</div>

</x-app-layout>