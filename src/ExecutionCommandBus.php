<?php namespace JesseObrien\CommandBus;

use Illuminate\Container\Container;

class ExecutionCommandBus implements CommandBus {

	private $container;

	private $inflector;

	public function __construct(Container $container, NameInflector $inflector) {
		$this->container = $container;
		$this->inflector = $inflector;
	}

	public function execute(Request $request) {
		return $this->getHandler($request)->handle($request);
	}

	public function getHandler(Request $request) {
		return $this->container->make($this->inflector->getHandlerClass($request));
	}
}
