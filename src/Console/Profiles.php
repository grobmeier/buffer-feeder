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
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Profiles extends Command
{
    protected function configure()
    {
        $this
            ->setName('profiles')
            ->setDescription('Shows the currently connected profiles on Bufferapp')
            ->addArgument(
                'access_token',
                InputArgument::REQUIRED,
                'The access token to allow access to buffer'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $accessToken = $input->getArgument('access_token');
        $profileReader = new ReadProfiles($accessToken);

        foreach ($profileReader->read() as $profile) {
            $output->writeln("Profile ID: " . $profile->id);
            $output->writeln("Service: " . $profile->service);
            $output->writeln("Service User: " . $profile->username);
            $output->writeln("Service Id: " . $profile->service_id);
            $output->writeln('---');
        }
    }
}
