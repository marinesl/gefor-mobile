<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ApiService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    public function __construct(private readonly ApiService $api)
    {
    }

    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * @throws ConnectionException
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $response = $this->api->connect()->post("/auth/login", $data);

        if (! $response->successful()) {
            return back()
                ->with('error', 'Email ou mot de passe incorrect.');
        }

        $payload = $response->json();

        // Token from App A
        $token = $payload['token'] ?? null;
        $userData = $payload['user'] ?? null;

        if (! $token || ! $userData) {
            return back()
                ->with('error', 'Unexpected response from auth service.');
        }

        // Option A: create / sync a local user in App B (by email)
        $user = User::updateOrCreate(
            [
                'email' => $userData['email']
            ],
            [
                'name' => $userData['name'] ?? $userData['email'],
                // Dummy local password: never used, but satisfies NOT NULL
                'password' => Str::random(40),
            ]
        );

        // Log the user into App B using the local user model
        Auth::login($user);

        // Store the remote token in session so App B can call App A as this user
        Session::put('remote_auth_token', $token);

        return redirect()->intended('/accueil_session');
    }

    /**
     * @throws ConnectionException
     */
    public function logout(Request $request)
    {
        $token = Session::get('remote_auth_token');

        if ($token) {
            $this->api->connect()->post("/api/auth/logout/{$token}");
        }

        Session::forget('remote_auth_token');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
