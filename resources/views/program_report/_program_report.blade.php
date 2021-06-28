
<div class="container">
	<h5 class="mt-3"> التقارير المرسلة</h5>
    <div class="row justify-content-center">
        <div class="col-md-12">
			@foreach($programReports as $programReport)
			
            <div class="card mt-1">
                <div class="card-body text-xs">
                	@if(auth()->user()->userType!=='teacher'){{$programReport->student->name}}@endif
                    <div>[ {{$programReport->donedate}} ] <span class="text-gray-400">ماتم انجازه في هذا اللقاء:</span></div>
                    <div>
                        {!!nl2br($programReport->todaymission)!!}
                    </div>
                    <hr>
                    <div class="text-red-400">ملحوظات</div>
                    <div class="text-red-800">{!!nl2br($programReport->note)!!}</div>
                    <hr>
                    <div>[ {{$programReport->tobedonedate}} ] <span class="text-gray-400">اللقاء القادم:</span></div>
                    <div>{!!nl2br($programReport->nextmission)!!}</div>
                </div>
                <div class="text-left">
                    <span class="text-blue-300 text-xs">تم إنشاء التقرير {{$programReport->created_at->format('Y-m-d')}}</span>
                    <a class="text-red-400 mx-2" href="{{route('program_report.delete',['programReport'=>$programReport->id])}}">
                    حذف
                    </a>
                    <a class="text-yellow-600 mx-2" href="{{route('program_report.edit',['programReport'=>$programReport->id])}}">
                    تعديل
                    </a>
                </div>
            </div>
            @endforeach
            <div class="alert alert-secondary mt-3">
                {{$programReports->links()}}
            </div>
        </div>
    </div>
</div>

