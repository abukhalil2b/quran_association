<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{route('update_teacher_owner',['teacher'=>$teacher->id])}}" method="post">
            	@csrf 
            	<input type="number" name="owner" value="{{$teacher->owner}}" class="form-control">
            	<button class="mt-4 btn btn-success btn-block" type="submit">حفظ</button>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
