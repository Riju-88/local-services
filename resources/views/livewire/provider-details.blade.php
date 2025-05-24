<div class="max-w-6xl mx-auto px-4 py-8 space-y-10">

    {{-- Header --}}
    <div class="bg-white shadow-lg rounded-xl p-6 md:flex md:justify-between md:items-center md:space-x-6">
        <div class="flex-1 space-y-3">
            <h1 class="text-3xl font-extrabold text-gray-900">{{ $provider->business_name }}</h1>

            <div class="flex flex-wrap items-center gap-4 text-gray-600 text-sm">
                <div class="flex items-center gap-1 font-semibold text-green-600">
                    {{-- For average_rating, consider calculating it in your Provider model or ProviderDetails component --}}
                    <span>{{ number_format($provider->average_rating ?? 0, 1) }}★</span>
                    {{-- For reviews_count, ensure you're loading it efficiently, e.g., with $provider->loadCount('reviews') in your ProviderDetails component --}}
                    <span class="text-gray-500">({{ number_format($provider->reviews_count ?? 0) }} Ratings)</span>
                </div>

                <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-semibold select-none">Claimed</span>

                <span class="truncate max-w-xs" title="{{ $provider->address }}">{{ $provider->address }}</span>

                <span class="whitespace-nowrap text-gray-500">• {{ $provider->years_in_business ?? 16 }} Years in Business</span>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-6 md:mt-0 flex flex-wrap gap-3 justify-start md:justify-end">
            <button class="bg-green-600 hover:bg-green-700 transition text-white px-5 py-2 rounded-lg shadow-md font-semibold focus:outline-none focus:ring-2 focus:ring-green-500">Show Number</button>
            <button class="bg-blue-600 hover:bg-blue-700 transition text-white px-5 py-2 rounded-lg shadow-md font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500">Enquire Now</button>
            <button class="bg-green-500 hover:bg-green-600 transition text-white px-5 py-2 rounded-lg shadow-md font-semibold focus:outline-none focus:ring-2 focus:ring-green-400">WhatsApp</button>
        </div>
    </div>

    {{-- Photos --}}
    @if (!empty($provider->photos))
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Photos</h2>
            <div class="flex space-x-4 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                @foreach ($provider->photos as $photo)
                    <img
                        src="{{ asset('storage/' . $photo) }}"
                        alt="Photo of {{ $provider->business_name }}"
                        class="h-44 w-auto rounded-lg object-cover flex-shrink-0 shadow-sm hover:scale-105 transition-transform duration-200"
                        loading="lazy"
                    >
                @endforeach
            </div>
        </div>
    @endif

    {{-- Quick Info --}}
    <div class="bg-white shadow-lg rounded-xl p-6 space-y-5">
        <h2 class="text-xl font-semibold text-gray-800">Quick Information</h2>

        <div>
            <strong class="block mb-1 text-gray-700">Business Summary:</strong>
            <p class="text-gray-700 leading-relaxed">{{ $provider->description }}</p>
        </div>

        <div class="text-gray-600 flex flex-col sm:flex-row sm:space-x-6 space-y-1 sm:space-y-0">
            <span><strong>Year Established:</strong> {{ $provider->year_established ?? 'N/A' }}</span>
            <span><strong>Phone:</strong> {{ $provider->phone }}</span>
            @if ($provider->user)
                <span><strong>Contact Person:</strong> {{ $provider->user->name }}</span>
            @endif
        </div>
    </div>

    {{-- Map --}}
    @if ($provider->latitude && $provider->longitude)
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <iframe
                width="100%"
                height="280"
                frameborder="0"
                style="border:0"
                loading="lazy"
                src="https://www.google.com/maps?q={{ $provider->latitude }},{{ $provider->longitude }}&hl=es;z=14&output=embed"
                allowfullscreen
                aria-label="Map showing location of {{ $provider->business_name }}"
            ></iframe>
        </div>
    @endif

    {{-- Reviews Section --}}
    <div class="bg-white shadow-lg rounded-xl p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Reviews & Ratings</h2>

        {{-- Check if provider object is available before rendering the Livewire component --}}
        @if ($provider)
            {{-- Include the Reviews Livewire component --}}
            {{-- Make sure your Livewire component is named 'Reviews' --}}
            {{-- (e.g., app/Livewire/Reviews.php and resources/views/livewire/reviews.blade.php) --}}
           <livewire:Reviews :providerId="$provider->id" />
        @else
            <p class="text-gray-500">Loading review information...</p> {{-- Or some other loading state --}}
        @endif
    </div>
</div>