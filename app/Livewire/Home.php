<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\Provider;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    public $services;
    public $serviceCategories = [];
    public $selectedService = null;
    public $slides;
    public $showVerificationSuccess = false;
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

      // Handle email verification status (new addition)
        if (Auth::check() && request()->has('verified')) {
            $user = Auth::user();
            
            // Only process if not already verified
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
                event(new \Illuminate\Auth\Events\Verified($user));
            }
            
            $this->showVerificationSuccess = true;
        }
    }

  
    public function dismissVerificationMessage()
    {
        $this->showVerificationSuccess = false;
    }

    public function render()
    {
        return view('livewire.home');
    }
}
