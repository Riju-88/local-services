<div>
{{-- session flash --}}
@if (session()->has('success'))
    <div class="p-4 mb-6 rounded-lg bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
        {{ session('success') }}
    </div>
@endif
    {{-- list all providers from user --}}
    @foreach ($providers as $provider)
      {{-- provider cards --}}
      <div class="flex flex-row items-center justify-center max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-6">
      <div class="flex flex-col items-center pb-10">
       {{ $provider->business_name }}
      </div>
      <flux:button wire:click="delete( {{$provider->id}} )" variant="danger" class="w-full">Delete
      </flux:button>
      </div>
    @endforeach
</div>
