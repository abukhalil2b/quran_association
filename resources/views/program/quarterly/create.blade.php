<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>اضافة برنامج جديد فصلي</h4>
                    {{$building->title}} ||
                    {{$semester->title}} ||
                    {{$semester->year->title}}
                </div>
                <div class="card-body">
					<form method="post" action="{{route('program.quarterly.store')}}">
						@csrf
                        <div class="form-group">
                            <input name="title" class="form-control" placeholder="اسم البرنامج">
                        </div>
                        <div class="form-group">
                        	<input type="hidden" name="building_id" value="{{$building->id}}">
                        	<input type="hidden" name="semester_id" value="{{$semester->id}}">
                             <button class="btn btn-info btn-block">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
</x-app-layout>
