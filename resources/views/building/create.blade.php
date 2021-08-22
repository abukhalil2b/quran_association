<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>اضافة مكان للتعليم  (جديد)  </h4>
                </div>
                <div class="card-body">
					<form method="post" action="{{route('building.store')}}">
						@csrf
                        <div class="form-group">
                            <input name="title" class="form-control" placeholder="اسم المكان">
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