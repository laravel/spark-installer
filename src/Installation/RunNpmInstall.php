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
        $usesYarn = $this->usesYarn();

        $title = $usesYarn ? 'NPM (Yarn)' : 'NPM';

        if (! $this->command->output->confirm("Would you like to install the {$title} dependencies?", true)) {
            return;
        }

        $this->command->output->writeln("<info>Installing {$title} Dependencies...</info>");

        if($usesYarn) {
            $process = (new Process('yarn --no-progress', $this->command->path))->setTimeout(null);
        } else {
            $process = (new Process('npm set progress=false && npm install', $this->command->path))->setTimeout(null);
        }

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            $process->setTty(true);
        }

        $process->run(function ($type, $line) {
            $this->command->output->write($line);
        });
    }

    public function usesYarn()
    {
        $process = new Process('which yarn');

        $process->run();

        return $process->isSuccessful();
    }
}
