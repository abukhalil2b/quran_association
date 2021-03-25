<div class="col-md-12 mt-3">
    <span class="text-primary">برامج مستمرة</span>
    @foreach($programs as $program)
    <div class="card">
        <div class="card-body">
            <h4>البرنامج: {{$program->title}}</h4>
            @foreach($program->circles as $circle)
                <a href="{{route('circle.dashboard',['circle'=>$circle->id])}}">
                <h5>الحلقة: {{$circle->title}}</h5>
                </a>
            @endforeach
            <div class="divider"></div>
        </div>
    </div>
     @endforeach
</div>