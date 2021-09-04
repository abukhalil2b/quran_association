<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(count($subscribers))
            <h4>اضافة الشهادات  ({{__('females')}})</h4>
            <small>
                  <center>الشهادات يجب أن تكون متوفر للطلبة التالية أسماؤهم ({{count($subscribers)}})</center> 
            </small>
            @endif

            @include('certificate.upload._subscribers')
            <div class="card">
                <div class="card-header">
                    <h5>{{$course->title}}</h5>
                </div>
                <form method="post" action="{{route('certificate.upload_female_certificate_store',['course'=>$course->id])}}" enctype="multipart/form-data">
                @csrf

                @if(count($subscribers))
                <div class="card-body">
					<div class="form-group">
						صورة الشهادات 
					    <input name="images[]" type="file" class="form-control" multiple accept="image/jpg, image/jpeg" id="image">
					</div>
                </div>
                <div class="card-body">
                    <button id="btn" class="btn btn-info btn-block">حفظ</button>
                    <div id="msg" class="text-danger"></div>
                </div>
                
                </form>
                
                @include('certificate.upload._note')
                <hr>
                @endif
                
                <center>{{__('certificates')}} ({{count($certificates)}})</center> 
                @include('certificate.upload._certificates')
            </div>
        </div>
    </div>
</div>


<script>
    var image = document.querySelector('#image');
    var btn = document.querySelector('#btn');
    var msg = document.querySelector('#msg');
    image.addEventListener('change',()=>{
        if(image.files.length>21){
            btn.style.display='none';
            msg.innerHTML = 'الحد الأقصى لعدد الملفات المسموح به هو 20.';
        }else{
            btn.style.display='block';
            msg.innerHTML = '';
        }
    })
</script>

</x-app-layout>