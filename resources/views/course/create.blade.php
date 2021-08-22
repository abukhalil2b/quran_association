<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
					<form method="post" action="{{route('course.store')}}">
						@csrf
                    <table class="table">
						<tr>
                    		<td>عنوان الدورة</td>
                    		<td><input name="title" class="form-control"></td>
                    	</tr>
                        <tr>
                            <td>صورة</td>
                            <td><input name="imgurl" class="form-control"></td>
                        </tr>
                    	<tr>
                    		<td>وصف قصير</td>
                    		<td><input name="shortDescription" class="form-control"></td>
                    	</tr>
                    	<tr>
                    		<td>وصف مفصل</td>
                    		<td>
								<textarea style="margin-top: 0px; margin-bottom: 0px; height: 100px;" name="longDescription" class="form-control"></textarea>
							</td>
                    	</tr>
                    	<tr>
                    		<td>تبدأ بتاريخ</td>
                    		<td><input type="date" name="startAt" class="form-control"></td>
                    	</tr>
                        <tr>
                            <td>الوقت</td>
                            <td><input type="time" name="startTime" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>المدة الزمنية</td>
                            <td><input type="number" name="duration" class="form-control"></td>
                        </tr>
						<tr>
                    		<td>تنتهي بتاريخ</td>
                    		<td><input type="date" name="endAt" class="form-control"></td>
                    	</tr>
                        <tr>
                            <td>اختر الأيام التي تلقى فيها الدورة</td>
                            <td>
                                <label>
                                    <input type="checkbox" class="form-control" name="weekDays[]" value="Sun">
                                    الأحد
                                </label>
                                <label>
                                    <input type="checkbox" class="form-control" name="weekDays[]" value="Mon">الأثنين
                                </label>
                                <label>
                                    <input type="checkbox" class="form-control" name="weekDays[]" value="Tue">الثلاثاء
                                </label>
                                <label>
                                    <input type="checkbox" class="form-control" name="weekDays[]" value="Wed">الأربعاء
                                </label>
                                <label>
                                    <input type="checkbox" class="form-control" name="weekDays[]" value="Thu">الخميس
                                </label>
                                <label>
                                    <input type="checkbox" class="form-control" name="weekDays[]" value="Fri">الجمعة
                                </label>
                                <label>
                                    <input type="checkbox" class="form-control" name="weekDays[]" value="Sat">
                                    السبت
                                </label>
                            </td>
                        </tr>

						<tr>
                    		<td>يبدأ التسجيل بتاريخ</td>
                    		<td><input type="date" name="registerStartAt" class="form-control"></td>
                    	</tr>
						<tr>
                    		<td>ينتهي التسجيل بتاريخ</td>
                    		<td><input type="date" name="registerEndAt" class="form-control"></td>
                    	</tr>



                    	<tr>
                    		<td>العدد المطلوب</td>
                    		<td><input type="number" name="requireNumber" class="form-control"></td>
                    	</tr>

						<tr>
                    		<td>هل مجانية</td>
                    		<td>
								<select name="free" class="form-control">
                                    <option value="0">لا</option>
                                    <option value="1">نعم</option>
								</select>
							</td>
                    	</tr>
						<tr>
                    		<td>السعر</td>
                    		<td><input type="number" step="0.1" name="price" class="form-control"></td>
                    	</tr>
						<tr>
                    		<td>المستوى</td>
                    		<td>
								<select name="level" class="form-control">
                                    <option value=""></option>
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
                                <select name="building_id" class="form-control" id="js-building-section" >
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
									<option value="{{$teacher->id}}">{{$teacher->accountOwner->name}}</option>
									@endforeach
								</select>
							</td>
                    	</tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="cate_id" value="1">
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
