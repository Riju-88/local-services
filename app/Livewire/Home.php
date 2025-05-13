<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;

class Home extends Component
{
    public $services;
     public $serviceCategories = [];
    public $selectedService = null;

    public function mount()
    {
         $this->services = Service::with('serviceCategory')->get();
    }

    

    public function render()
    {
        return view('livewire.home');
    }
}
