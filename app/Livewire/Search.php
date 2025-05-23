<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ServiceCategory;
use App\Models\Provider;


class Search extends Component
{
    public $query = '';
    public $results = [
        'providers' => [],
        'serviceCategories' => [],
    ];

    public function searchQuery()
    {
        if (strlen($this->query) > 2) {
            $this->results['providers'] = Provider::where('business_name', 'like', '%' . $this->query . '%')->get();
            $this->results['serviceCategories'] = ServiceCategory::where('name', 'like', '%' . $this->query . '%')->get();
        } else {
            $this->results['providers'] = collect();
            $this->results['serviceCategories'] = collect();
        }
    }
    public function render()
    {
        return view('livewire.search');
    }
}
