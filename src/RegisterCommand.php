<?php

namespace Laravel\SparkInstaller;

use Exception;
use GuzzleHttp\Client as HttpClient;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class RegisterCommand extends SymfonyCommand
{
    use InteractsWithSparkAPI,
        InteractsWithSparkConfiguration;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('register')
            ->setDescription('Register an API token with the installer')
            ->addArgument('token', InputArgument::REQUIRED, 'The API token');
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
        if (! $this->valid($input->getArgument('token'))) {
            return $this->tokenIsInvalid($output);
        }

        if (! $this->configExists()) {
            mkdir($this->homePath().'/.spark');
        }

        $this->storeToken($input->getArgument('token'));

        $this->tokenIsValid($output);
    }

    /**
     * Determine if the given token is valid.
     *
     * @param  string  $token
     * @return bool
     */
    protected function valid($token)
    {
        try {
            (new HttpClient)->get(
                $this->sparkUrl.'/api/token/'.$token.'/validate',
                ['verify' => __DIR__.'/cacert.pem']
            );

            return true;
        } catch (Exception $e) {
            var_dump($e->getMessage());

            return false;
        }
    }

    /**
     * Inform the user that the token is valid.
     *
     * @param  OutputInterface  $output
     * @return void
     */
    protected function tokenIsValid($output)
    {
        $output->writeln('Validating Token: <info>✔</info>');

        $output->writeln('<info>Thanks for registering Spark!</info>');
    }

    /**
     * Inform the user that the token is invalid.
     *
     * @param  OutputInterface  $output
     * @return void
     */
    protected function tokenIsInvalid($output)
    {
        $output->writeln('Validating Token: <fg=red>✘</>');

        $output->writeln('<comment>This API token is invalid.</comment>');
    }
}
