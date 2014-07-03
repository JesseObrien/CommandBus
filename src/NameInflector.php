<?php namespace JesseObrien\CommandBus;

class NameInflector {

	public function getHandlerClass($request) {
		return str_replace('Request', 'Handler', get_class($request));
	}

	public function getValidatorClass($request) {
		return str_replace('Request', 'Validator', get_class($request));
	}

	public function getLoggerClass($request) {
		return str_replace('Request', 'Logger', get_class($request));
	}

}
