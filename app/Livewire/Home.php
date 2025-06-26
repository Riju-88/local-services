<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\Provider;

class Home extends Component
{
    public $services;
     public $serviceCategories = [];
    public $selectedService = null;
    public $slides;
    public function mount()
    {
         $this->services = Service::with('serviceCategory', 'providers')->get();
         $this->slides = Provider::featured()
         ->get()
         ->map(function ($slide) {
            return [
            'image' => asset('uploads/' . $slide->banner),
            'title' => $slide->business_name,
            'desc' => $slide->description,
            ];
         })
         ->reverse()
         ->values()
         ->toArray(); // reversed here

    // dd($this->slides);
    }

  

    public function render()
    {
        return view('livewire.home');
    }
}
