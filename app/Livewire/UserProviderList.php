<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Provider;
use App\Models\User;

class UserProviderList extends Component
{
    public $user;
    public $providers;

    public function mount($user)
    {
        $this->user = User::find($user);
        $this->providers = Provider::where('user_id', $user)->get();
    }

    public function delete($id)
    {
        Provider::find($id)->delete();
        $this->providers = Provider::where('user_id', $this->user->id)->get();
        // notification dispatch
        $this->dispatch('showToast', 
        type: 'success', 
        message: 'Provider profile deleted successfully!',
        duration: 5000
    );
    }
    public function render()
    {
        return view('livewire.user-provider-list');
    }
}
