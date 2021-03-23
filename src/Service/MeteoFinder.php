<?php

namespace App\Service;

use App\Entity\Home;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Response;
use Throwable;

class MeteoFinder
{
    /** @var string */
    private $apiKey;

    /** @var Client */
    private $client;

    /**
     * Constructor
     * @param string $apiKey
     * @param Client $client
     */
    public function __construct(string $apiKey, Client $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    /**
     * @param $homes Home[]
     *
     * @return array
     *
     * @throws Throwable
     */
    public function getMeteo(array $homes)
    {
        $promises = [];
        $meteos = [];

        // use open weather map API to get weather info for each home
        foreach ($homes as $key => $home) {
            $promises[$key] = $this->client->requestAsync('GET', '/data/2.5/onecall', [
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
            /** @var Response $response */
            $home = $homes[$key];
            $meteo = json_decode($response->getBody(), true);
            $meteos[$home->getId()] = $meteo;
        }

        return $meteos;
    }
}