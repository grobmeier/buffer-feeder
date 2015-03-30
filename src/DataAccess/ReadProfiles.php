<?php
namespace Grobmeier\Buffer\Feeder\DataAccess;

use GuzzleHttp\Client;

class ReadProfiles
{
    private $accessToken;

    function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function read()
    {
        $client = new Client();
        $response = $client->get(sprintf('https://api.bufferapp.com/1/profiles.json?access_token=%s', $this->accessToken));

        $result = [];
        array_map(function($item) use (&$result) {
            $r = new \stdClass();
            $r->id = $item['_id'];
            $r->service = $item['service'];
            $r->username = $item['service_username'];
            $r->service_id = $item['service_id'];

            $result[] = $r;
        }, $response->json());

        return $result;
    }
}