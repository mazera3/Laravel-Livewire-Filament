<?php

namespace App\Livewire\Tutorial;

use Livewire\Component;

class Todo extends Component
{
    public $todos = ['edio', 'nadir'];

    public $todo = '';

    public function add()
    {
        $this->todos[] = $this->todo;

        $this->todo = '';
    }

    public function render()
    {
        return view('livewire.tutorial.todo');
    }
}
