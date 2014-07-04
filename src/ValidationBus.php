<?php namespace CommandBus;

use Illuminate\Container\Container;
use Illuminate\Log\Writer;
use ReflectionException;

class ValidationBus implements CommandBus {

	private $container;
	private $inflector;
	private $bus;
	private $log;
	
	public function __construct(CommandBus $bus, Container $container, NameInflector $inflector, Writer $log) {
		$this->bus = $bus;
		$this->container = $container;
		$this->inflector = $inflector;
		$this->log = $log;
	}

	public function execute(Request $request) {
		$this->validate($request);
		return $this->bus->execute($request);
	}

	public function validate(Request $request) {
		$validatorClass = $this->inflector->getValidatorClass($request);
		try {
			$validator = $this->container->make($validatorClass);
			$validator->validate($request);
		} catch(ReflectionException $e) {
			$this->log->error($e);
		}

	}

}
