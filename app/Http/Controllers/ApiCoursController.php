<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiCoursController extends Controller
{
    /**
     * @throws ConnectionException
     */
    public function index()
    {
        $response = Http::baseUrl(config('services.api.url'))
                    ->acceptJson()
                    ->withToken(Session::get('remote_auth_token'))
                    ->get('/cours');

        if ($response->failed()) {
            abort($response->status(), 'Impossible de récupérer les cours');
        }

        return view('accueil_session', [
            'cours' => $response->json(),
        ]);
    }

    /**
     * @throws ConnectionException
     */
    public function show($id)
    {
        $response = Http::baseUrl(config('services.api.url'))
                    ->acceptJson()
                    ->withToken(Session::get('remote_auth_token'))
                    ->get("/cours/{$id}");

        return view('signature', [
            'cours' => $response->json(),
        ]);
    }
}
