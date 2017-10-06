<?php

namespace Laravel\SparkInstaller\Upgrade;

use Illuminate\Filesystem\Filesystem;
use Laravel\SparkInstaller\UpgradeCommand;

class ClearSparkDirectory
{
    protected $command;

    /**
     * Create a new installation helper instance.
     *
     * @param  UpgradeCommand  $command
     * @return void
     */
    public function __construct(UpgradeCommand $command)
    {
        $this->command = $command;
    }

    /**
     * Run the installation helper.
     *
     * @return void
     */
    public function upgrade()
    {
        $this->command->output->writeln(
            '<info>Removing Spark...</info>'
        );

        (new Filesystem)->deleteDirectory(
            $this->command->path.'/spark'
        );
    }

}
