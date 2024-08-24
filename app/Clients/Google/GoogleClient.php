<?php

namespace App\Clients\Google;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException as Exception;
use Illuminate\Support\Facades\Log;

abstract class GoogleClient
{
    private string $googleApiKey;
    private string $googleApiUrl = 'https://maps.googleapis.com';

    public function __construct()
    {
        $this->googleApiKey = config('google.place_api_key');;
    }

    protected function placesApiCall(string $queryString): object | bool
    {
        $client = new Client([
            'base_uri' => $this->googleApiUrl
        ]);

        try {
            $path = "/maps/api/place/{$queryString}&key={$this->googleApiKey}";
            $response = $client->get($path);
            return json_decode($response->getBody()->getContents());
        }catch (Exception $e) {
            Log::info($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
            return false;
        }
    }
}