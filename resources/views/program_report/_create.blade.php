    <div class="card-body">
        <form method="post" action="{{route('program_report.store')}}">
            @csrf

            <div class="form-group" id="js-toggle-div">
                تاريخ لقاء اليوم
                <input type="date" class="form-control" name="donedate" value="{{date('Y-m-d')}}">
            </div>

            
            <div class="form-group">
                ما تم انجازه اليوم: اكتب اسم السورة أو الآيات أو الصفحات أو الأجزاء أو المتون أو الدروس
                <textarea name="todaymission" class="form-control" style="height:80px;"></textarea>
            </div>
            
            <div class="form-group">
                التقييم
                <input class="form-control" name="evaluation">
            </div>
            <div class="form-group">
                 ملحوظات (إن وجد)
               <textarea class="form-control" name="note" style="height:80px;"></textarea>
            </div>

            <hr>
            <div class="form-group" id="js-toggle-div">
                تاريخ اللقاء القادم
                <input type="date" class="form-control" name="tobedonedate">
            </div>
            <div class="form-group">
                ما سوف يتم انجازه في اللقاء القادم: اكتب اسم السورة أو الآيات أو الصفحات أو الأجزاء أو المتون أو الدروس
                <textarea name="nextmission" class="form-control" style="height:80px;"></textarea>
            </div>
            <div class="form-group">
                <input type="hidden" name="circle_id" value="{{$circle->id}}">
                <input type="hidden" name="teacher_id" value="{{$circle->teacher->id}}">
                <input type="hidden" name="student_id" value="{{$student->id}}">
                <button class="btn btn-info btn-block">ارسال</button>
            </div>
        </form>
    </div>
