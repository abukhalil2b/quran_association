<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <form action="{{route('juz.update',['juz'=>$juz->id])}}" method="post">
            @csrf
            <input class="form-control" name="title" value="{{$juz->title}}">
            <button class="btn btn-outline-secondary btn-block mt-5">تعديل</button>
        </form>
        </div>
    </div>
</div>
</x-app-layout>