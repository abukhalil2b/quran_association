<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>السور التي يحفظها الطالب</h4>
                </div>
                <div class="card-body">
					<form method="post" action="{{route('student.memorized_sowar.store')}}">
						@csrf
	                    <table class="table">
							<tr>
	                    		<td>السور</td>
	                    		<td>
		                          <select name="sowar_id" class="form-control" >
		                          	@foreach($sowars as $sowar)
		                          	<option value="{{$sowar->id}}">{{$sowar->title}}</option>
		                          	@endforeach
		                          </select>
	                            </td>
	                    	</tr>
	                        <tr>
	                            <td colspan="2">
	                            	<input type="hidden" name="student_id" value="{{$student->id}}">
	                                <button class="btn btn-info btn-block">اضاف</button>
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
