<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();

    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'password' => bcrypt('123456dummy'),
                    'user_type' => 'standard',
                ]
            );

            Auth::login($user);

            return redirect()->route('home.standard');

        } catch (Exception $e) {
            return redirect('login')->with('error', 'Google Login Gagal: ' . $e->getMessage());
        }
    }
}
