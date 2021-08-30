<x-app-layout>
<div class="container">
    <div class="row">
       @include('student._circle')
    </div>
</div>

@if($programReport)
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h5 class="mt-3">آخر التقارير المرسلة
				<a class="pull-left" href="{{route('student.program_report.index',['student'=>$student->id,'circle'=>$circle->id])}}">
				عرض كل التقارير المرسلة
				</a>
			</h5>
			<div class="card mt-1">
			    <div class="card-body text-xs">
			        <div>[ {{$programReport->donedate}} ] <span class="text-gray-400">ماتم انجازه في هذا اللقاء:</span></div>
			        <div>
			            {!!nl2br($programReport->todaymission)!!}
			        </div>
			        <div>
			            <span class="text-blue-700">التقييم: </span>
			            {{$programReport->evaluation}}
			        </div>
			        <hr>
			        <div class="text-red-400">ملحوظات</div>
			        <div class="text-red-800">{!!nl2br($programReport->note)!!}</div>
			        <hr>
			        <div>[ {{$programReport->tobedonedate}} ] <span class="text-gray-400">اللقاء القادم:</span></div>
			        <div>{!!nl2br($programReport->nextmission)!!}</div>
			    </div>
			    <div class="text-left">
			        <span class="text-blue-300 text-xs mx-2">المدرس {{$programReport->teacher->accountOwner->name}}</span>
			        <span class="text-blue-300 text-xs">تم إنشاء التقرير {{$programReport->created_at->format('Y-m-d')}}</span>
			        <a class="text-red-400 mx-2" href="{{route('program_report.confirm_delete',['programReport'=>$programReport->id,'student'=>$programReport->student->id])}}">
			            حذف
			        </a>
			        <a class="text-yellow-600 mx-2" href="{{route('program_report.edit',['programReport'=>$programReport->id,'student'=>$programReport->student->id])}}">
			        تعديل
			        </a>
			    </div>
			</div>
			
		</div>
	</div>
</div>
@endif

@include('student._memorized_juz')
@include('student._memorized_sowar')


</x-app-layout>
