<?php
/**
 * Copyright 2015 Christian Grobmeier
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
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