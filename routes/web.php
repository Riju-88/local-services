<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Providers;
use App\Livewire\ProviderDetails;
use App\Livewire\UserDetails;
use App\Livewire\Test;
use App\Livewire\UserProviderForm;
use App\Livewire\UserProviderList;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/', Home::class)->name('home');

// Show all providers
Route::get('/services/{service_slug}/{category_slug?}', Providers::class)->name('providers');

// Show provider details
Route::get('/provider/{provider}', ProviderDetails::class)->name('provider-details');

Route::get('/users/{user}', UserDetails::class)->name('user-details');
Route::get('/test', Test::class)->name('test');
Route::redirect('root', '/admin')->name('admin');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    // User Provider Form
Route::get('/business/new', UserProviderForm::class)->name('add-provider');

// user provider list
Route::get('/business/manage/{user}', UserProviderList::class)->name('user-providers');
// user profile
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
