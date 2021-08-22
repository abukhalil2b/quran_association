@if($course->male_certificate_url)
<img src="{{asset('storage/'.$course->male_certificate_url)}}" alt="">
<a href="{{route('certificate.destroy',['course'=>$course->id,'gender'=>'male'])}}" class="pull-left"> {{__('delete')}}</a>
@else
<div class="form-group">
	صورة الشهادة ({{__('male')}})
    <input name="male_certificate_url" type="file" class="form-control">
</div>
@endif