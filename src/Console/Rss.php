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
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Rss extends Command
{
    protected function configure()
    {
        $this
            ->setName('rss')
            ->setDescription('Shows a RSS feed')
            ->addArgument(
                'url',
                InputArgument::REQUIRED,
                'A valid url to an RSS feed '
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $reader = new ReadRssFeed($url);
        $output->writeln($reader->read());
    }
}
