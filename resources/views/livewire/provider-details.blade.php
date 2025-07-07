 <div class="container mx-auto px-4 py-8">
    <!-- Business Header -->
    <div class="card bg-base-100 shadow-xl mb-8">
      <div class="card-body p-6">
        <div class="flex flex-col md:flex-row gap-6 items-center md:items-start">
          <!-- Logo -->
          <div class="avatar">
            <div class="w-24 h-24 md:w-32 md:h-32 rounded-xl">
            @if ($provider->logo)
              <img src="{{ asset('uploads/' . $provider->logo) }}" alt="Business Logo" />
              @else
              <img src="https://picsum.photos/id/237/200/200" alt="Business Logo" />
              @endif
            </div>
          </div>
          
          <!-- Business Name and Status -->
          <div class="flex-1">
            <div class="flex flex-wrap items-center gap-2">
              <h1 class="text-2xl md:text-3xl font-bold">{{ $provider->business_name }}</h1>
              
              <!-- Status Badges -->
              @if ($provider->is_verified)
              <div class="badge badge-success gap-1" title="Verified Business">
                @svg('heroicon-c-check-badge', ['class' => 'w-8 h-8 text-blue-500'])
                 
              </div>
              @endif
            </div>
            
            <!-- Tags -->
            <div class="flex flex-wrap gap-2 my-2">
              @forelse ($provider->tags ?? [] as $tag)
              <span class="badge border rounded-full px-2 bg-gray-800 dark:bg-gray-200 text-gray-100 dark:text-gray-900">{{ $tag }}</span>
              @empty
              <span class="badge badge-outline">No Tags</span>
              <span class="badge badge-outline">No Tags</span>
              @endforelse
            </div>
            
            {{-- Rating --}}
            <div class="flex items-center gap-2">
              
              <span class="text-sm px-2 rounded-md bg-blue-700  text-gray-200">{{ $provider->reviews->avg('rating') }}</span>
            </div>
             
            <!-- Established Year -->
            <p class="text-sm text-base-content/70">
             <i>Since</i> 
             <i>{{ $provider->established_year }}</i> 
               
            </p>
            
            <!-- Quick Contact Buttons -->
            <div class="flex flex-wrap gap-2 mt-4">
              <a href="tel:{{ $provider->phone }}" class="btn btn-sm btn-outline">
                <i class="fas fa-phone mr-1"></i> Call
              </a>
              <a href="https://wa.me/{{ $provider->whatsapp ?? $provider->phone }}" class="btn btn-sm btn-outline btn-success">
                <i class="fab fa-whatsapp mr-1"></i> WhatsApp
              </a>
              <a href="mailto:{{ $provider->email }}" class="btn btn-sm btn-outline">
                <i class="fas fa-envelope mr-1"></i> Email
              </a>
              <a href="{{ $provider->website ?? '#' }}" target="_blank" class="btn btn-sm btn-outline">
                <i class="fas fa-globe mr-1"></i> Website
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Left Column (2/3 width on large screens) -->
      <div class="lg:col-span-2">
        <!-- Overview Section -->
        <section id="overview" class="card bg-base-100 shadow-xl mb-8">
          <div class="card-body">
            <h2 class="card-title text-xl mb-4">
              <i class="fas fa-info-circle mr-2"></i> Overview
            </h2>
            <p class="text-base-content/80 mb-6 mx-2">
              {{ $provider->description }}
            </p>
            
            <!-- Working Hours -->
            <div class="mb-4">
              <h3 class="font-semibold text-lg mb-2">
                <i class="fas fa-clock mr-2"></i> Working Hours
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mx-2">
                <div class="flex justify-between mb-4">
                 
                  {{-- check if open today using carbon --}}
                 @if( in_array(\Carbon\Carbon::now()->format('l'), $provider->working_hours['days']) )
    <p class="text-green-500 font-bold">Open Today</p>
@else
    <p class="text-red-500 font-bold">Closed Today</p>
@endif
                  <span class="font-semibold">
    {{ \Carbon\Carbon::createFromFormat('H:i', $provider->working_hours['from'])->format('g:i A') }}
    -
    {{ \Carbon\Carbon::createFromFormat('H:i', $provider->working_hours['to'])->format('g:i A') }}
