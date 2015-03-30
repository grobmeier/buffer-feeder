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

class OutboxTest extends \PHPUnit_Framework_TestCase
{
    public function testWrite()
    {
        $outbox = new Outbox();

        $this->assertFalse($outbox->isSent('grobmeier.de'));
        $outbox->sent('grobmeier.de', 'Wed, 25 Mar 2015 00:00:00 +0100');
        $this->assertTrue($outbox->isSent('grobmeier.de'));

        $outbox->deleteArchive();

        $this->assertFalse(file_exists('archive.json'));

    }
}
