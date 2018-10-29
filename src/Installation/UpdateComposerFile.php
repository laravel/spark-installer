<?php

namespace Laravel\SparkInstaller\Installation;

use Laravel\SparkInstaller\NewCommand;

class UpdateComposerFile
{
    protected $command;
    protected $name;

    /**
     * Create a new installation helper instance.
     *
     * @param  NewCommand  $command
     * @param  string  $name
     * @return void
     */
    public function __construct(NewCommand $command, $name)
    {
        $this->name = $name;
        $this->command = $command;
    }

    /**
     * Run the installation helper.
     *
     * @return void
     */
    public function install()
    {
        $composer = $this->getComposerConfiguration();

        // Next we will add the Spark and Cashier dependencies to the Composer array as
        // well as add the Spark "repository" to the configuration so Composer knows
        // where Spark is located. Spark will get installed using the path option.
        $composer = $this->addRepository(
            $this->addSparkDependency(
                $this->addCashierDependency($composer)
            )
        );

        $this->writeComposerFile($composer);
    }

    /**
     * Read the Composer file from disk.
     *
     * @return array
     */
    protected function getComposerConfiguration()
    {
        return json_decode(file_get_contents(
            $this->command->path.'/composer.json'
        ), true);
    }

    /**
     * Add the Cashier Composer dependency.
     *
     * @param  array  $composer
     * @return array
     */
    protected function addCashierDependency($composer)
    {
        if ($this->command->input->getOption('braintree')) {
            $composer['require']['laravel/cashier-braintree'] = '~2.0';
        } else {
            $composer['require']['laravel/cashier'] = '~8.0';
        }

        return $composer;
    }

    /**
     * Add the Spark Composer dependency.
     *
     * @param  array  $composer
     * @return array
     */
    protected function addSparkDependency($composer)
    {
        $composer['require']['laravel/spark-aurelius'] = '*@dev';

        return $composer;
    }

    /**
     * Add the Spark repository to the Composer array.
     *
     * @param  array  $composer
     * @return array
     */
    protected function addRepository($composer)
    {
        $composer['repositories'] = [[
            'type' => 'path',
            'url' => './spark',
        ]];

        return $composer;
    }

    /**
     * Write the given Composer configuration back to disk.
     *
     * @param  array  $composer
     * @return void
     */
    protected function writeComposerFile($composer)
    {
        file_put_contents(
            $this->command->path.'/composer.json',
            json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }
}
