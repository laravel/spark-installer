<?php

namespace Laravel\SparkInstaller\Installation;

use Symfony\Component\Process\Process;
use Laravel\SparkInstaller\NewCommand;

class RunSparkInstall
{
    protected $command;

    /**
     * Create a new installation helper instance.
     *
     * @param  NewCommand  $command
     * @return void
     */
    public function __construct(NewCommand $command)
    {
        $this->command = $command;
    }

    /**
     * Run the installation helper.
     *
     * @return void
     */
    public function install()
    {
        $process = new Process($this->command(), $this->command->path);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            $process->setTty(true);
        }

        $process->run(function ($type, $line) {
            $this->command->output->write($line);
        });
    }

    /**
     * Get the proper Spark installation command.
     *
     * @return string
     */
    protected function command()
    {
        $command = 'php artisan spark:install --force';

        if ($this->command->input->getOption('braintree')) {
            $command .= ' --braintree';
        }

        if ($this->command->input->getOption('team-billing')) {
            $command .= ' --team-billing';
        }

        return $command;
    }
}
