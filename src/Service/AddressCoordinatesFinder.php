<?php

namespace App\Service;

use GuzzleHttp\Client;

class AddressCoordinatesFinder
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getLatitudeAndLongitude($postcode) : array
    {
        $client = new Client(['base_uri' => 'http://api.positionstack.com']);
        $res = $client->request('GET', '/v1/forward', [
            'query' => [
                'access_key' => $this->apiKey,
                'query' => $postcode,
                'country' => 'fr'
            ],
        ]);

        return json_decode($res->getBody(), true);
    }
}