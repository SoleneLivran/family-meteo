<?php

namespace App\Service;

use GuzzleHttp\Client;

class AddressCoordinatesFinder
{
    /** @var string */
    private $apiKey;

    /** @var Client */
    private $client;

    /**
     * AddressCoordinatesFinder constructor.
     * @param string $apiKey
     * @param Client $client
     */
    public function __construct(string $apiKey, Client $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    // use locationIQ API to get address geographic infos, including latitude and longitude
    public function getLatitudeAndLongitude($city, $postalcode, $country)
    {
        $res = $this->client->request('GET', '/v1/search.php', [
            'query' => [
                'key' => $this->apiKey,
                'city' => $city,
                'postalcode' => $postalcode,
                'country' => $country,
                'format' => 'json'
            ],
        ]);

        return json_decode($res->getBody(), true);
    }
}