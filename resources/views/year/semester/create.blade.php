<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>اضافة فصل جديد لـ {{$year->title}}</h4>
                </div>
                <div class="card-body">

					<form method="post" action="{{route('semester.store')}}">
                        @csrf
                        <input type="hidden" name="year_id" value="{{$year->id}}">

                        العنوان
	                    <input name="title" class="form-control" value="الفصل الدراسي">
	                    <button class="btn btn-info btn-block mt-3">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>