<?php namespace CommandBus;

use Illuminate\Container\Container;
use Illuminate\Log\Writer;
use ReflectionException;

class LoggingBus implements CommandBus {

	private $bus;
	private $container;
	private $inflector;
	private $logger;

	public function __construct(CommandBus $bus, Container $container, NameInflector $inflector, Writer $logger) {
		$this->bus = $bus;
		$this->container = $container;
		$this->inflector = $inflector;
		$this->logger = $logger;
	}

	public function execute(Request $request) {
		$this->log($request);
		return $this->bus->execute($request);
	}

	public function log(Request $request) {
		$loggerClass = $this->inflector->getLoggerClass($request);
		try {
			$logger = $this->container->make($loggerClass);
			$logger->log($request);
		} catch (ReflectionException $e) {
			$this->logger->error($e);
		}
	}


}
