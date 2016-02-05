<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
//use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\ArrayInput;
//use Src\RouterBoard\RouterBoardMod;
//use Src\RouterBoard\SecureTools;
use Src\Logger\OutputLogger;
use Src\RouterBoard\RouterBoardBackup;

class CliRouterBoardBackup extends Command {

	private $config;

	public function __construct(array $config) {
		parent::__construct ();
		$this->config = $config;
	}
	
	protected function configure() {
		$this
		->setName ( 'rb:backup' )
		->setDescription ( 'Mikrotik RouterBoard backup configurations.' )
		->addArgument ( 'action', InputArgument::OPTIONAL, 'backup', 'backup' )
		;
	}
	
	protected function execute( InputInterface $input, OutputInterface $output ) {
		$logger = new OutputLogger ( $output );
		$rbackup  = new RouterBoardBackup( $this->config, $logger );
		$action = $input->getArgument ( 'action' );
		switch ($action) {
			case "backup":
				$logger->log ( "Action: Backup all routers from backup list." );
				$rbackup->backupAllRouterBoards();
				break;
			default:
				$this->defaultHelp($output);
				break;
		}
	}

	/**
	 * Print help to default otput
	 * @param $output
	 */
	private function defaultHelp($output) {
		$command = $this->getApplication()->get('help');
		$command->run(new ArrayInput(['command_name' => $this->getName()]), $output);
	}

}