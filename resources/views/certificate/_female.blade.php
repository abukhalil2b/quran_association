@if($course->female_certificate_url)
<img src="{{asset('storage/'.$course->female_certificate_url)}}" width="200">
<a href="{{route('certificate.destroy',['course'=>$course->id,'gender'=>'female'])}}" class="pull-left"> {{__('delete')}}</a>
@else
<div class="form-group">
    صورة الشهادة ({{__('female')}})
    <input name="female_certificate_url" type="file" class="form-control">
</div>
@endif