</span>
               
                </div>
              
              </div>
            </div>
          </div>
        </section>

        {{-- Photos --}}
        <section id="gallery" class="card bg-base-100 shadow-xl mb-8">
          
    @if (!empty($provider->photos))
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Photos</h2>
            <div class="flex space-x-4 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                @foreach ($provider->photos as $photo)
                 <flux:modal.trigger name="provider-image-{{ $provider->id }}">
                      <img
                        src="{{ asset('uploads/' . $photo) }}"
                        alt="Photo of {{ $provider->business_name }}"
                        class="h-44 w-auto rounded-lg object-cover flex-shrink-0 shadow-sm hover:scale-105 transition-transform duration-200 p-2"
                        loading="lazy"
                    >
                </flux:modal.trigger>
               
                @endforeach
             <flux:modal name="provider-image-{{ $provider->id }}">
                    <img
                        src="{{ asset('uploads/' . $photo) }}"
                        alt="Photo of {{ $provider->business_name }}"
                        class="h-9/10 w-auto rounded-lg object-cover flex-shrink-0 shadow-sm hover:scale-105 transition-transform duration-200"
                        loading="lazy"
                    >
                </flux:modal>
                </div>
        </div>
    @endif
        </section>

         {{-- Reviews Section --}}
    <div class="bg-white shadow-lg rounded-xl p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Reviews & Ratings</h2>

        {{-- Check if provider object is available before rendering the Livewire component --}}
        @if ($provider)

            {{-- Include the Reviews Livewire component --}}
           <livewire:Reviews :providerId="$provider->id" />
        @else
            <p class="text-gray-500">Loading review information...</p> {{-- Or some other loading state --}}
        @endif
    </div>
      </div>

      <!-- Right Column (1/3 width on large screens) -->
      <div class="lg:col-span-1">
        <!-- Contact Information -->
        <section id="contact" class="card bg-base-100 shadow-xl mb-8">
          <div class="card-body mx-2">
            <h2 class="card-title text-xl mb-4">
              <i class="fas fa-address-card mr-2"></i> Contact Information
            </h2>
            
            <!-- Business Contact -->
            <div class="mb-6">
              <h3 class="font-semibold mb-2">Business Contact</h3>
              <ul class="space-y-2">
                <li class="flex items-start">
                  <i class="fas fa-phone-alt mt-1 mr-2 w-5 text-center"></i>
                  <div>
                    <p>{{ $provider->phone }}</p>
                    <p class="text-sm text-base-content/70">Primary</p>
                  </div>
                </li>
                {{-- <li class="flex items-start">
                  <i class="fas fa-phone-alt mt-1 mr-2 w-5 text-center"></i>
                  <div>
                    <p>+1 (234) 567-8901</p>
                    <p class="text-sm text-base-content/70">Alternative</p>
                  </div>
                </li> --}}
                <li class="flex items-start">
                  <i class="fab fa-whatsapp mt-1 mr-2 w-5 text-center text-green-500"></i>
                  <div>
                    <p>{{ $provider->whatsapp }}</p>
                    <p class="text-sm text-base-content/70">WhatsApp</p>
                  </div>
                </li>
                <li class="flex items-start">
                  <i class="fas fa-envelope mt-1 mr-2 w-5 text-center"></i>
                  <div>
                    <p>{{ $provider->email }}</p>
                  </div>
                </li>
                <li class="flex items-start">
                  <i class="fas fa-globe mt-1 mr-2 w-5 text-center"></i>
                  <div>
                  @if ($provider->website)
                    <a href="{{ $provider->website }}" target="_blank" class="link link-hover" wire:navigate>{{ $provider->website }}</a>
                  @endif
                  </div>
                </li>
              </ul>
            </div>
            
            <!-- Contact Person -->
            <div class="mb-6 mx-2">
              <h3 class="font-semibold mb-2">Contact Person</h3>
              <div class="flex items-center gap-3 mb-3">
                <div class="avatar">
                  <div class="w-12 h-12 rounded-full">
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=John" alt="Contact Person" />
                  </div>
                </div>
                <div>
                  <p class="font-medium">{{ $provider->contact_person_name }}</p>
                  <p class="text-sm text-base-content/70">{{ $provider->contact_person_role }}</p>
                </div>
              </div>
              <ul class="space-y-2">
                <li class="flex items-start">
                 @svg('heroicon-m-device-phone-mobile', 'w-5 text-center')
                  <div>
                    <p>{{ $provider->contact_person_phone }}</p>
                  </div>
                </li>
                <li class="flex items-start">
                  @svg('heroicon-s-phone', 'w-5 text-center text-green-500 mr-2')
                  
                  <div>
                    <p>{{ $provider->contact_person_whatsapp }}</p>
                  </div>
                </li>
                <li class="flex items-start">
                  <i class="fas fa-envelope mt-1 mr-2 w-5 text-center"></i>
                  <div>
                    <p>{{ $provider->contact_person_email }}</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </section>
        
        <!-- Location Information -->
        <section id="location" class="card bg-base-100 shadow-xl mb-8">
          <div class="card-body">
            <h2 class="card-title text-xl mb-4 mx-2">
              <i class="fas fa-map-marker-alt mr-2"></i> Location
            </h2>
            
            <div class="mb-4">
              <div class="mb-4 rounded-lg overflow-hidden">
                <img src="https://picsum.photos/id/1015/600/300" alt="Map" class="w-full h-48 object-cover" />
              </div>
              
              <address class="not-italic mx-3">
                {{ $provider->address }}
              </address>
              
              <div class="mt-2 mx-3">
                <span class="badge">{{ $provider->area }}</span>
                <span class="badge">{{ $provider->pincode }}</span>
              </div>
              
              <a href="https://maps.google.com" target="_blank" class="btn btn-outline btn-sm mt-4 w-full">
                <i class="fas fa-directions mx-2"></i> Get Directions
              </a>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>