<?php

namespace App\Services;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class ApiService
{
    public function connect(): PendingRequest|Factory
    {
        return Http::baseUrl(config('services.api.url'))
                    ->acceptJson();
    }
}
