<div>
{{-- session flash --}}
@if (session()->has('success'))
    <div class="p-4 mb-6 rounded-lg bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
        {{ session('success') }}
    </div>
@endif

 <div class="container mx-auto max-w-3xl">
   
    <h1 class="text-2xl font-bold mb-6">Businesses of {{ auth()->user()->name }}</h1>
    
    <div class="space-y-4">
     {{-- list all providers from user --}}
    @foreach ($providers as $provider)
      <!-- Business Item 5 -->
      <div class="card bg-base-100 shadow-xl">
        <div class="card-body p-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
              <!-- Logo -->
              @if ($provider->logo)
              <div class="avatar">
                <div class="w-16 h-16 rounded-full">
                  <img src="{{ asset('uploads/' . $provider->logo) }}" alt="Business Logo" />
                </div>
              </div>
              @else
              <div class="avatar">
                <div class="w-16 h-16 rounded-full">
                  <img src="https://picsum.photos/id/106/200/200" alt="Business Logo" />
                </div>
              </div>
              @endif
              <div>
                <h2 class="text-xl font-semibold"><a  href="{{ route('provider-details', $provider) }}" class="hover:underline pointer"> {{ $provider->business_name }}
                </a></h2>
                <p class="text-sm opacity-70"> {{ $provider->address }}</p>
              </div>
            </div>
            <flux:dropdown>
                <flux:button icon="ellipsis-vertical" variant="ghost" inset class=" text-gray-700 dark:text-white">
                    
                </flux:button>
                <flux:menu>
                    <flux:menu.item icon="pencil" href="{{ route('edit-provider', $provider) }}">Edit</flux:menu.item>
                    <flux:menu.separator />
                     <flux:modal.trigger name="confirm-delete-{{ $provider->id }}">
          <flux:menu.item variant="danger" icon="trash">Delete</flux:menu.item>
        </flux:modal.trigger>
                </flux:menu>
            </flux:dropdown>
          </div>
          {{--  --}}
           <flux:modal name="confirm-delete-{{ $provider->id }}" class="min-w-[22rem] space-y-6" @teleport="body">
    <flux:heading size="lg">Delete {{ $provider->business_name }}?</flux:heading>
    <flux:text>You’re about to delete this provider. This action cannot be undone.</flux:text>

    <div class="flex gap-2 justify-end">
      <flux:spacer />
      <flux:modal.close>
        <flux:button variant="ghost">Cancel</flux:button>
      </flux:modal.close>
      <flux:button type="button" variant="danger" wire:click="delete({{ $provider->id }})">
        Delete
      </flux:button>
    </div>
  </flux:modal>
          {{--  --}}
        </div>
      </div>
      @endforeach
    </div>
  </div>
  
</div>
