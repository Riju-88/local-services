<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Provider;

class ProviderDetails extends Component
{
     public $provider;

    public function mount(Provider $provider)
    {
        $this->provider = $provider->load('user', 'reviews');
    }

  

    public function render()
    {
        return view('livewire.provider-details');
    }
}
