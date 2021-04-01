<x-app-layout>
<div class="container">
    <div class="row">
        @if(auth()->user()->userType=='teacher')
            @include('student._circle')
        @endif
        @if(auth()->user()->userType=='usercenter')
            @include('student._circles')
        @endif
    </div>
</div>

@include('student._memorized_juz')
@include('student._memorized_sowar')
@include('student._program_report')

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="mt-3"> 
                <a class="text-blue-700" href="{{route('program_report.index',['student'=>$student->id])}}">التقارير السابقة</a>
            </h5>
        </div>
    </div>
</div>

<script>
    var jsMeeting = document.getElementById('js-meeting');
    var jsToggleDiv = document.getElementById('js-toggle-div');
     jsToggleDiv.style.display='none';
    jsMeeting.addEventListener('change',()=>{
        if(jsMeeting.value==='nextmeeting')
           jsToggleDiv.style.display='block';
        else
            jsToggleDiv.style.display='none';
    });
</script>
</x-app-layout>
