<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <li class="text-danger">{{$error}}</li>
                @endforeach
             @endif
        </div>
    </div>
</div>
</x-app-layout>
