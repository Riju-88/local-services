<div class="relative z-50 w-64">
    <input
        type="text"
        wire:model="query"
        wire:keyup.debounce.300ms="searchQuery"
        placeholder="Search..."
        class="w-full px-3 py-2 border rounded-md dark:bg-zinc-900 dark:text-white dark:border-zinc-600"
    />

    @if (count($results['providers']) > 0 || count($results['serviceCategories']) > 0)
        <div class="absolute w-full mt-1 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-600 rounded-md shadow-lg max-h-64 overflow-auto">

            {{-- Providers --}}
            @foreach ($results['providers'] as $provider)
                <a href="{{ route('provider-details', ['provider' => $provider]) }}"
                   class="block px-4 py-2 text-sm text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-zinc-700">
                    🏢 {{ $provider->business_name }}
                </a>
            @endforeach

            {{-- Service Categories --}}
            @foreach ($results['serviceCategories'] as $category)
                @if ($category->service)
                    <a href="{{ route('providers', ['service_slug' => $category->service->slug, 'category_slug' => $category->slug]) }}"
                       class="block px-4 py-2 text-sm text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-zinc-700">
                        📁 {{ $category->name }}
                    </a>
                @endif
            @endforeach

        </div>
    @endif
</div>
