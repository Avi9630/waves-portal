<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 1;
 
    public function increment()
    {
        $this->count++;
        // dump('Increment');
    }
    
    public function decrement()
    {
        $this->count--;
        // dump('Decrement');
    }
 
    public function render()
    {
        return view('livewire.counter');
    }
}
