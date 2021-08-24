<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('pages.Dashboard') }}
        </h2>
    </x-slot>
    
<div class="container">
    <div class="row">
    	<div class="col-md-12">
    		<div class="text-primary">
    			<h4>المدرس: {{$loggedUser->name}} - <small>{{$usercenter->name}}</small></h4>
    		</div>
    	</div>
    </div>

    <div class="row mt-3 border bg-white rounded py-1">
        <h4 class="py-2 px-3">برامج فصلية</h4>
        @if($quarterlyProgramCircle)
        @include('user.teacher.quarterly_program._circle')
        @include('user.teacher.quarterly_program._dailyrecord')
        @include('user.teacher.quarterly_program._students')
        @endif
    </div>
</div>
</x-app-layout>