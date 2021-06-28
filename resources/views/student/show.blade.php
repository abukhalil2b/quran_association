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

@include('program_report._program_report')
@include('student._memorized_juz')
@include('student._memorized_sowar')


</x-app-layout>
