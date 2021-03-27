<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        التبديل بين الحسابات
    </x-slot>

    <x-slot name="description">
        الحسابات تحصل عليها من الإدارة
    </x-slot>

    <x-slot name="form">

    </x-slot>

    <x-slot name="actions">
    	@if(auth()->user()->supervisorAccount && auth()->user()->userType==='teacher')
	    	<a href="{{route('user.shiftaccount.tosupervisor')}}" class="btn btn-secondary text-white">
	    	التبديل إلى حساب {{__('supervisor')}}
	    	</a>
    	@endif

    	@if(auth()->user()->teacherAccount && auth()->user()->userType==='supervisor')
	    	<a href="{{route('user.shiftaccount.toteacher')}}" class="btn btn-secondary text-white">
	    	التبديل إلى حساب {{__('teacher')}}
	    	</a>
    	@endif
    </x-slot>
</x-jet-form-section>
