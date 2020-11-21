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

    // use locationIQ API to get address geographic infos, including latitude and longitude
    public function getLatitudeAndLongitude($city, $postalcode, $country)
    {   
        $client = new Client(['base_uri' => 'https://eu1.locationiq.com']);
        $res = $client->request('GET', '/v1/search.php', [
            'query' => [
                'key' => $this->apiKey,
                'city' => $city,
                'postalcode' => $postalcode,
                'country' => $country,
                'format' => 'json'
            ],
        ]);

        // TODO : ext-json missing ?
        return json_decode($res->getBody(), true);
    }
}