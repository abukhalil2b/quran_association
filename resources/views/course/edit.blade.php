<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if($errors->any())
	                    @foreach($errors->all() as $error)
	                    	<li class="text-danger">{{$error}}</li>
	                    @endforeach
                    @endif
                </div>
                <div class="card-body">
                    <h4>دورة جديدة</h4>
					<form method="post" action="{{route('course.update')}}">
						@csrf
                    <table class="table">
						<tr>
                    		<td>عنوان الدورة</td>
                    		<td><input value="{{$course->title}}" name="title" class="form-control"></td>
                    	</tr>
                        <tr>
                            <td>صورة</td>
                            <td><input value="{{$course->imgurl}}" name="imgurl" class="form-control"></td>
                        </tr>
                    	<tr>
                    		<td>وصف قصير</td>
                    		<td><input value="{{$course->shortDescription}}" name="shortDescription" class="form-control"></td>
                    	</tr>
                    	<tr>
                    		<td>وصف مفصل</td>
                    		<td>
								<textarea style="margin-top: 0px; margin-bottom: 0px; height: 100px;" name="longDescription" class="form-control">{{$course->longDescription}}</textarea>
							</td>
                    	</tr>
                    	<tr>
                    		<td>تبدأ بتاريخ</td>
                    		<td><input value="{{$course->startAt}}" type="date" name="startAt" class="form-control"></td>
                    	</tr>
                        <tr>
                            <td>الوقت</td>
                            <td><input value="{{$course->startTime}}" type="time" name="startTime" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>المدة الزمنية</td>
                            <td><input value="{{$course->duration}}" type="number" name="duration" class="form-control"></td>
                        </tr>
						<tr>
                    		<td>تنتهي بتاريخ</td>
                    		<td><input value="{{$course->endAt}}" type="date" name="endAt" class="form-control"></td>
                    	</tr>

                         @if($course->weekDays)
                        <tr>
                            <td>اختر الأيام التي تلقى فيها الدورة</td>
                            <td>
                            	@foreach(config('weeklist') as $key => $name)
                            	<label>
                                	<input type="checkbox"
                                	@foreach($course->weekDays as $weekDay)
                            		@if($key==$weekDay) checked @endif
                            		@endforeach
                                	class="form-control" name="weekDays[]" value="{{$key}}">
                                	{{$name}}
                                </label>
                            	@endforeach
                            </td>
                        </tr>
                        @endif

						<tr>
                    		<td>يبدأ التسجيل بتاريخ</td>
                    		<td><input value="{{$course->registerStartAt}}" type="date" name="registerStartAt" class="form-control"></td>
                    	</tr>
						<tr>
                    		<td>ينتهي التسجيل بتاريخ</td>
                    		<td><input value="{{$course->registerEndAt}}" type="date" name="registerEndAt" class="form-control"></td>
                    	</tr>



                    	<tr>
                    		<td>العدد المطلوب</td>
                    		<td><input value="{{$course->requireNumber}}" type="number" name="requireNumber" class="form-control"></td>
                    	</tr>

						<tr>
                    		<td>هل مجانية</td>
                    		<td>
								<select name="free" class="form-control">
									<option @if($course->free=='1')selected @endif value="1">نعم</option>
									<option @if($course->free=='0')selected @endif value="0">لا</option>
								</select>
							</td>
                    	</tr>
						<tr>
                    		<td>السعر</td>
                    		<td><input value="{{$course->price}}" type="number" step="0.1" name="price" class="form-control"></td>
                    	</tr>
						<tr>
                    		<td>المستوى</td>
                    		<td>
								<select name="level" class="form-control">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>
							</td>
                    	</tr>
						<tr>
                    		<td>وسيلة التقديم</td>
                    		<td>
								<select name="deliveryMeans" class="form-control" id="deliveryMeans">
									<option value="googlemeeting">googlemeeting</option>
									<option value="zoom">zoom</option>
									<option value="whatsapp">whatsapp</option>
                                    <option value="youtube">youtube</option>
									<option value="attend-building">الحضور إلى المركز</option>
								</select>
							</td>
                    	</tr>
                         <tr>
                            <td>المكان</td>
                            <td>
                                <select name="building_id" class="form-control" id="js-building-section">
                                    @foreach($buildings as $building)
                                    <option value="{{$building->id}}">{{$building->title}} {{$building->user->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    	<tr>
                    		<td>التفعيل</td>
                    		<td>
								<select name="active" class="form-control">
									<option value="1">مفعلة</option>
									<option value="0">معطلة</option>
								</select>
							</td>
                    	</tr>
						<tr>
                    		<td>اسم المعلم أو المحاضر</td>
                    		<td>
								<select name="teacher_id" class="form-control">
									@foreach($teachers as $teacher)
									<option @if($teacher->id == $course->teacher_id) selected @endif value="{{$teacher->id}}">
										{{$teacher->accountOwner->name}} - {{$teacher->usercenter()->name}}
									</option>
									@endforeach
								</select>
							</td>
                    	</tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="course_id" value="1">
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
<script>
    var buildingSection = document.getElementById('js-building-section')
    var deliveryMeans = document.getElementById('deliveryMeans')
    deliveryMeans.addEventListener('change',()=>{
        if(deliveryMeans.value==='attend-building'){
            buildingSection.style.display='block'
        }else{
             buildingSection.style.display='none'
        }
    })
    buildingSection.style.display='none'
</script>
</x-app-layout>
