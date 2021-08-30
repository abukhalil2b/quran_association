<div class="col-lg-12  mt-1">
	<div class="card p-2">
        <div>
            <small class="text-primary">البرنامج:  
            </small>{{$quarterlyProgramCircle->program->title}} 
             - 
			<small class="text-primary">الحلقة: </small>{{$quarterlyProgramCircle->title}}
            <div>
                <small class="text-info">{{__('timestart')}}: {{$quarterlyProgramCircle->timestart}}</small>    
                <small class=" mr-3 text-info">{{__('duration')}}: {{$quarterlyProgramCircle->duration}}</small>
            </div>
            
        </div>
        <div>
            <small class="text-primary">المشرف على الحلقة: </small>{{$quarterlyProgramCircle->supervisor->accountOwner->name}}
        </div>
        <div>
			<small class="text-primary">الفصل: </small>{{$quarterlyProgramCircle->program->semester->title}} -
			<small class="text-primary">السنة الدراسية: </small>{{$quarterlyProgramCircle->program->semester->year->title}}
        </div>
	</div>
</div>