<div class="max-w-4xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Create Provider Profile</h2>
    {{-- session --}}
    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- errors --}}
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    {{--  --}}

    <!-- Progress Indicator -->
    <div class="flex justify-between items-center mb-8">
        @foreach ($steps as $index => $stepName)
            <div class="flex flex-col items-center w-full">
                <div class="w-8 h-8 flex items-center justify-center rounded-full 
                    {{ $currentStep > $index ? 'bg-green-500' : ($currentStep == $index ? 'bg-blue-600' : 'bg-gray-300') }} text-white font-medium">
                    {{ $index + 1 }}
                </div>
                <span class="mt-2 text-xs sm:text-sm text-gray-700 dark:text-gray-300">{{ $stepName }}</span>
            </div>
        @endforeach
    </div>

    <form wire:submit.prevent="saveProvider" class="space-y-8">

        <!-- Step 1: Provider & Details -->
        @if ($currentStep === 0)
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 space-y-4">
                <legend class="px-2 text-lg font-medium text-gray-900 dark:text-gray-100">Provider & Details</legend>

                <!-- Provider Type -->
                <div>
                    <label for="providable_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Link Provider to Type
                    </label>
                    <select id="providable_type" wire:model.live="providable_type"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
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
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        <option value="">-- Select Item --</option>
                        @foreach($providableItems as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('providable_id') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                @endif

                <!-- Business Name -->
                <div>
                    <label for="business_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Business Name
                    </label>
                    <input type="text" id="business_name" wire:model.blur="business_name"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('business_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Slug
                    </label>
                    <input type="text" id="slug" wire:model="slug" readonly
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm bg-gray-100 dark:bg-gray-800 dark:text-gray-200 cursor-not-allowed p-2">
                    @error('slug') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Description
                    </label>
                    <textarea id="description" wire:model.lazy="description" rows="3"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200"></textarea>
                    @error('description') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <!-- Photos -->
<div>
    <label for="photos" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Photos (select multiple)
    </label>
    <input type="file" id="photos" wire:model="photos" multiple
        class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-200 dark:hover:file:bg-blue-800 p-2">
    
    <div wire:loading wire:target="photos" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Uploading...</div>
    @error('photos.*') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror

    <div class="mt-3 space-y-1">
        @if (!empty($existingPhotos))
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Previously Uploaded:</p>
            <div class="flex flex-wrap gap-2">
                @foreach ($existingPhotos as $url)
                    <img src="{{ asset('uploads/' . $url) }}" class="h-20 w-auto rounded-lg border border-gray-200 dark:border-gray-600">
                @endforeach
            </div>
        @endif

        @if ($photos)
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-2">New Uploads:</p>
            <div class="flex flex-wrap gap-2">
                @foreach ($photos as $photo)
                    @if (method_exists($photo, 'temporaryUrl'))
                        <img src="{{ $photo->temporaryUrl() }}" class="h-20 w-auto rounded-lg border border-gray-200 dark:border-gray-600">
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>


                <!-- Logo -->
<div>
    <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        Logo
    </label>
    <input type="file" id="logo" wire:model="logo"
        class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-200 dark:hover:file:bg-blue-800">
    
    <div wire:loading wire:target="logo" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Uploading...</div>
    @error('logo') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror

    <div class="mt-3">
        @if (!empty($existingLogo))
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Logo:</p>
            <img src="{{ asset('uploads/' . $existingLogo) }}" class="h-20 w-auto rounded-lg border border-gray-200 dark:border-gray-600">
        @endif

        @if ($logo && method_exists($logo, 'temporaryUrl'))
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-2">New Upload:</p>
            <img src="{{ $logo->temporaryUrl() }}" class="h-20 w-auto rounded-lg border border-gray-200 dark:border-gray-600">
        @endif
    </div>
</div>


            </fieldset>
        @endif

        <!-- Step 2: Contact Information -->
        @if ($currentStep === 1)
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 space-y-4">
                <legend class="px-2 text-lg font-medium text-gray-900 dark:text-gray-100">Contact Information</legend>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Phone
                        </label>
                        <input type="tel" id="phone" wire:model.lazy="phone"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        @error('phone') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <!-- Alternate Phone -->
                    <div>
                        <label for="alternate_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Alternate Phone
                        </label>
                        <input type="tel" id="alternate_phone" wire:model.lazy="alternate_phone"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        @error('alternate_phone') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <!-- WhatsApp Number -->
                    <div>
                        <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            WhatsApp Number
                        </label>
                        <input type="text" id="whatsapp_number" wire:model.lazy="whatsapp_number"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
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
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        @error('email') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <!-- Website -->
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Website
                        </label>
                        <input type="url" id="website" wire:model.lazy="website"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
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
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        @error('address') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <!-- Area -->
                    <div>
                        <label for="area" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Area
                        </label>
                        <input type="text" id="area" wire:model.lazy="area"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        @error('area') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="pincode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Pincode
                    </label>
                    <input type="text" id="pincode" wire:model.lazy="pincode"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('pincode') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </fieldset>
        @endif

        <!-- Step 3: Contact Person -->
        @if ($currentStep === 2)
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 space-y-4">
                <legend class="px-2 text-lg font-medium text-gray-900 dark:text-gray-100">Contact Person</legend>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="contact_person_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Contact Person Name
                        </label>
                        <input type="text" id="contact_person_name" wire:model.lazy="contact_person_name"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        @error('contact_person_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="contact_person_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Role
                        </label>
                        <input type="text" list="roles" id="contact_person_role" wire:model.lazy="contact_person_role"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
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
                    <!-- Phone -->
                    <div>
                        <label for="contact_person_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Contact Phone
                        </label>
                        <input type="tel" id="contact_person_phone" wire:model.lazy="contact_person_phone"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        @error('contact_person_phone') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="contact_person_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Contact Email
                        </label>
                        <input type="email" id="contact_person_email" wire:model.lazy="contact_person_email"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        @error('contact_person_email') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label for="contact_person_whatsapp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            WhatsApp
                        </label>
                        <input type="text" id="contact_person_whatsapp" wire:model.lazy="contact_person_whatsapp"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        @error('contact_person_whatsapp') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>
            </fieldset>
        @endif

        <!-- Step 4: Working Hours & Tags -->
        @if ($currentStep === 3)
            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 space-y-4">
                <legend class="px-2 text-lg font-medium text-gray-900 dark:text-gray-100">Working Hours & Tags</legend>

                <!-- Working Days -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Working Days
                    </label>
                    <div class="flex flex-wrap">
                      
                        <flux:checkbox.group wire:model="working_hours_days">
                        <flux:checkbox.all label="Check All" />
                        {{--  --}}
                        @foreach($days as $day)
                                <div class="p-2 border border-gray-800 dark:border-white hover:bg-blue-400 transition rounded-xl my-2">
                                <flux:checkbox  value="{{ $day }}" label="{{ $day }}" />
                                </div>
                        @endforeach
                         </flux:checkbox.group>
                         {{--  --}}
                    </div>
                    @error('working_hours_days') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="working_hours_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            From
                        </label>
                        <input type="time" id="working_hours_from" wire:model.lazy="working_hours_from"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        @error('working_hours_from') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="working_hours_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            To
                        </label>
                        <input type="time" id="working_hours_to" wire:model.lazy="working_hours_to"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                        @error('working_hours_to') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Established Year -->
                <div>
                    <label for="established_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Established Year
                    </label>
                    <select id="established_year" wire:model.lazy="established_year"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
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
                    <input type="text" id="tags_input" wire:model.lazy="tags_input"
                        placeholder="e.g., plumber, electrician, best service"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 p-2">
                    @error('tags_input') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </fieldset>
        @endif

        <!-- Step 5: Status & Settings -->
        @if ($currentStep === 4)


            <fieldset class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 space-y-4">
                <legend class="px-2 text-lg font-medium text-gray-900 dark:text-gray-100">Status & Visibility</legend>

            {{--  --}}
            <div class="flex items-center space-x-3">
        <!-- Toggle Switch -->
        <button
            type="button"
            wire:click="$set('is_active', {{ $is_active ? 'false' : 'true' }})"
            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-300 focus:outline-none {{ $is_active ? 'bg-green-500' : 'bg-gray-400' }}"
        >
            <span
                class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-300 {{ $is_active ? 'translate-x-6' : 'translate-x-1' }}"
            ></span>
        </button>

        <!-- Dynamic Text -->
        <span class="text-sm font-medium {{ $is_active ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">
            {{ $is_active ? 'Active (Provider is visible)' : 'Inactive (Provider is hidden)' }}
        </span>
    </div>

            {{--  --}}
         @error('is_active') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
               

                

              
            </fieldset>
        @endif

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-8">
            @if ($currentStep > 0)
                <button type="button" wire:click="previousStep" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                    Back
                </button>
            @else
                <div></div>
            @endif

            @if ($currentStep < count($steps) - 1)
                <button type="button" wire:click="nextStep" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Next
                </button>
            @else
                <button type="submit" class="bg-green-600 text-white rounded-lg px-4 py-2 hover:bg-green-600
                dark:bg-green-500 dark:hover:bg-green-600 transition-colors duration-200 flex items-center gap-2">
                    <span wire:loading.remove wire:target="saveProvider">Create Provider Profile</span>
                    <span wire:loading wire:target="saveProvider">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Saving...
                    </span>
                </button>
            @endif
        </div>
    </form>
</div>