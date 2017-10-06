<?php

namespace Laravel\SparkInstaller;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class UpgradeCommand extends SymfonyCommand
{
    /**
     * The input interface.
     *
     * @var InputInterface
     */
    public $input;

    /**
     * The output interface.
     *
     * @var OutputInterface
     */
    public $output;

    /**
     * The path to the new Spark installation.
     *
     * @var string
     */
    public $path;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('upgrade')
            ->setDescription('Upgrade Spark application')
            ->addArgument('path', InputArgument::OPTIONAL, 'Path to the application', '.');
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
        $this->input = $input;
        $this->output = new SymfonyStyle($input, $output);

        $name = $input->getArgument('path');

        if ($name == '.') {
            $this->path = getcwd();
        } else {
            $this->path = getcwd().'/'.$name;
        }

        $upgraders = [
            Upgrade\ClearSparkDirectory::class,
            Upgrade\DownloadSpark::class,
        ];

        foreach ($upgraders as $upgrader) {
            (new $upgrader($this))->upgrade();
        }
    }
}
