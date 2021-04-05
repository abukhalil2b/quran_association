
<div class="container">
    <div class="row">

    	<div class="col-md-12">
    		<h4>{{$loggedUser->name}}</h4>
			<small>{{$supervisor->title}}</small>
			<div><small>{{$usercenter->name}}</small></div>
    	</div>

    	<hr>
		@include('user.supervisor._program')
		@include('user.supervisor._quraterly_program')

    </div>
</div>

