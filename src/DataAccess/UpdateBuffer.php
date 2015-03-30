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