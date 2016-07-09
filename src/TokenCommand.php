<?php

namespace Laravel\SparkInstaller;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class TokenCommand extends SymfonyCommand
{
    use InteractsWithSparkConfiguration;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('token')
            ->setDescription('Display the currently registered Spark API token');
    }

    /**
     * Execute the command.
     *
     * @param  InputInterface  $input
     * @param  OutputInterface  $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Spark API Token:</info> '.$this->readToken());
    }
}
