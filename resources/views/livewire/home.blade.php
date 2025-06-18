<div>
{{-- carousel  --}}
<div 
    x-data="carousel()" 
    x-init="init()" 
    class="max-w-3xl mx-auto mt-8 relative touch-pan-y touch-auto select-none" 
    @touchstart.passive="startTouch($event)" 
    @touchend.passive="endTouch($event)"
>
    <!-- Slides -->
    <div class="relative h-64 overflow-hidden rounded-xl shadow-lg">
        {{-- @foreach ($slides as $index => $slide) --}}
        <template x-for="(slide, i) in slides" :key="i">
            <div 
                x-show="current === i" 
                x-transition:enter="transition-opacity duration-700 ease-in-out"
                x-transition:leave="transition-opacity duration-700 ease-in-out"
                class="absolute inset-0"
                :style="`z-index: ${current === i ? 1 : 0}; opacity: ${current === i ? 1 : 0}`"
            >
                <img :src="slide.image" class="w-full h-full object-cover rounded-xl" />
                <div class="absolute bottom-0 left-0 right-0 bg-black/40 backdrop-blur-sm text-white p-4 rounded-b-xl">
                    <h3 class="text-lg font-semibold" x-text="slide.title"></h3>
                    <p class="text-sm" x-text="slide.desc"></p>
                </div>
            </div>
        </template>
        {{-- @endforeach --}}
    </div>

    <!-- Controls -->
    <button @click="prev()" class="absolute left-2 top-1/2 -translate-y-1/2 text-white bg-black/40 hover:bg-black/60 p-2 rounded-full z-10">
        &#8592;
    </button>
    <button @click="next()" class="absolute right-2 top-1/2 -translate-y-1/2 text-white bg-black/40 hover:bg-black/60 p-2 rounded-full z-10">
        &#8594;
    </button>

    <!-- Indicators -->
            <div class="flex justify-center gap-2 mt-4">
                <template x-for="(slide, i) in slides" :key="i">
                    <button 
                        @click="goTo(i)" 
                        :class="current === i 
                            ? 'bg-gray-900 dark:bg-white' 
                            : 'bg-gray-400 dark:bg-white/30'" 
                        class="w-2.5 h-2.5 rounded-full transition-colors duration-300">
                    </button>
        </template>
    </div>
