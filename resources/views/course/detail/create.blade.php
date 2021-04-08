<x-app-layout>
<div class="container justify-content-center">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="post" action="{{route('course.detail.store')}}">
            @csrf
            <table class="table">
                <tr>
                    <td colspan="2">
                        {{$course->title}}
                    </td>
                </tr>
                <tr>
                    <td>الايقونة</td>
                    <td>
                        <input type="hidden" name="icon" value="" checked>
                        <span class="material-icons">book</span>
                        <input type="radio" name="icon" value="book">
                        <span class="material-icons">assignment_turned_in</span>
                        <input type="radio" name="icon" value="assignment_turned_in" >
                        <span class="material-icons">article</span>
                        <input type="radio" name="icon" value="article" >
                        <span class="material-icons">assignment_return</span>
                        <input type="radio" name="icon" value="assignment_return" >
                        <span class="material-icons">list</span>
                        <input type="radio" name="icon" value="list" >
                        <span class="material-icons">question_answer</span>
                        <input type="radio" name="icon" value="question_answer" >
                        <span class="material-icons">sticky_note_2</span>
                        <input type="radio" name="icon" value="sticky_note_2" >
                        <span class="material-icons">table_view</span>
                        <input type="radio" name="icon" value="table_view" >
                        <span class="material-icons">library_books</span>
                        <input type="radio" name="icon" value="library_books" >
                        <span class="material-icons">chat</span>
                        <input type="radio" name="icon" value="chat" >
                        <span class="material-icons">list_alt</span>
                        <input type="radio" name="icon" value="list_alt" >
                        <span class="material-icons">content_paste</span>
                        <input type="radio" name="icon" value="content_paste" >
                        <span class="material-icons">topic</span>
                        <input type="radio" name="icon" value="topic" >
                    </td>
                </tr>
                <tr>
                    <td>العنوان </td>
                    <td><input name="title" class="form-control"></td>
                </tr>
                <tr>
                    <td>هل العنوان رئيسي</td>
                    <td>
                        <span>نعم</span>
                        <input type="radio" name="ishead" value="1">
                        <span>لا</span>
                        <input type="radio" name="ishead" value="0">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="course_id" value="{{$course->id}}">
                        <button class="btn btn-info btn-block">حفظ</button>
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
            <tr>
                <td>العنوان</td>
                <td>إدارة</td>
            </tr>
            @foreach($course->details as $detail)
            <tr>
                <td>
                    @if($detail->ishead==1)
                    <h3>
                        <span class="material-icons">{{$detail->icon}}</span>
                        {{$detail->title}}
                    </h3>
                    @else
                        {{$detail->title}}
                    @endif
                </td>
                <td>
                    <a href="">تعديل</a>
                </td>
            </tr>
            @endforeach
        </table>
        </div>
    </div>
</div>

</x-app-layout>
