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

    public function getLatitudeAndLongitude($city, $postalcode)
    {   
        $client = new Client(['base_uri' => 'https://eu1.locationiq.com']);
        $res = $client->request('GET', '/v1/search.php', [
            'query' => [
                'key' => $this->apiKey,
                'city' => $city,
                'postalcode' => $postalcode,
                'format' => 'json'
            ],
        ]);

        return json_decode($res->getBody(), true);
    }
}