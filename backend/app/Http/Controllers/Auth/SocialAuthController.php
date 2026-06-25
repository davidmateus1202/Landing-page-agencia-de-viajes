<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /** Redirect the user to Google's OAuth screen. */
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    /** Handle the callback from Google. */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Throwable $e) {
            return $this->redirectToFrontend(['error' => 'auth_failed']);
        }

        // Whitelist of admin emails (comma-separated in .env).
        $admins = collect(explode(',', (string) config('services.google.admin_emails')))
            ->map(fn ($e) => trim(strtolower($e)))
            ->filter();

        $email = strtolower($googleUser->getEmail());

        if ($admins->isNotEmpty() && ! $admins->contains($email)) {
            return $this->redirectToFrontend(['error' => 'not_authorized']);
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $googleUser->getName() ?? $email,
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'is_admin' => true,
            ]
        );

        $token = $user->createToken('admin-panel')->plainTextToken;

        return $this->redirectToFrontend(['token' => $token]);
    }

    /** Return the authenticated admin. */
    public function me()
    {
        return Auth::user();
    }

    /** Revoke the current token. */
    public function logout()
    {
        Auth::user()?->currentAccessToken()?->delete();

        return response()->noContent();
    }

    private function redirectToFrontend(array $params)
    {
        $url = rtrim((string) config('services.google.frontend_url'), '/').'/admin/callback';

        return redirect()->away($url.'?'.http_build_query($params));
    }
}
