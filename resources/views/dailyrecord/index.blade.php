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
                	<h6>
                    <b>عنوان السجل: </b>{{$dailyrecord->title}}
                    <b> ||الحلقة: </b>{{$dailyrecord->circle->title}}
                    <b> ||البرنامج: </b>{{$dailyrecord->circle->program->title}}</h6>
                	@endforeach
                </div>
            </div>
        </div>

    </div>
</div>
</x-app-layout>
