<?php

namespace App\Service;

use App\Entity\Home;
use GuzzleHttp\Client;

class MeteoFinder
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getMeteoForHome(Home $home) : array
    {
        $client = new Client(['base_uri' => 'https://api.openweathermap.org']);
        $res = $client->request('GET', '/data/2.5/onecall', [
            'query' => [
                'lat' => $home->getLatitude(),
                'lon' => $home->getLongitude(),
                'exclude' => 'minutely, hourly',
                'units' => 'metric',
                'lang' => 'fr',
                'appid' => $this->apiKey,
            ]
        ]);

        return json_decode($res->getBody(), true);
    }
}