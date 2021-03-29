<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{$circle->title}}
                </div>
                <div class="card-body">
					<form method="post" action="{{route('circle.update',['circle'=>$circle->id])}}">
						@csrf
                        <div class="form-group">
                            <input name="title" class="form-control" placeholder="اسم البرنامج">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info btn-block">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
</x-app-layout>
