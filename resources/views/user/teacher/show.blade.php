
<div class="container">
    <div class="row">
    	<div class="col-md-12">
    		<div class="text-primary">
    			<h4>المدرس: {{$loggedUser->name}} - <small>{{$usercenter->name}}</small></h4>
    		</div>
    	</div>
    	
        @if($circle)
    	@include('user.teacher._has_circle')
        @endif

    </div>
</div>
