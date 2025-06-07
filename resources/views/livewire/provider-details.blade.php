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
              <div class="badge badge-success gap-1" title="Verified Business">
                <i class="fas fa-check-circle"></i> Verified
              </div>
              <div class="badge badge-primary gap-1" title="Featured Business">
                <i class="fas fa-star"></i> Featured
              </div>
              <div class="badge badge-success gap-1" title="Active Business">
                <i class="fas fa-circle"></i> Active
              </div>
            </div>
            
            <!-- Tags -->
            <div class="flex flex-wrap gap-2 my-2">
              @forelse ($provider->tags ?? [] as $tag)
              <span class="badge badge-outline">{{ $tag }}</span>
              @empty
              <span class="badge badge-outline">No Tags</span>
              <span class="badge badge-outline">No Tags</span>
              @endforelse
            </div>
            
            <!-- Established Year -->
            <p class="text-sm text-base-content/70">
             <i>Since</i> 
             <i>{{ $provider->established_year }}</i> 
               
            </p>
            
            <!-- Quick Contact Buttons -->
            <div class="flex flex-wrap gap-2 mt-4">
              <a href="tel:+1234567890" class="btn btn-sm btn-outline">
                <i class="fas fa-phone mr-1"></i> Call
              </a>
              <a href="https://wa.me/1234567890" class="btn btn-sm btn-outline btn-success">
                <i class="fab fa-whatsapp mr-1"></i> WhatsApp
              </a>
              <a href="mailto:info@acmecorp.com" class="btn btn-sm btn-outline">
                <i class="fas fa-envelope mr-1"></i> Email
              </a>
              <a href="https://acmecorp.com" target="_blank" class="btn btn-sm btn-outline">
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
              <i class="fas fa-info-circle mr-2"></i> Business Overview
            </h2>
            <p class="text-base-content/80 mb-6">
              Acme Corporation is a leading provider of innovative solutions for businesses of all sizes. 
              With over 35 years of experience, we specialize in developing cutting-edge software, 
              providing expert consulting services, and delivering exceptional customer support. 
              Our team of dedicated professionals is committed to helping our clients achieve their goals 
              through technology-driven solutions that enhance productivity, streamline operations, 
              and drive growth. At Acme, we believe in building lasting relationships with our clients 
              based on trust, integrity, and mutual success.
            </p>
            
            <!-- Working Hours -->
            <div class="mb-4">
              <h3 class="font-semibold text-lg mb-2">
                <i class="fas fa-clock mr-2"></i> Working Hours
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <div class="flex justify-between">
                  <span>Monday - Friday:</span>
                  <span>9:00 AM - 6:00 PM</span>
                </div>
                <div class="flex justify-between">
                  <span>Saturday:</span>
                  <span>10:00 AM - 4:00 PM</span>
                </div>
                <div class="flex justify-between">
                  <span>Sunday:</span>
                  <span>Closed</span>
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
      </div>

      <!-- Right Column (1/3 width on large screens) -->
      <div class="lg:col-span-1">
        <!-- Contact Information -->
        <section id="contact" class="card bg-base-100 shadow-xl mb-8">
          <div class="card-body">
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
                    <p>+1 (234) 567-8900</p>
                    <p class="text-sm text-base-content/70">Primary</p>
                  </div>
                </li>
                <li class="flex items-start">
                  <i class="fas fa-phone-alt mt-1 mr-2 w-5 text-center"></i>
                  <div>
                    <p>+1 (234) 567-8901</p>
                    <p class="text-sm text-base-content/70">Alternative</p>
                  </div>
                </li>
                <li class="flex items-start">
                  <i class="fab fa-whatsapp mt-1 mr-2 w-5 text-center text-green-500"></i>
                  <div>
                    <p>+1 (234) 567-8902</p>
                    <p class="text-sm text-base-content/70">WhatsApp</p>
                  </div>
                </li>
                <li class="flex items-start">
                  <i class="fas fa-envelope mt-1 mr-2 w-5 text-center"></i>
                  <div>
                    <p>info@acmecorp.com</p>
                  </div>
                </li>
                <li class="flex items-start">
                  <i class="fas fa-globe mt-1 mr-2 w-5 text-center"></i>
                  <div>
                    <a href="https://acmecorp.com" class="link link-hover">acmecorp.com</a>
                  </div>
                </li>
              </ul>
            </div>
            
            <!-- Contact Person -->
            <div class="mb-6">
              <h3 class="font-semibold mb-2">Contact Person</h3>
              <div class="flex items-center gap-3 mb-3">
                <div class="avatar">
                  <div class="w-12 h-12 rounded-full">
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=John" alt="Contact Person" />
                  </div>
                </div>
                <div>
                  <p class="font-medium">John Smith</p>
                  <p class="text-sm text-base-content/70">Marketing Director</p>
                </div>
              </div>
              <ul class="space-y-2">
                <li class="flex items-start">
                  <i class="fas fa-phone-alt mt-1 mr-2 w-5 text-center"></i>
                  <div>
                    <p>+1 (234) 567-8910</p>
                  </div>
                </li>
                <li class="flex items-start">
                  <i class="fab fa-whatsapp mt-1 mr-2 w-5 text-center text-green-500"></i>
                  <div>
                    <p>+1 (234) 567-8911</p>
                  </div>
                </li>
                <li class="flex items-start">
                  <i class="fas fa-envelope mt-1 mr-2 w-5 text-center"></i>
                  <div>
                    <p>john.smith@acmecorp.com</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </section>
        
        <!-- Location Information -->
        <section id="location" class="card bg-base-100 shadow-xl mb-8">
          <div class="card-body">
            <h2 class="card-title text-xl mb-4">
              <i class="fas fa-map-marker-alt mr-2"></i> Location
            </h2>
            
            <div class="mb-4">
              <div class="mb-4 rounded-lg overflow-hidden">
                <img src="https://picsum.photos/id/1015/600/300" alt="Map" class="w-full h-48 object-cover" />
              </div>
              
              <address class="not-italic">
                {{ $provider->address }}
              </address>
              
              <div class="mt-2">
                <span class="badge">{{ $provider->area }}</span>
                <span class="badge">{{ $provider->pincode }}</span>
              </div>
              
              <a href="https://maps.google.com" target="_blank" class="btn btn-outline btn-sm mt-4 w-full">
                <i class="fas fa-directions mr-1"></i> Get Directions
              </a>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>