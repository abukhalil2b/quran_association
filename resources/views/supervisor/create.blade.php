<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                         اضافة حساب {{__('supervisor')}}  لـ {{__('teacher')}} 
                        <span class="pull-left">
                            <a href="{{route('user.supervisor.new.create')}}">
                                + مستخدم جديد
                            </a>
                        </span>
                    </h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('user.supervisor.store')}}">
                    @csrf
                    <table class="table">
                        <tr>
                            <td>إختر {{__('teacher')}} </td>
                            <td>
                                <select name="user_id" class="form-control mt-1">
                                    @foreach($teachers as $teacher)
                                    <option value="{{$teacher->accountOwner->id}}">
                                        {{$teacher->accountOwner->name}} (@foreach($teacher->accountOwner->accounts() as $account) {{__($account)}}. @endforeach)
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>تعريف قصير</td>
                            <td>
                                <input name="title" class="form-control mt-1" placeholder="تعريف قصير" value="حساب مشرف">
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
