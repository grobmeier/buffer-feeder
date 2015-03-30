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
namespace Grobmeier\Buffer\Feeder\Console;

use Grobmeier\Buffer\Feeder\DataAccess\ReadProfiles;
use Grobmeier\Buffer\Feeder\DataAccess\ReadRssFeed;
use Grobmeier\Buffer\Feeder\DataAccess\UpdateBuffer;
use Grobmeier\Buffer\Feeder\Outbox;
use Grobmeier\Buffer\Feeder\TextFormatter;
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
            $formatter = new TextFormatter();

            // Convert from simplexml to stdclass quickly
            $items = json_decode(json_encode($reader->read()));

            foreach ($items->item as $item) {
                $guid = $item->guid;
                foreach ($job->service as $service) {
                    if (!$outbox->isSent($guid)) {
                        $text = $formatter->format($service, $item);
                        $updater->send($access_token, $text, [$service->profile]);
                        $outbox->sent($guid, (string)$item->pubDate);
                    }
                }
            }

        }, $jobs);
    }
}