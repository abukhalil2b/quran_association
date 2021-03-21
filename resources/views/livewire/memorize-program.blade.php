<div>
	
	
    @switch($step)

    @case(1)
	 	<div class="mt-3">
	    	<div class="btn" wire:click="setMeeting('todaymeeting')">لقاء اليوم</div>
	    	<div class="btn" wire:click="setMeeting('nextmeeting')">اللقاء القادم</div>
	    </div>
	    @break
    @case(2)
	 	<div class="mt-3">
	    	<div class="btn" wire:click="setTrack('newtrack')">حفظ جديد</div>
	    	<div class="btn" wire:click="setTrack('reviewtrack')">مراجعة</div>
	    </div>
	    @break

	    @case(3)
	 	<div class="mt-3">
	 		<input class="form-control" placeholder="الحفظ" wire:model="memorize">
	 		<input class="form-control mt-2" placeholder="عدد الأخطاء" wire:model="numberofwrong">
	 		<input class="form-control mt-2" placeholder="التقييم" wire:model="evaluation">
	    	<div class="btn" wire:click="setEvaluation">كتابة ماتم انجازه</div>
	    </div>
	    @case(4)
	 	<div class="mt-3">
	 		<input class="form-control" placeholder="الحفظ" wire:model="memorize">
	 		<input class="form-control mt-2" placeholder="عدد الأخطاء" wire:model="numberofwrong">
	 		<input class="form-control mt-2" placeholder="التقييم" wire:model="evaluation">
	    	<div class="btn" wire:click="setEvaluation">كتابة ما سيتم إنجازه</div>
	    </div>
	    @break
	    @case(5)
	 	<div class="mt-3">
	    	<div class="btn" wire:click="save">حفظ</div>
	    </div>
	    @break
	    @default
	    <div class="mt-3" wire:click="start">ابدأ بكتابة التقرير</div>
    @endswitch

	<div class="mt-5">
		<div class="btn" wire:click="refresh">تراجع</div>
	</div>

   	<div class="alert alert-secondary mt-3">
		[ {{__($meeting)}} ] - [ {{__($track)}} ]
   	</div>
   

</div>
