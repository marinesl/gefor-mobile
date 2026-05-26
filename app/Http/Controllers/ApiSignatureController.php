<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiSignatureController extends Controller
{
    /**
     * @throws ConnectionException
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'signature' => ['required', 'string'],  // base64 data URL
            'cours_id'  => ['required', 'integer'],
        ]);

        // Add the authenticated user id explicitly
        $data['user_id'] = Auth::id();

        $response = Http::baseUrl(config('services.api.url'))
                    ->acceptJson()
                    ->withToken(Session::get('remote_auth_token'))
                    ->post('/signature', $data);

        if (! $response->successful()) {
            // Log / handle error
            return back()->with('error', 'Erreur lors de l\'enregistrement de la signature distante.');
        }

        return redirect()
            ->route('accueil_session')
            ->with('status', 'Signature enregistrée !');
    }
}
