<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use App\Services\ApiService;

class ApiCoursController extends Controller
{
    public function __construct(private readonly ApiService $api)
    {
    }

    /**
     * @throws ConnectionException
     */
    public function index()
    {
        $response = $this->api->connect()
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
        $response = $this->api->connect()
            ->get("/cours/{$id}");

        return view('signature', [
            'cours' => $response->json(),
        ]);
    }
}
