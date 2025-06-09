<div class="container mx-auto px-4 py-8">
    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-100">{{ $pageTitle }}</h1>

        {{-- Breadcrumbs --}}
        @if ($service)
            <nav class="text-sm text-gray-500 mt-1">
                <ol class="list-reset flex space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:underline text-gray-600">Home</a></li>
                    @if ($serviceCategory)
                        <li>/</li>
                        <li>
                            <a href="{{ route('providers', ['service_slug' => $service->slug]) }}"
                               class="hover:underline text-gray-600">
                                {{ $service->name }}
                            </a>
                        </li>
                        <li>/</li>
                        <li class="text-gray-800">{{ $serviceCategory->name }}</li>
                    @else
                        <li>/</li>
                        <li class="text-gray-800">{{ $service->name }}</li>
                    @endif
                </ol>
            </nav>
        @endif
    </div>

    {{-- Error Handling --}}
    @if (!$service)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong class="font-bold">Service Not Found:</strong>
            <span class="block mt-1">The service "{{ $currentServiceSlug }}" does not exist.</span>
        </div>
    @elseif ($currentCategorySlug && !$serviceCategory)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong class="font-bold">Category Not Found:</strong>
            <span class="block mt-1">Category "{{ $currentCategorySlug }}" does not exist in "{{ $service->name }}".</span>
        </div>
    @elseif ($providers->isEmpty())
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded mb-4">
            <strong class="font-bold">No Providers Available</strong>
            <span class="block mt-1">There are currently no active providers for this selection.</span>
            <a href="{{ route('home') }}"
               class="inline-block mt-2 text-blue-600 hover:underline text-sm">← Go back to all services</a>
        </div>
    @endif

    {{-- Providers Grid --}}
    @if ($providers->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($providers as $provider)
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
</div>
