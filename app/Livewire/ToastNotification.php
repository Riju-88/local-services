<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ToastNotification extends Component
{
     public $show = false;
    public $message = '';
    public $type = 'success'; // success, error, warning, info
    public $duration = 5000; // milliseconds

  
    #[On('showToast')]
    public function showNotification($type, $message, $duration = null)
    {
        $this->type = $type;
        $this->message = $message;
        $this->duration = $duration ?? $this->duration;
        $this->show = true;
    }

    public function closeNotification()
    {
        $this->show = false;
    }
    public function render()
    {
        return view('livewire.toast-notification');
    }
}
