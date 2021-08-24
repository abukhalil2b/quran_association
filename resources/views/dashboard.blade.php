<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('pages.Dashboard') }}
        </h2>
    </x-slot>

    @if(auth()->user()->userType=='superadmin')
    @include('user.superadmin.show')
    @endif

    @if(auth()->user()->userType=='usercenter')
    @include('user.usercenter.show')
    @endif

    @if(auth()->user()->userType=='supervisor')
    @include('user.supervisor.show')
    @endif

    @if(auth()->user()->userType=='teacher')
    @include('user.teacher.show')
    @endif
<br>
</x-app-layout>
