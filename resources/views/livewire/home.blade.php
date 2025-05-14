<div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-4">
    @foreach ($services as $service)
        @php
            $hasCategories = $service->serviceCategory->isNotEmpty();
            $modalName = "service-{$service->id}";
        @endphp

        <div class="text-center">
            @if ($hasCategories)
                <flux:modal.trigger name="{{ $modalName }}">
                    <flux:button variant="primary" class="w-full h-full flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow hover:bg-white transition space-y-2">
                        <div class="w-12 h-12 flex items-center justify-center">
                            @svg($service->icon, 'w-10 h-10 text-gray-800')
                        </div>
                        <span class="text-sm font-medium text-gray-800">{{ $service->name }}</span>
                    </flux:button>
                </flux:modal.trigger>
            @else
                <flux:button
                    href="{{ route('providers', ['service_slug' => $service->slug]) }}"
                    class="w-full h-full flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow hover:bg-gray-100 transition space-y-2"
                >
                    <div class="w-12 h-12 flex items-center justify-center">
                        @svg($service->icon, 'w-10 h-10 text-gray-800')
                    </div>
                    <span class="text-sm font-medium text-gray-800">{{ $service->name }}</span>
                </flux:button>
            @endif

            <!-- Modal for categories -->
            @if ($hasCategories)
                <flux:modal name="service-{{ $service->id }}" class="md:w-[28rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Categories for {{ $service->name }}</flux:heading>
                            <flux:text class="mt-1 text-sm text-gray-500">Choose one to view providers</flux:text>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($service->serviceCategory as $category)
                                <a href="{{ route('providers', ['service_slug' => $service->slug, 'category_slug' => $category->slug]) }}"
   class="flex flex-col items-center justify-center text-center p-4 bg-white rounded-xl shadow hover:bg-gray-100 transition space-y-2">
    @svg($category->icon, 'w-10 h-10 text-gray-800')
    <div class="text-sm font-semibold">{{ $category->name }}</div>
</a>

                            @endforeach
                        </div>
                    </div>
                </flux:modal>
            @endif
        </div>
    @endforeach
</div>
