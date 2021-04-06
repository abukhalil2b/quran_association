<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'donedate'=>$this->donedate,
            'tobedonedate'=>$this->tobedonedate,
            'mission'=>$this->mission,
            'evaluation'=>$this->evaluation,
            'note'=>$this->note,
            'fathernote'=>$this->fathernote,
        ];
    }
}
