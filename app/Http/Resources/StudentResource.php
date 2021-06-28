<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MemorizedJuzResource;
use App\Http\Resources\MemorizedSowarResource;
use App\Http\Resources\ProgramReportResource;
use App\Models\ProgramReport;
use Carbon\Carbon;
class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
             
        $programReports = ProgramReport::where(['student_id'=>$this->id])
        // ->whereDate('created_at',Carbon::now()->format('Y-m-d'))
        ->limit(50)->get();
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'avatar'=>$this->avatar,
            'memorizedJuzs'=>MemorizedJuzResource::collection($this->memorizedJuzs),
            'memorizedSowars'=>MemorizedSowarResource::collection($this->memorizedSowars),
            'programReports'=>new ProgramReportResource($programReports),
            
        ];
    }
}
