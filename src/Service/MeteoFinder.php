<?php

namespace App\Service;

use App\Entity\Home;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class MeteoFinder
{
    private $apiKey;

    /**
     * Constructor
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param $homes Home[]
     */
    // TODO : missing tags in phpdoc ?
    public function getMeteo(array $homes)
    {
        $client = new Client(['base_uri' => 'https://api.openweathermap.org']);

        $promises = [];
        $meteos = [];

        // use open weather map API to get weather info for each home
        foreach ($homes as $key => $home) {
            $promises[$key] = $client->requestAsync('GET', '/data/2.5/onecall', [
                'query' => [
                    'lat' => $home->getLatitude(),
                    'lon' => $home->getLongitude(),
                    'exclude' => 'minutely, hourly',
                    'units' => 'metric',
                    'lang' => 'fr',
                    'appid' => $this->apiKey,
                ]
            ]);
        }

        $responses = Promise\unwrap($promises);

        foreach ($responses as $key => $response) {
            $home = $homes[$key];
            $meteo = json_decode($response->getBody(), true);
            $meteos[$home->getId()] = $meteo;
        }

        return $meteos;
    }
}