<?php
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