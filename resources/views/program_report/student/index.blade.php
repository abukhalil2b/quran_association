<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
			@foreach($todaymeeting_program_reports as $program_report)
			<div class="mt-3">[ {{$program_report->donedate}} ]</div>
            <div class="card mt-1">
                <div class="card-body text-xs">
                    <div>{!!nl2br($program_report->mission)!!}</div>
                    <div class="text-red-800">{!!nl2br($program_report->note)!!}</div>
                </div>
                <div class="text-left">
                    <a class="text-red-400 mx-2" href="{{route('program_report.delete',['programReport'=>$program_report->id])}}">
                    حذف
                    </a>
                    <a class="text-yellow-600 mx-2" href="{{route('program_report.edit',['programReport'=>$program_report->id])}}">
                    تعديل
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
