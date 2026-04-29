<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiSignatureController extends Controller
{
    public function __construct(private readonly ApiService $api)
    {
    }

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

        $response = $this->api->connect()->post('/signature', $data);

        if (! $response->successful()) {
            // Log / handle error
            return back()->with('error', 'Erreur lors de l\'enregistrement de la signature distante.');
        }

        return redirect()
            ->route('accueil_session')
            ->with('status', 'Signature enregistrée !');
    }
}
