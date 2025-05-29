<?php

namespace App\Livewire;

use App\Models\Provider;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserProviderForm extends Component
{
    use WithFileUploads;

    // Providable properties
    public $providable_type;
    public $providable_id;
    public $services = [];
    public $serviceCategories = [];

    // Basic Info
    public $business_name;
    public $slug;
    public $description;
    public $phone;
    public $alternate_phone;
    public $whatsapp_number;
    public $email;
    public $website;
    public $address;
    public $area;
    public $pincode;
    public $photos = []; // For multiple file uploads
    public $logo;      // For single file upload
    public $latitude;
    public $longitude;
    public $is_active = true; // Default from Filament
    public $is_verified = false;
    public $featured = false;
    // public $views = 0; // Usually managed by system, not user input

    // Contact Person
    public $contact_person_name;
    public $contact_person_role;
    public $contact_person_phone;
    public $contact_person_email;
    public $contact_person_whatsapp;

    // Additional Info
    public $working_hours_days = [];
    public $working_hours_from;
    public $working_hours_to;
    public $established_year;
    public $tags_input; // For comma-separated tags

    public $availableYears = [];

    public function mount()
    {
        $this->services = Service::orderBy('name')->get();
        $this->serviceCategories = ServiceCategory::orderBy('name')->get();
        $this->availableYears = collect(range(date('Y'), 1800))->mapWithKeys(fn ($year) => [$year => $year])->toArray();
        $this->is_active = true; // Default value
    }

    protected function rules()
    {
        return [
            'providable_type' => 'required|string',
            'providable_id' => 'required|integer',
            'business_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:providers,slug,' . ($this->providerId ?? null), // Check for existing provider if editing
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'alternate_phone' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:20',
            'photos.*' => 'nullable|image|max:2048', // Max 2MB per photo
            'logo' => 'nullable|image|max:1024', // Max 1MB for logo
            // 'latitude' => 'nullable|numeric',
            // 'longitude' => 'nullable|numeric',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
            'featured' => 'boolean',

            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_role' => 'nullable|string|max:255',
            'contact_person_phone' => 'nullable|string|max:255',
            'contact_person_email' => 'nullable|email|max:255',
            'contact_person_whatsapp' => 'nullable|string|max:255',

            'working_hours_days' => 'nullable|array',
            'working_hours_days.*' => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'working_hours_from' => 'nullable|required_with:working_hours_to|date_format:H:i',
            'working_hours_to' => 'nullable|required_with:working_hours_from|date_format:H:i|after:working_hours_from',
            'established_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'tags_input' => 'nullable|string',
        ];
    }

    public function updatedBusinessName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function updatedProvidableType()
    {
        $this->providable_id = null; // Reset when type changes
    }

    public function saveProvider()
    {
        $this->validate();

        $user = Auth::user();
        if (!$user) {
            session()->flash('error', 'You must be logged in to create a provider profile.');
            return redirect()->route('login'); // Or wherever your login route is
        }

        $photoPaths = [];
        if (!empty($this->photos)) {
            foreach ($this->photos as $photo) {
                $photoPaths[] = $photo->store('providers', 'public');
            }
        }

        $logoPath = null;
        if ($this->logo) {
            $logoPath = $this->logo->store('provider-logos', 'public');
        }

        $tagsArray = [];
        if (!empty($this->tags_input)) {
            $tagsArray = array_map('trim', explode(',', $this->tags_input));
        }

       

         $workingHours = null; // Default to null
        // Only create the working_hours array if all necessary parts are present
        // Adjust condition as needed. e.g., if days can be empty but from/to must exist.
        if (!empty($this->working_hours_from) && !empty($this->working_hours_to) /* && !empty($this->working_hours_days) removed this if days can be empty */) {
            $workingHours = [
                'days' => $this->working_hours_days, // This will be an empty array if no days are selected
                'from' => $this->working_hours_from,
                'to'   => $this->working_hours_to,
            ];
        }

// $tagsArray is already a PHP array:
// $tagsArray = array_map('trim', explode(',', $this->tags_input));

// $photoPaths is already a PHP array:
// $photoPaths[] = $photo->store('providers', 'public');

Provider::create([
    'user_id' => $user->id,
    'providable_type' => $this->providable_type,
    'providable_id' => $this->providable_id,
    'business_name' => $this->business_name,
    'slug' => $this->slug,
    'description' => $this->description,
    'phone' => $this->phone,
    'alternate_phone' => $this->alternate_phone,
    'whatsapp_number' => $this->whatsapp_number,
    'email' => $this->email,
    'website' => $this->website,
    'address' => $this->address,
    'area' => $this->area,
    'pincode' => $this->pincode,
    'photos' => $photoPaths ?: null, // Pass the PHP array directly
    'logo' => $logoPath,
    'latitude' => $this->latitude,
    'longitude' => $this->longitude,
    'is_active' => (bool)$this->is_active,
    'is_verified' => (bool)$this->is_verified,
    'featured' => (bool)$this->featured,
    'views' => 0,

    'contact_person_name' => $this->contact_person_name,
    'contact_person_role' => $this->contact_person_role,
    'contact_person_phone' => $this->contact_person_phone,
    'contact_person_email' => $this->contact_person_email,
    'contact_person_whatsapp' => $this->contact_person_whatsapp,

    // CHANGE THESE LINES:
    'working_hours' => $workingHours, // Pass the PHP array directly
    'established_year' => $this->established_year,
    'tags' => $tagsArray ?: null,     // Pass the PHP array (or null if $tagsArray is empty)
]);

        session()->flash('success', 'Provider profile created successfully!');
        // Optionally redirect or reset form
        // return redirect()->to('/dashboard/my-provider-profile');
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->resetExcept(['services', 'serviceCategories', 'availableYears']); // Keep preloaded data
        $this->mount(); // Re-run mount to set defaults like is_active
    }

    public function render()
    {
        $providableItems = [];
        if ($this->providable_type === Service::class) {
            $providableItems = $this->services;
        } elseif ($this->providable_type === ServiceCategory::class) {
            $providableItems = $this->serviceCategories;
        }

        return view('livewire.user-provider-form', [
            'providableItems' => $providableItems,
        ]);
    }
}