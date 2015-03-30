<?php
namespace Grobmeier\Buffer\Feeder\DataAccess;

class UpdateBuffer
{
    public function send($access_token, $text, $profileIds, $now = true, $shorten = true)
    {
        $client = new \GuzzleHttp\Client();
        $client->post("https://api.bufferapp.com/1/updates/create.json?access_token=" . $access_token, [
            'body' => [
                'profile_ids' => $profileIds,
                'text' => $text,
                'now' => $now,
                'shorten' => $shorten
            ]
        ]);
    }
}