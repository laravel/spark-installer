<?php

namespace Laravel\SparkInstaller;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class NewCommand extends SymfonyCommand
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
            ->setName('new')
            ->setDescription('Create a new Spark application')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the application')
            ->addOption('braintree', null, InputOption::VALUE_NONE, 'Install Braintree versions of the file stubs')
            ->addOption('team-billing', null, InputOption::VALUE_NONE, 'Configure Spark for team based billing');
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

        $this->path = getcwd().'/'.$input->getArgument('name');

        $installers = [
            Installation\CreateLaravelProject::class,
            Installation\DownloadSpark::class,
            Installation\UpdateComposerFile::class,
            Installation\ComposerUpdate::class,
            Installation\AddCoreProviderToConfiguration::class,
            Installation\RunSparkInstall::class,
            Installation\AddAppProviderToConfiguration::class,
            Installation\RunNpmInstall::class,
            Installation\CompileAssets::class,
        ];

        foreach ($installers as $installer) {
            (new $installer($this, $input->getArgument('name')))->install();
        }
    }
}
