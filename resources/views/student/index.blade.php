<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        @if($gender=='male')
        @include('student._male_index')
        @endif
        @if($gender=='female')
        @include('student._female_index')
        @endif
    </div>
</div>
</x-app-layout>
