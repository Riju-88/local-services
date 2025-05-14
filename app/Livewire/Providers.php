<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Provider;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class Providers extends Component
{
    public string $currentServiceSlug;
    public ?string $currentCategorySlug = null;

    public ?Service $service = null;
    public ?ServiceCategory $serviceCategory = null;
    public Collection $providers;
    public string $pageTitle = 'Providers';

    public function mount(string $service_slug, ?string $category_slug = null): void
    {
         Log::info("Service Slug: {$service_slug}, Category Slug: {$category_slug}");
        $this->currentServiceSlug = $service_slug;
        $this->currentCategorySlug = $category_slug;
        $this->providers = new Collection();

        $this->loadData();
    }

    protected function loadData(): void
    {
        Log::info("Loading providers for service: {$this->currentServiceSlug}, category: {$this->currentCategorySlug}");

        $this->service = Service::where('slug', $this->currentServiceSlug)->first();

        if (!$this->service) {
            $this->pageTitle = "Service '{$this->currentServiceSlug}' Not Found";
            Log::warning($this->pageTitle);
            return;
        }

        $this->pageTitle = "Providers for '{$this->service->name}'";

        if ($this->currentCategorySlug) {
            $this->serviceCategory = $this->service->serviceCategory()
                ->where('slug', $this->currentCategorySlug)
                ->first();

            if (!$this->serviceCategory) {
                $this->pageTitle = "Category '{$this->currentCategorySlug}' Not Found in '{$this->service->name}'";
                Log::warning($this->pageTitle);
                return;
            }

            $this->pageTitle = "Providers for '{$this->serviceCategory->name}' in '{$this->service->name}'";

            $this->providers = $this->serviceCategory->providers()
                ->with('user')
                ->where('is_active', true)
                ->get();

            Log::info("Loaded {$this->providers->count()} providers from category '{$this->serviceCategory->name}'");
        } else {
            $this->providers = $this->service->providers()
                ->with('user')
                ->where('is_active', true)
                ->get();

            Log::info("Loaded {$this->providers->count()} providers from service '{$this->service->name}'");
        }

        if ($this->providers->isEmpty()) {
            Log::info("No active providers found.");
        }
    }

    public function render()
    {
        return view('livewire.providers');
    }
}
