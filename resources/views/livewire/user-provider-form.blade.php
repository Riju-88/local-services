<div class="max-w-4xl mx-auto p-6">
    <form wire:submit.prevent="saveProvider" class="space-y-6">
        @csrf

        <!-- Success/Error Messages -->
        @if (session()->has('success'))
            <div class="p-4 mb-6 rounded-lg bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="p-4 mb-6 rounded-lg bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                {{ session('error') }}
            </div>
        @endif

        <!-- Basic Info Section -->
        <fieldset class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 space-y-4">
            <legend class="px-2 text-lg font-medium text-gray-900 dark:text-gray-100">Basic Info</legend>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Provider Type -->
                <div>
                    <label for="providable_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Link Provider to Type
                    </label>
                    <select id="providable_type" wire:model.live="providable_type" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        <option value="">-- Select Type --</option>
                        <option value="{{ App\Models\Service::class }}">Service</option>
                        <option value="{{ App\Models\ServiceCategory::class }}">Service Category (Sub Category)</option>
                    </select>
                    @error('providable_type') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Provider Item -->
                @if($providable_type)
                <div>
                    <label for="providable_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Select @if($providable_type === App\Models\Service::class) Service @endif
                        @if($providable_type === App\Models\ServiceCategory::class) Sub Category @endif
                    </label>
                    <select id="providable_id" wire:model="providable_id" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        <option value="">-- Select Item --</option>
                        @foreach($providableItems as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('providable_id') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Business Name -->
                <div>
                    <label for="business_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Business Name
                    </label>
                    <input type="text" id="business_name" wire:model.blur="business_name" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('business_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Slug
                    </label>
                    <input type="text" id="slug" wire:model="slug" readonly 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm bg-gray-100 dark:bg-gray-800 dark:text-gray-200 cursor-not-allowed p-2">
                    @error('slug') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Description
                </label>
                <textarea id="description" wire:model.lazy="description" rows="3" 
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200"></textarea>
                @error('description') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Phone
                    </label>
                    <input type="tel" id="phone" wire:model.lazy="phone" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('phone') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Alternate Phone -->
                <div>
                    <label for="alternate_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Alternate Phone
                    </label>
                    <input type="tel" id="alternate_phone" wire:model.lazy="alternate_phone" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('alternate_phone') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- WhatsApp Number -->
                <div>
                    <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        WhatsApp Number
                    </label>
                    <input type="text" id="whatsapp_number" wire:model.lazy="whatsapp_number" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('whatsapp_number') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Email
                    </label>
                    <input type="email" id="email" wire:model.lazy="email" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('email') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Website -->
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Website
                    </label>
                    <input type="url" id="website" wire:model.lazy="website" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('website') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Address
                    </label>
                    <input type="text" id="address" wire:model.lazy="address" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('address') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Area -->
                <div>
                    <label for="area" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Area
                    </label>
                    <input type="text" id="area" wire:model.lazy="area" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('area') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pincode -->
                <div>
                    <label for="pincode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Pincode
                    </label>
                    <input type="text" id="pincode" wire:model.lazy="pincode" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('pincode') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Photos -->
                <div>
                    <label for="photos" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Photos (select multiple)
                    </label>
                    <input type="file" id="photos" wire:model="photos" multiple 
                        class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-200 dark:hover:file:bg-blue-800 p-2">
                    <div wire:loading wire:target="photos" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Uploading...</div>
                    @error('photos.*') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    @if ($photos)
                        <div class="mt-3">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Previews:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($photos as $key => $photo)
                                    @if(method_exists($photo, 'temporaryUrl'))
                                        <img src="{{ $photo->temporaryUrl() }}" class="h-20 w-auto rounded-md border border-gray-200 dark:border-gray-600">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Logo -->
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Logo
                    </label>
                    <input type="file" id="logo" wire:model="logo" 
                        class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-200 dark:hover:file:bg-blue-800">
                    <div wire:loading wire:target="logo" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Uploading...</div>
                    @error('logo') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    @if ($logo && method_exists($logo, 'temporaryUrl'))
                        <div class="mt-3">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview:</p>
                            <img src="{{ $logo->temporaryUrl() }}" class="h-20 w-auto rounded-md border border-gray-200 dark:border-gray-600">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Active Checkbox -->
            <div class="flex items-center">
                <input type="checkbox" id="is_active" wire:model="is_active" value="1" 
                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                    Active (Provider will be visible)
                </label>
            </div>
            @error('is_active') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </fieldset>

        <!-- Contact Person Section -->
        <fieldset class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 space-y-4">
            <legend class="px-2 text-lg font-medium text-gray-900 dark:text-gray-100">Contact Person</legend>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Contact Person Name -->
                <div>
                    <label for="contact_person_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Name
                    </label>
                    <input type="text" id="contact_person_name" wire:model.lazy="contact_person_name" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('contact_person_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Contact Person Role -->
                <div>
                    <label for="contact_person_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Role
                    </label>
                    <input type="text" list="roles" id="contact_person_role" wire:model.lazy="contact_person_role" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    <datalist id="roles">
                        <option value="Manager">
                        <option value="Owner">
                        <option value="Supervisor">
                        <option value="Receptionist">
                        <option value="Representative">
                    </datalist>
                    @error('contact_person_role') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Contact Person Phone -->
                <div>
                    <label for="contact_person_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Phone
                    </label>
                    <input type="tel" id="contact_person_phone" wire:model.lazy="contact_person_phone" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('contact_person_phone') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Contact Person Email -->
                <div>
                    <label for="contact_person_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Email
                    </label>
                    <input type="email" id="contact_person_email" wire:model.lazy="contact_person_email" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('contact_person_email') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Contact Person WhatsApp -->
                <div>
                    <label for="contact_person_whatsapp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        WhatsApp
                    </label>
                    <input type="text" id="contact_person_whatsapp" wire:model.lazy="contact_person_whatsapp" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('contact_person_whatsapp') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </fieldset>

        <!-- Additional Info Section -->
        <fieldset class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 space-y-4">
            <legend class="px-2 text-lg font-medium text-gray-900 dark:text-gray-100">Additional Info</legend>

            <!-- Working Hours -->
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 space-y-4">
                <legend class="px-2 text-sm font-medium text-gray-700 dark:text-gray-300">Working Days and Hours</legend>
                
                <!-- Working Days -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Working Days
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-7 gap-2">
                        @php
                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        @endphp
                        @foreach($days as $day)
                            <label class="inline-flex items-center">
                                <input type="checkbox" wire:model="working_hours_days" value="{{ $day }}" 
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $day }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('working_hours_days') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Working Hours From -->
                    <div>
                        <label for="working_hours_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Working From
                        </label>
                        <input type="time" id="working_hours_from" wire:model.lazy="working_hours_from" 
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        @error('working_hours_from') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Working Hours To -->
                    <div>
                        <label for="working_hours_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Working To
                        </label>
                        <input type="time" id="working_hours_to" wire:model.lazy="working_hours_to" 
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        @error('working_hours_to') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>
            </fieldset>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Established Year -->
                <div>
                    <label for="established_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Established Year
                    </label>
                    <select id="established_year" wire:model.lazy="established_year" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        <option value="">-- Select Year --</option>
                        @foreach($availableYears as $yearValue => $yearLabel)
                            <option value="{{ $yearValue }}">{{ $yearLabel }}</option>
                        @endforeach
                    </select>
                    @error('established_year') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Tags -->
                <div>
                    <label for="tags_input" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Tags (comma-separated)
                    </label>
                    <input type="text" id="tags_input" wire:model.lazy="tags_input" placeholder="e.g., plumber, electrician, best service" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('tags_input') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </fieldset>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" 
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-500 transition-colors duration-200">
                <span wire:loading.remove wire:target="saveProvider">Create Provider Profile</span>
                <span wire:loading wire:target="saveProvider">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                </span>
            </button>
        </div>
    </form>
</div>