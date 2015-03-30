<?php
namespace Grobmeier\Buffer\Feeder\DataAccess;

class ReadRssFeed
{
    private $url;

    function __construct($url)
    {
        $this->url = $url;
    }

    public function read()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get($this->url);
        return $response->xml()->channel;
    }
}