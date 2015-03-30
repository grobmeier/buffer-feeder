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
namespace Grobmeier\Buffer\Feeder;

class Outbox
{
    private $cache;

    private $archiveFile = 'archive.json';

    function __construct($archiveFile = null)
    {
        if ($archiveFile != null) {
            $this->archiveFile = $archiveFile;
        }
    }

    private function readArchive()
    {
        if ($this->cache != null) {
            return;
        }

        if (!file_exists($this->archiveFile)) {
            $this->cache = [];
            return;
        }

        $this->cache = json_decode(file_get_contents($this->archiveFile));
    }

    private function writeArchive()
    {
        file_put_contents($this->archiveFile, json_encode($this->cache, JSON_PRETTY_PRINT), LOCK_EX);
    }

    public function isSent($guid)
    {
        if ($this->cache == null) {
            $this->readArchive();
        }

        foreach ($this->cache as $cacheEntry) {
            if ($cacheEntry->guid == $guid) {
                return true;
            }
        }
        return false;
    }

    public function sent($guid, $pubDate)
    {
        if ($this->cache == null) {
            $this->readArchive();
        }

        $push = new \stdClass();
        $push->guid = $guid;
        $push->pub_date = $pubDate;
        $push->sent = time();

        array_push($this->cache, $push);

        $this->writeArchive();
    }

    public function deleteArchive()
    {
        unlink($this->archiveFile);
    }
}