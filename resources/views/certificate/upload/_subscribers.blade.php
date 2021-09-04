<div class="card-body">
@foreach($subscribers as $subscriber)

   <small>({{$subscriber->id}}) {{$subscriber->name}}</small>  

@endforeach
</div>