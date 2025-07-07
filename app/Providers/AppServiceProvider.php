<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
          Gate::define('accessFilamentAdmin', function ($user) {
        $allowedEmails = [
            'rijumistri4@gmail.com',
            'riju8263@gmail.com',
            'rijumistri@gmail.com',
            'ufighter86@gmail.com',
            'nekketsu333@gmail.com',
            'nekketsu1992@gmail.com',
            'nesplayer01@gmail.com',
            'uxplayer01@gmail.com',
            'unixol88@gmail.com',
            'admin@email.com',
            'admin@example.com',
            'admin1@example.com',
            'admin2@example.com',

        ];

        return in_array($user->email, $allowedEmails);
    });
    }
}
