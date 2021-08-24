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

    <div class="row mt-3 border bg-white rounded py-1">
        <h4 class="py-2 px-3">برامج مستمرة</h4>
        @if($incessantProgramCircle)
        @include('user.teacher.incessant_program._circle')
        @include('user.teacher.incessant_program._dailyrecord')
        @include('user.teacher.incessant_program._students')
        @endif
    </div>

    <div class="row mt-3 border bg-white rounded py-1">
        <h4 class="py-2 px-3">الدورات العلمية</h4>
        @include('user.teacher.course._index')
    </div>

    <div class="row mt-3 border bg-white rounded py-1">
        <h4 class="py-2 px-3">برامج مستمرة اخرى</h4>
        @include('user.teacher.incessant_program._circles')
    </div>

    <div class="row mt-3 border bg-white rounded py-1">
        <h4 class="py-2 px-3">برامج فصلية اخرى</h4>
        @include('user.teacher.quarterly_program._circles')
    </div>
</div>
