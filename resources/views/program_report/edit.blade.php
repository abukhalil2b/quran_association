<x-app-layout>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="py-4">
			    <div class="card">
			        <div class="card-body">
				        <form method="post" action="{{route('program_report.update',['programReport'=>$programReport->id,'student'=>$programReport->student->id])}}">
				            @csrf
				            <div class="form-group">
				                ما تم انجازه اليوم: اكتب اسم السورة أو الآيات أو الصفحات أو الأجزاء أو المتون أو الدروس
				                <textarea name="todaymission" class="form-control" style="height:80px;">{{$programReport->todaymission}}</textarea>
				            </div>
				            <div class="form-group">
				                 ملحوظات (إن وجد)
				               <textarea class="form-control" name="note" style="height:80px;">{{$programReport->note}}</textarea>
				            </div>

				            <div class="form-group">
				                التقييم
				                <input class="form-control" name="evaluation" value="{{$programReport->evaluation}}">
				            </div>
				            <div class="form-group">
				                ما سوف يتم انجازه في اللقاء القادم: اكتب اسم السورة أو الآيات أو الصفحات أو الأجزاء أو المتون أو الدروس
				                <textarea name="nextmission" class="form-control" style="height:80px;">{{$programReport->nextmission}}</textarea>
				            </div>
				            
				            <div class="form-group">
				               
				                <button class="btn btn-info btn-block">تعديل</button>
				            </div>
				        </form>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>
</x-app-layout>