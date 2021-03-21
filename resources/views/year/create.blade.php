<x-app-layout>
<style>
    .year-title{
        font-weight: bolder;
        color:purple;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>اضافة سنة جديد  جديد  </h4>
                </div>
                <div class="card-body">
					<form method="post" action="{{route('year.store')}}">
						@csrf
	                   <div class="row">
                        <div class="col-md-6">
                            <input name="title" class="form-control year-title" value="السنة الدراسية {{date('Y',time())}}">
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-info btn-block">حفظ</button>
                        </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>