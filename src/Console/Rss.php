<?php
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
            ->setDescription('The access token to allow access to buffer')
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