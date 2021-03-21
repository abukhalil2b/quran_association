<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MemorizeProgram extends Component
{

	public $step = 0;
    public $meeting='';
    public $track='';
    public $memorize='';
    public $numberofwrong='';
    public $evaluation='';
    public $note='';
   

    public function render()
    {
        return view('livewire.memorize-program');
    }

    public function start()
    {
        $this->step=1;
    }

	public function refresh()
    {
         $this->step = 0;
         $this->reset(['meeting','track']);
    }

    public function setTrack($track)
    {

        $this->track=$track;
        $this->step=2;
    }

    public function setMeeting($meeting)
    {

        $this->meeting=$meeting;
        $this->step=3;
    }

    public function setMemorize($memorize)
    {
        $this->memorize=$memorize;
        $this->step=3;
    }

    

}
