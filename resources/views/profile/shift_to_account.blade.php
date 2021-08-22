<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        التبديل بين الحسابات
    </x-slot>

    <x-slot name="description">
        الحسابات تحصل عليها من الإدارة
    </x-slot>

    <x-slot name="form">

        @foreach(auth()->user()->accounts() as $account)
        @if(auth()->user()->userType==$account)
        <span class="btn btn-success">{{__($account)}}</span>
        @else
        <a href="{{Route('user.shift_to_account',['account'=>$account])}}" class="btn btn-secondary">{{__($account)}}</a>
        @endif
        @endforeach
    </x-slot>
</x-jet-form-section>
