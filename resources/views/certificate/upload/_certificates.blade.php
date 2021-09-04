@foreach($certificates as $certificate)
<div class="card-body">
   @if($certificate->url)   
   <a href="{{$certificate->url}}" target="_blank" >
      <img src="{{$certificate->url}}" width="60">
   </a>
   @endif
   <small>({{$certificate->student->id}}) {{$certificate->student->name}}</small>  
</div>
@endforeach
