<?php
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
