<div x-data="{ showForm: @entangle('showForm') }" class="relative">

  <button 
      @click="showForm = !showForm" 
      class="mb-4 px-5 py-2 text-sm font-medium bg-blue-100 text-blue-800 rounded-xl hover:bg-blue-200 transition"
  >
    <span x-text="showForm 
      ? 'Hide Review Form' 
      : '{{ $editingReviewId ? 'Edit Your Review' : 'Leave a Review' }}'"></span>
  </button>

  <div
    x-show="showForm"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 max-h-0"
    x-transition:enter-end="opacity-100 max-h-[1000px]"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 max-h-[1000px]"
    x-transition:leave-end="opacity-0 max-h-0"
    style="overflow: hidden;"
  >
    {{-- Review Form --}}
    <h2 class="text-2xl font-bold text-blue-700 mb-4 tracking-tight">
      {{ $editingReviewId ? 'Edit Your Review' : 'Leave a Review' }}
    </h2>

    <form wire:submit.prevent="save" class="space-y-4">
      {{-- Rating --}}
      <div>
        <label class="block text-sm font-medium text-gray-700">Rating</label>
        <div class="flex items-center space-x-2 mt-1">
          @for ($i = 1; $i <= 5; $i++)
            <button 
              type="button" 
              wire:click="$set('rating', {{ $i }})" 
              class="text-2xl transition-all {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}"
            >
              ★
            </button>
          @endfor
        </div>
        @error('rating') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
      </div>

      {{-- Title --}}
      <div>
        <label class="block text-sm font-medium text-gray-700">Title</label>
        <input 
          type="text" 
          wire:model.defer="title" 
          placeholder="Amazing service!" 
          class="mt-1 w-full border border-gray-300 rounded-xl shadow-sm focus:ring-pink-500 focus:border-pink-500 transition-all text-gray-700 p-2" 
        />
        @error('title') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
      </div>

      {{-- Comment --}}
      <div>
        <label class="block text-sm font-medium text-gray-700">Comment</label>
        <textarea 
          wire:model.defer="comment" 
          rows="4" 
          placeholder="What did you love or hate?" 
          class="mt-1 w-full border border-gray-300 rounded-xl shadow-sm focus:ring-pink-500 focus:border-pink-500 transition-all text-gray-700"
        ></textarea>
        @error('comment') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
      </div>

      {{-- Upload Photos --}}
      <div>
        <label class="block text-sm font-medium text-gray-700">Upload Photos</label>
        <input 
          type="file" 
          wire:model="photoUploads" 
          multiple 
          class="mt-1 block w-full text-sm text-gray-600 file:border file:rounded file:px-3 file:py-1 file:bg-pink-100 file:text-pink-700 file:border-pink-300 file:cursor-pointer" 
        />
        @error('photoUploads.*') <span class="text-sm text-red-500">{{ $message }}</span> @enderror

        @if ($photoUploads)
          <div class="flex gap-2 mt-2 flex-wrap">
            @foreach ($photoUploads as $photo)
              <img src="{{ $photo->temporaryUrl() }}" class="w-20 h-20 object-cover rounded-xl border" />
            @endforeach
          </div>
        @endif
      </div>

      {{-- Existing Photos (Edit Mode) --}}
      @if ($editingReviewId && !empty($photos))
        <div class="flex gap-2 mt-2">
          @foreach ($photos as $index => $photo)
            <div class="relative group">
              <img src="{{ asset('storage/' . $photo) }}" class="w-20 h-20 object-cover rounded-xl border" />
              <button 
                type="button" 
                wire:click.prevent="removePhoto({{ $index }})" 
                class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                title="Remove photo"
              >
                &times;
              </button>
            </div>
          @endforeach
        </div>
      @endif

      {{-- Submit / Cancel --}}
      <div class="flex justify-end gap-2 mt-4">
        @if($editingReviewId)
          <button 
            type="button" 
            wire:click="resetFields()" 
            class="px-4 py-2 text-sm bg-gray-500 hover:bg-gray-200 rounded-xl transition"
          >
            Cancel
          </button>
        @endif
        <button 
          type="submit" 
          class="px-5 py-2 text-sm font-medium bg-gradient-to-r from-pink-500 to-red-500 text-white rounded-xl hover:opacity-90 transition-all shadow-md"
        >
          {{ $editingReviewId ? 'Update' : 'Submit' }} Review
        </button>
      </div>
    </form>
  </div>

  {{-- Review List --}}
  <div class="mt-8">
    <h3 class="text-lg font-semibold text-blue-800 border-b pb-2 mb-4">What Others Are Saying</h3>

    @forelse($reviews as $review)
      <div class="border border-blue-100 rounded-2xl p-4 mb-4 shadow-sm bg-gradient-to-r from-blue-50 via-white to-pink-50 transition-all hover:shadow-md">
        <div class="flex justify-between items-start mb-2">
          <div class="text-sm text-gray-700">
            <strong class="text-blue-800">{{ $review->user->name }}</strong>
            <span class="ml-2 text-yellow-400 text-lg">{{ str_repeat('★', $review->rating) }}</span>
          </div>
          @if($review->user_id === auth()->id())
            <div class="flex gap-2">
              <button wire:click="edit({{ $review->id }})" class="text-blue-600 text-sm hover:underline font-medium">Edit</button>
              <button wire:click="delete({{ $review->id }})" class="text-red-600 text-sm hover:underline font-medium">Delete</button>
            </div>
          @endif
        </div>
        <p class="text-base font-semibold text-gray-900">{{ $review->title }}</p>
        <p class="text-sm text-gray-700 mt-1">{{ $review->comment }}</p>
        @if ($review->photos)
          <div class="flex gap-2 mt-3 flex-wrap">
            @foreach ($review->photos as $photo)
            <flux:modal.trigger name="review-image-{{ $review->id }}">
              <img src="{{ asset('storage/' . $photo) }}" class="w-20 h-20 object-cover rounded-xl border" />
            </flux:modal.trigger>
            @endforeach
            <flux:modal name="review-image-{{ $review->id }}">
              <img src="{{ asset('storage/' . $photo) }}" class="w-9/10 h-9/10 object-cover rounded-xl border" />
            </flux:modal>
          </div>
        @endif
      </div>
    @empty
      <p class="text-sm text-gray-500 italic">No reviews yet. Be the first to share your experience ✨</p>
    @endforelse
  </div>
</div>
