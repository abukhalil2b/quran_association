<div class="col-lg-12 mt-1">
	<div class="card p-2">
        <div>
            <small class="text-primary">البرنامج:  
            </small>{{$incessantProgramCircle->program->title}} 
             - 
			<small class="text-primary">الحلقة: </small>{{$incessantProgramCircle->title}}
        </div>
        <div>
            <small class="text-primary">المشرف على الحلقة: </small>{{$incessantProgramCircle->supervisor->accountOwner->name}}
        </div>
	</div>
</div>