</div>
{{-- end carousel --}}

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 p-5">
    @foreach ($services as $service)
        @php
            $hasCategories = $service->serviceCategory->isNotEmpty();
            $hasProviders = $service->providers->isNotEmpty();
            $modalName = "service-{$service->id}";
        @endphp

        <div class="flex flex-col items-center text-center group">
            <!-- Trigger Modal if has categories OR show direct link -->
            @if ($hasCategories || $hasProviders)
                <flux:modal.trigger name="{{ $modalName }}">
                    <div class="w-full h-full cursor-pointer transform transition-all duration-300 hover:shadow-lg rounded-md bg-white dark:bg-transparent shadow-sm dark:shadow-none p-4 flex flex-col items-center justify-center space-y-2">
                        <div class="w-16 h-16 flex items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-inner">
                            @svg($service->icon, 'w-8 h-8')
                        </div>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $service->name }}</span>
                    </div>
                </flux:modal.trigger>
            @else
                <a href="{{ route('providers', ['service_slug' => $service->slug]) }}"
                   class="w-full h-full cursor-pointer transform transition-all duration-300 hover:shadow-lg rounded-md bg-white shadow-sm p-4 flex flex-col items-center justify-center space-y-2">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-indigo-100 text-white shadow-inner">
                        @svg($service->icon, 'w-8 h-8')
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $service->name }}</span>
                </a>
            @endif

            <!-- Modal: Show categories AND/OR providers -->
            <flux:modal name="service-{{ $service->id }}" class="md:w-[64rem] max-w-6xl mx-auto">

                <div class="space-y-6">
                    <div class="text-center">
                        <flux:heading size="lg" class="font-bold text-gray-900 dark:text-gray-200">Providers for {{ $service->name }}</flux:heading>
                        <flux:text class="mt-1 text-sm text-gray-800 dark:text-gray-300">Browse by category or view direct providers</flux:text>
                    </div>

                    <div class="space-y-6">

                        <!-- Categories Section -->
                        @if ($hasCategories)
                            <div>
                                <flux:subheading size="sm" class="mb-3 text-gray-700 dark:text-gray-300">By Category</flux:subheading>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                    @foreach ($service->serviceCategory as $category)
                                        <a href="{{ route('providers', ['service_slug' => $service->slug, 'category_slug' => $category->slug]) }}"
                                           class="group flex flex-col items-center justify-center p-4 rounded-xl bg-white dark:bg-transparent shadow hover:shadow-lg  transition-all duration-300">
                                            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-indigo-100 group-hover:bg-indigo-200 text-indigo-700 transition-colors">
                                                @svg($category->icon, 'w-6 h-6')
                                            </div>
                                            <span class="mt-3 text-sm font-medium text-gray-700 dark:text-gray-200">{{ $category->name }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Separator -->
                        @if ($hasProviders)
                            <hr class="border-t border-gray-200 dark:border-gray-700 my-4">
                        @endif

                        <!-- Direct Service Providers -->
                       @if ($hasProviders)
     {{-- Providers Grid --}}
    @if ($service->providers->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            @foreach ($service->providers as $provider)
                <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
                    {{-- Image --}}
                    @if (!empty($provider->logo))
                        <img src="{{ asset('uploads/' . $provider->logo) }}"
                             alt="{{ $provider->business_name }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                           <img src="https://picsum.photos/id/106/400/400" alt="{{ $provider->business_name }}" class="w-full h-48 object-cover">
                        </div>
                    @endif

                    {{-- Content --}}
                    <div class="p-5 flex flex-col flex-grow">
                        <a href="{{ route('provider-details', $provider->slug) }}" class="text-gray-800 hover:underline">
                        <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ $provider->business_name }}</h2>
                        </a>

                        @if ($provider->user)
                            <p class="text-sm text-gray-500 mb-1">
                                By <a href="{{ route('user-details', $provider->user) }}" class="font-medium text-blue-600 hover:underline cursor-pointer">{{ $provider->user->name }}</a>
                            </p>
                        @endif

                        <p class="text-sm text-gray-700 flex-grow mb-2">
                            {{ Str::limit($provider->description, 120) }}
                        </p>

                        @if ($provider->phone)
                            <p class="text-xs text-gray-500"><strong>Tel:</strong> {{ $provider->phone }}</p>
                        @endif

                        @if ($provider->address)
                            <p class="text-xs text-gray-500"><strong>Loc:</strong> {{ Str::limit($provider->address, 40) }}</p>
                        @endif

                        <a href="#"
                           class="mt-4 text-center text-sm bg-blue-600 text-white rounded-lg py-2 px-4 hover:bg-blue-700 transition">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endif

                    </div>
                </div>
            </flux:modal>
        </div>
    @endforeach
</div>

{{-- carousel script --}}
<script>
function carousel() {
    return {
        slides: [
            { image: 'https://picsum.photos/id/296/800/400', title: 'Modern Slide 1', desc: 'Sleek card style with smooth transitions.' },
            { image: 'https://picsum.photos/seed/picsum/800/400', title: 'Modern Slide 2', desc: 'Compact, elegant, and mobile-friendly.' },
            { image: 'https://picsum.photos/id/324/800/400', title: 'Modern Slide 3', desc: 'Responsive and minimal carousel card.' },
        ],
        current: 0,
        interval: null,
        init() {
            this.startAutoplay();
        },
        startAutoplay() {
            this.interval = setInterval(() => this.next(), 5000);
        },
        resetAutoplay() {
            clearInterval(this.interval);
            this.startAutoplay();
        },
        next() {
            this.current = (this.current + 1) % this.slides.length;
            this.resetAutoplay();
        },
        prev() {
            this.current = (this.current - 1 + this.slides.length) % this.slides.length;
            this.resetAutoplay();
        },
        goTo(index) {
            this.current = index;
            this.resetAutoplay();
        },
        startX: 0,
        startTouch(e) {
            this.startX = e.touches[0].clientX;
        },
        endTouch(e) {
            const endX = e.changedTouches[0].clientX;
            const diff = endX - this.startX;
            if (diff > 50) this.prev();
            else if (diff < -50) this.next();
        }
    };
}
</script>
</div>