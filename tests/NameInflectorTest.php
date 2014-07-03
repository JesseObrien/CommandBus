<?php namespace JesseObrien\CommandBus;

use Mockery as m;

class NameInflectorTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->testCommand = m::mock('overload:TestRequest');
		$this->nameInflector = new NameInflector;
	}

	public function tearDown() {
		m::close();
	}

	public function testHandlerClassInflection() {
		$handler = $this->nameInflector->getHandlerClass($this->testCommand);
		$this->assertEquals($handler, 'TestHandler');
	}

	public function testValidatorClassInflection() {
		$handler = $this->nameInflector->getValidatorClass($this->testCommand);
		$this->assertEquals($handler, 'TestValidator');
	}

	public function testLoggerClassInflection() {
		$handler = $this->nameInflector->getLoggerClass($this->testCommand);
		$this->assertEquals($handler, 'TestLogger');
	}


}
