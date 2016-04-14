<?php

namespace Laravel\SparkInstaller\Installation;

use Symfony\Component\Process\Process;
use Laravel\SparkInstaller\NewCommand;

class AddAppProviderToConfiguration
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
        $path = $this->command->path.'/config/app.php';

        (new Process("awk '/App\\\\Providers\\\\AppServiceProvider::class,/{print \"        App\\\\Providers\\\\SparkServiceProvider::class,\"}1' ".$path." > temp && mv temp ".$path))->run();
        (new Process("awk '/App\\\\Providers\\\\AppServiceProvider::class,/{print \"        Laravel\\\\Cashier\\\\CashierServiceProvider::class,\"}1' ".$path." > temp && mv temp ".$path))->run();
    }
}
