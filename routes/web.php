<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Providers;
use App\Livewire\UserDetails;
use App\Livewire\Test;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/', Home::class)->name('home');
// Route::get('/{service:slug}/{category:slug?}', Providers::class)->name('providers');
Route::get('/services/{service_slug}/{category_slug?}', Providers::class)->name('providers');
Route::get('/users/{user}', UserDetails::class)->name('user-details');
Route::get('/test', Test::class)->name('test');
Route::redirect('root', '/admin')->name('admin');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
