<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        اضافة حساب {{__('teacher')}}  لـ {{__('supervisor')}} 
                        <span class="pull-left">
                            <a href="{{route('user.teacher.new.create')}}">
                                + مستخدم جديد
                            </a>
                        </span>
                    </h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('user.teacher.store')}}">
                    @csrf
                    <table class="table">
                        <tr>
                            <td>إختر {{__('supervisor')}}</td>
                            <td>
                                <select name="user_id" class="form-control mt-1">
                                    @foreach($supervisors as $supervisor)
                                    <option value="{{$supervisor->accountOwner->id}}">
                                        {{$supervisor->accountOwner->name}} (@foreach($supervisor->accountOwner->accounts() as $account) {{__($account)}}. @endforeach)
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>تعريف قصير</td>
                            <td>
                                <input name="title" class="form-control mt-1" placeholder="تعريف قصير" value="حساب مدرس">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button class="btn btn-info btn-block">حفظ</button>
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
