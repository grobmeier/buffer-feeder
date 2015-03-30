<?php
namespace Grobmeier\Buffer\Feeder\Console;

use Grobmeier\Buffer\Feeder\DataAccess\ReadProfiles;
use Grobmeier\Buffer\Feeder\DataAccess\ReadRssFeed;
use Grobmeier\Buffer\Feeder\DataAccess\UpdateBuffer;
use Grobmeier\Buffer\Feeder\Outbox;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Send extends Command
{
    protected function configure()
    {
        $this
            ->setName('send')
            ->setDescription('Buffers new RSS items')
            ->addArgument(
                'access_token',
                InputArgument::REQUIRED,
                'The access token to allow access to buffer'
            )
            ->addArgument(
                'config',
                InputArgument::REQUIRED,
                'path to the configuration file (see example in etc/config-dist.json)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $input->getArgument('config');
        $access_token = $input->getArgument('access_token');

        $configPath = realpath(__DIR__ . '/../../' . $config);
        $jobs = json_decode(file_get_contents($configPath));

        array_map(function($job) use ($output, $access_token) {
            $reader = new ReadRssFeed($job->url);
            $outbox = new Outbox($job->archive);
            $updater = new UpdateBuffer();

            $items = $reader->read();

            foreach ($items->item as $item) {
                $title = (string)$item->title;
                $link = (string)$item->link;
                $guid = (string)$item->guid;

                if (!$outbox->isSent($guid)) {
                    $updater->send($access_token, $title . ' ' . $link, $job->service);
                    $outbox->sent($guid, (string)$item->pubDate);
                }
            }

        }, $jobs);
    }
}