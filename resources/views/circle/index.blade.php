<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>{{__('name')}}</td>
                    <td>{{__('admin')}}</td>
                </tr>
                @foreach($circles as $circle)
                <tr>
                    <td >
                        <span class="name">
                            {{$circle->title}}
                        </span>
                         <div>
                            <small class="text-info">{{__('teacher')}}: {{$circle->teacher->accountOwner->name}}</small>    
                            <small class="text-info mr-3">{{__('supervisor')}}: {{$circle->supervisor->accountOwner->name}}</small>  
                            <div>
                               <small class="text-info" style="font-size: 10px">
                                    {{__('program')}}: {{$circle->program->title}} - 
                                    {{$circle->program->quarterly==1? :' '}}
                                    @if($circle->program->quarterly==1)
                                    {{$circle->program->semester->title}} - 
                                    {{$circle->program->semester->year->title}}
                                    @else
                                    {{__('incessant_program')}}
                                    @endif
                                </small> 
                            </div>  
                                
                        </div>
                         <div>
                            <small class="text-info">{{__('timestart')}}: {{$circle->timestart}}</small>    
                            <small class=" mr-3 text-info">{{__('duration')}}: {{$circle->duration}}</small>
                        </div>
                    </td>
                    <td>
                        <a class="btn"  href="{{route('circle.edit',['circle'=>$circle->id])}}">{{__('edit')}}</a>
                        <a class="btn" href="{{route('confirm_circle_delete',['circle'=>$circle->id])}}">{{__('delete')}}</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
<script>
	
</script>
</x-app-layout>
