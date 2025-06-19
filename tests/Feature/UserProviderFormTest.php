<?php

use App\Livewire\UserProviderForm;
use App\Models\Provider;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

// Group tests for better organization
describe('UserProviderForm', function () {

    // A common setup for most tests
    beforeEach(function () {
        // Create a user and log them in
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        // Create some services/categories since the component's mount method needs them
        Service::factory()->count(3)->create();
        ServiceCategory::factory()->count(2)->create();

        // Use a fake storage disk for file uploads to avoid polluting the actual filesystem
        Storage::fake('uploads');
    });

    test('it can be rendered successfully', function () {
        Livewire::test(UserProviderForm::class)
            ->assertStatus(200)
            ->assertSee('Provider & Details');
    });

    test('it loads an existing provider data on mount', function () {
        $provider = Provider::factory()->create([
            'user_id' => $this->user->id,
            'business_name' => 'Existing Test Provider',
            'email' => 'test@example.com',
        ]);

        Livewire::test(UserProviderForm::class, ['provider' => $provider])
            ->assertSet('providerId', $provider->id)
            ->assertSet('business_name', 'Existing Test Provider')
            ->assertSet('email', 'test@example.com');
    });

    test('it requires authentication to save a provider', function () {
        Auth::logout(); // Log out the user

        Livewire::test(UserProviderForm::class)
            ->call('saveProvider')
            ->assertRedirect(route('login'));
    });

    // --- Step-by-Step Validation ---

    test('step 1 validation fails with empty data', function () {
        Livewire::test(UserProviderForm::class)
            ->call('nextStep')
            ->assertHasErrors([
                'providable_type' => 'required',
                'providable_id' => 'required',
                'business_name' => 'required',
                'description' => 'required',
            ]);
    });

    test('it can proceed from step 1 to step 2 with valid data', function () {
        $service = Service::first();

        Livewire::test(UserProviderForm::class)
            ->set('providable_type', Service::class)
            ->set('providable_id', $service->id)
            ->set('business_name', 'My Awesome Business')
            ->set('description', 'A great description.')
            ->call('nextStep')
            ->assertHasNoErrors()
            ->assertSet('currentStep', 1);
    });

    test('step 2 validation works correctly', function () {
        Livewire::test(UserProviderForm::class)
            ->set('currentStep', 1) // Manually move to step 2
            ->call('nextStep')
            ->assertHasErrors([
                'phone' => 'required',
                'email' => 'required',
                'address' => 'required',
                'pincode' => 'required',
            ])
            ->set('email', 'not-an-email')
            ->set('website', 'not-a-url')
            ->call('nextStep')
            ->assertHasErrors([
                'email' => 'email',
                'website' => 'url',
            ]);
    });

    // --- Reactive Property Tests ---

    test('business_name update automatically generates a slug', function () {
        Livewire::test(UserProviderForm::class)
            ->set('business_name', 'A New Business Name 123!')
            ->assertSet('slug', 'a-new-business-name-123');
    });

    test('providable_id is reset when providable_type changes', function () {
        Livewire::test(UserProviderForm::class)
            ->set('providable_id', 99)
            ->set('providable_type', Service::class)
            ->assertSet('providable_id', null);
    });


    // --- Core Save Logic ---

    test('it can create a new provider successfully with all data', function () {
        $service = Service::first();
        $fakeLogo = UploadedFile::fake()->image('logo.jpg');
        $fakePhoto1 = UploadedFile::fake()->image('photo1.jpg');
        $fakePhoto2 = UploadedFile::fake()->image('photo2.jpg');

        Livewire::test(UserProviderForm::class)
            // Step 1
            ->set('providable_type', Service::class)
            ->set('providable_id', $service->id)
            ->set('business_name', 'My New Creation')
            ->set('description', 'The best business ever.')
            ->set('logo', $fakeLogo)
            ->set('photos', [$fakePhoto1, $fakePhoto2])
            // Step 2
            ->set('phone', '1234567890')
            ->set('email', 'contact@newcreation.com')
            ->set('address', '123 Main St')
            ->set('pincode', '10001')
            // Step 3
            ->set('contact_person_name', 'John Doe')
            ->set('contact_person_role', 'Manager')
            ->set('contact_person_phone', '0987654321')
            // Step 4
            ->set('working_hours_days', ['Monday', 'Friday'])
            ->set('working_hours_from', '09:00')
            ->set('working_hours_to', '17:00')
            ->set('tags_input', 'awesome, cool, great')
            // Step 5
            ->set('is_active', true)
            ->call('saveProvider')
            ->assertDispatched('showToast', type: 'success')
            ->assertRedirect(route('user-providers', ['user' => $this->user->id]));

        // Assert database has the new provider
        $this->assertDatabaseHas('providers', [
            'user_id' => $this->user->id,
            'business_name' => 'My New Creation',
            'slug' => 'my-new-creation',
            'email' => 'contact@newcreation.com',
            'tags' => json_encode(['awesome', 'cool', 'great']), // Check casted JSON
        ]);

        $provider = Provider::where('business_name', 'My New Creation')->first();
        
        // Assert working hours were stored correctly
        expect($provider->working_hours)->toBe([
            'days' => ['Monday', 'Friday'],
            'from' => '09:00',
            'to' => '17:00',
        ]);

        // Assert files were stored
        Storage::disk('uploads')->assertExists($provider->logo);
        foreach ($provider->photos as $photoPath) {
            Storage::disk('uploads')->assertExists($photoPath);
        }
    });

   

    test('it can update an existing provider successfully', function () {
        $provider = Provider::factory()->create(['user_id' => $this->user->id]);
        $newFakeLogo = UploadedFile::fake()->image('new-logo.png');

        Livewire::test(UserProviderForm::class, ['provider' => $provider])
            ->set('business_name', 'Updated Business Name')
            ->set('email', 'updated@email.com')
            ->set('logo', $newFakeLogo)
            ->call('saveProvider')
            // FIX: Assert the correct message is dispatched
            ->assertDispatched('showToast', 
                type: 'success', 
                message: 'Provider profile updated successfully!'
            );
        
    });
});