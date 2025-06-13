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
    public $provider;
    public $providerId;


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
    public $existingPhotos = []; // for preview
    public $existingLogo = null; // for preview
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
    public $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    public $working_hours_days = [];
    public $working_hours_from;
    public $working_hours_to;
    public $established_year;
    public $tags_input; // For comma-separated tags

    public $availableYears = [];

    public $steps = [
    'Provider & Details',
    'Contact Information',
    'Contact Person',
    'Working Hours & Tags',
    'Status & Settings'
    ];

    protected function rules()
    {
        return [
            0 => [
                'providable_type' => 'required|string',
                'providable_id' => 'required|integer',
                'business_name' => 'required|string|max:255',
                'description' => 'required|string',
                'photos.*' => 'nullable|image|max:2048',
                'logo' => 'nullable|image|max:1024',
            ],
            1 => [
                'phone' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'address' => 'required|string|max:255',
                'pincode' => 'required|string|max:20',
                'area' => 'nullable|string|max:255',
                'alternate_phone' => 'nullable|string|max:255',
                'whatsapp_number' => 'nullable|string|max:255',
                'website' => 'nullable|url|max:255',
            ],
            2 => [
                'contact_person_name' => 'required|string|max:255',
                'contact_person_role' => 'required|string|max:255',
                'contact_person_phone' => 'required|string|max:255',
                'contact_person_email' => 'nullable|email|max:255',
                'contact_person_whatsapp' => 'nullable|string|max:255',
            ],
            3 => [
                'working_hours_days' => 'nullable|array',
                'working_hours_days.*' => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'working_hours_from' => 'nullable|required_with:working_hours_to|date_format:H:i',
                'working_hours_to' => 'nullable|required_with:working_hours_from|date_format:H:i|after:working_hours_from',
                'established_year' => 'nullable|integer|min:1800|max:' . date('Y'),
                'tags_input' => 'nullable|string',
            ],
            4 => [
                'is_active' => 'boolean',
                'is_verified' => 'boolean',
                'featured' => 'boolean',
            ],
        ];
    }
    public $currentStep = 0;

    public function mount(Provider $provider)
    {   
        $this->provider = $provider;
        $this->services = Service::orderBy('name')->get();
        $this->serviceCategories = ServiceCategory::orderBy('name')->get();
        $this->availableYears = collect(range(date('Y'), 1800))->mapWithKeys(fn ($year) => [$year => $year])->toArray();
        $this->is_active = true; // Default value

        if ($provider) {
        $this->providerId = $provider->id;
        $this->loadProviderData($provider);
    }
    }

    public function loadProviderData(Provider $provider)
    {
        $this->provider = $provider;
        $this->providable_type = $this->provider->providable_type;
        $this->providable_id = $this->provider->providable_id;
        $this->business_name = $this->provider->business_name;
        $this->slug = $this->provider->slug;
        $this->description = $this->provider->description;
        $this->phone = $this->provider->phone;
        $this->alternate_phone = $this->provider->alternate_phone;
        $this->whatsapp_number = $this->provider->whatsapp_number;
        $this->email = $this->provider->email;
        $this->website = $this->provider->website;
        $this->address = $this->provider->address;
        $this->area = $this->provider->area;
        $this->pincode = $this->provider->pincode;
        $this->existingPhotos = $this->provider->photos ?? [];
        $this->existingLogo = $this->provider->logo ?? null;
        // $this->latitude = $this->provider->latitude;
        // $this->longitude = $this->provider->longitude;
        $this->contact_person_name = $this->provider->contact_person_name;
        $this->contact_person_role = $this->provider->contact_person_role;
        $this->contact_person_phone = $this->provider->contact_person_phone;
        $this->contact_person_email = $this->provider->contact_person_email;
        $this->contact_person_whatsapp = $this->provider->contact_person_whatsapp;
        $this->working_hours_days = $provider->working_hours['days'] ?? [];
        $this->working_hours_from = $provider->working_hours['from'] ?? '';
        $this->working_hours_to   = $provider->working_hours['to'] ?? '';
        $this->tags_input = is_array($this->provider->tags) ? implode(', ', $this->provider->tags) : '';
        $this->established_year = $this->provider->established_year;
        $this->is_active = $this->provider->is_active;
        // $this->is_verified = $this->provider->is_verified;
        // $this->featured = $this->provider->featured;
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
        foreach ($this->rules() as $step => $rulesForStep) {
        $this->validate($rulesForStep);
    }

        $user = Auth::user();
        if (!$user) {
             $this->dispatch('showToast', 
        type: 'error', 
        message: 'Please login to continue',
        duration: 5000
    );
            return redirect()->route('login'); // Or wherever your login route is
        }

       // Prepare photos paths
        if (!empty($this->photos)) {
            $photoPaths = [];
            foreach ($this->photos as $photo) {
                if (method_exists($photo, 'store')) {
                    $photoPaths[] = $photo->store('providers', 'uploads');
                } else {
                    // Existing path
                    $photoPaths[] = $photo;
                }
            }
        } else {
            // No new photos uploaded - keep existing photos
            $photoPaths = $this->existingPhotos ?? [];
        }

        // Prepare logo path
        if ($this->logo && method_exists($this->logo, 'store')) {
            $logoPath = $this->logo->store('provider-logos', 'uploads');
        } elseif ($this->logo) {
            // existing logo path string
            $logoPath = $this->logo;
        } else {
            // No new logo uploaded - keep existing logo
            $logoPath = $this->existingLogo;
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

    $providerData = [
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
    ];
        
        if ($this->providerId) {
        $provider = Provider::findOrFail($this->providerId);
        $provider->update($providerData);
        

        } else {
            $provider = Provider::create($providerData);
            

        }

         $this->dispatch('showToast', 
        type: 'success', 
        message: 'Provider profile updated successfully!',
        duration: 5000
    );
        // Optionally redirect or reset form
        // return redirect()->to('/dashboard/my-provider-profile');
        $this->resetForm();
    }

    private function resetForm()
    {
         $this->resetExcept(['services', 'serviceCategories', 'availableYears', 'providerId']);

    if ($this->providerId) {
        $provider = Provider::find($this->providerId);
        if ($provider) {
            $this->mount($provider); // call mount with the provider
        }
    } else {

         $this->dispatch('showToast', 
        type: 'success', 
        message: 'Provider profile created successfully!',
        duration: 5000
    );
       // Redirect to the user's provider list
        return $this->redirect(route('user-providers', ['user' => Auth::id()]), navigate: true);

    }
    }

        public function nextStep()
    {
        $this->validate($this->rules()[$this->currentStep]);
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function goToStep($step)
    {
        $this->currentStep = $step;
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