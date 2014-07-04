<?php namespace CommandBus;

use Mockery as m;

class ResolutionTest extends \PHPUnit_Framework_TestCase {

	public function testExecutionBusResolves() {
		$this->assertInstanceOf('CommandBus\ExecutionBus', $this->getExecutionBus());
	}

	public function getExecutionBus($inflector = null, $container = null) {
		return new ExecutionBus(
			$container ?: m::mock('Illuminate\Container\Container'),
			$inflector ?: m::mock('CommandBus\NameInflector')
		);
	}

	public function testValidationBusResolves() {
		extract($this->getMocks());
		
		$eb = $this->getExecutionBus($inflector, $container);

		$validationBus = $this->getValidationBus($eb, $container, $inflector, $writer);

		$this->assertInstanceOf('CommandBus\ValidationBus', $validationBus);
	}

	public function getValidationBus($bus, $container, $inflector, $writer) {
		return new ValidationBus(
			$bus,
			$container,
			$inflector,
			$writer
		);
	}

	public function testLoggingBusResolves() {
		extract($this->getMocks());

		$eb = $this->getExecutionBus($inflector, $container);
		$loggingBus = $this->getLoggingBus($eb, $container, $inflector, $writer);
		$this->assertInstanceOf('CommandBus\LoggingBus', $loggingBus);
	}

	public function getLoggingBus($bus, $container, $inflector, $writer) {
		return new LoggingBus(
			$bus,
			$container,
			$inflector,
			$writer
		);
	}

	public function getMocks() {
		return [
			'inflector' => m::mock('CommandBus\NameInflector'),
			'container' => m::mock('Illuminate\Container\Container'),
			'writer' => m::mock('Illuminate\Log\Writer'),
		];
	}

}
