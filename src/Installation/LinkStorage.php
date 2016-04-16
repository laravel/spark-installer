<?php

namespace Laravel\SparkInstaller\Installation;

use Laravel\SparkInstaller\NewCommand;
use Symfony\Component\Process\Process;

class LinkStorage {

	protected $command;

	/**
	 * Create a new installation helper instance.
	 *
	 * @param  NewCommand  $command
	 * @return void
	 */
	public function __construct(NewCommand $command) {
		$this->command = $command;
	}

	/**
	 * Run the installation helper.
	 *
	 * @return void
	 */
	public function install() {
		if (!$this->command->output->confirm('Would you like to link your Storage Path?', true)) {
			return;
		}

		$this->command->output->writeln('<info>Linking Storage...</info>');

		$process = (new Process('ln -nfs /storage/app/public /public/storage', $this->command->path))->setTimeout(null);

		if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
			$process->setTty(true);
		}

		$process->run(function ($type, $line) {
			$this->command->output->write($line);
		});
	}
}
