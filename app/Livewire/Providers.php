<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class Providers extends Component
{
    public string $currentServiceSlug;
    public ?string $currentCategorySlug = null;
    public ?Service $service = null;
    public ?ServiceCategory $serviceCategory = null;
    public Collection $providers;
    public string $pageTitle;

    public function mount(string $service_slug, ?string $category_slug = null): void
    {
        $this->currentServiceSlug = $service_slug;
        $this->currentCategorySlug = $category_slug;
        $this->providers = new Collection();

        $this->service = Service::where('slug', $service_slug)->first();

        if (!$this->service) {
            $this->pageTitle = "Service '{$service_slug}' Not Found";
            return;
        }

        $providerSource = $this->service;
        $this->pageTitle = "Providers for '{$this->service->name}'";

        if ($category_slug) {
            $this->serviceCategory = $this->service
                ->serviceCategory()
                ->where('slug', $category_slug)
                ->first();

            if (!$this->serviceCategory) {
                $this->pageTitle = "Category '{$category_slug}' Not Found in '{$this->service->name}'";
                return;
            }

            $providerSource = $this->serviceCategory;
            $this->pageTitle = "Providers for '{$this->serviceCategory->name}' in '{$this->service->name}'";
        }

        $this->providers = $providerSource->providers()
            ->with(['user:id,name'])
            ->where('is_active', true)
            ->get();
    }

    public function render()
    {
        return view('livewire.providers');
    }
}
