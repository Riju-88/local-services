<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return $this->verifiedResponse();
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $this->verifiedResponse();
    }

    protected function verifiedResponse()
    {
        // First redirect to dashboard with verification flag (for the test)
        // Then dashboard will redirect to clean home URL
        return redirect()->route('dashboard', ['verified' => 1]);
    }
}
