<?php

namespace Laravel\SparkInstaller\Installation;

use Symfony\Component\Process\Process;
use Laravel\SparkInstaller\NewCommand;

class RunNpmInstall
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
        if (! $this->command->output->confirm('Would you like to install the NPM dependencies?', true)) {
            return;
        }

        $this->command->output->writeln('<info>Installing NPM Dependencies...</info>');

        $process = (new Process('npm set progress=false && npm install', $this->command->path))->setTimeout(null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            $process->setTty(true);
        }

        $process->run(function ($type, $line) {
            $this->command->output->write($line);
        });
    }
}
