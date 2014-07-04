<?php namespace CommandBus;

use Illuminate\Support\ServiceProvider;

class CommandBusServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('CommandBus', function($app) {

			$inflector = new NameInflector;

			$writer = $app->make('log');

			$executionBus = new ExecutionBus($app, $inflector);

			$validationBus = new ValidationBus($executionBus, $app, $inflector, $writer);			
			return new LoggingBus($validationBus, $app, $inflector, $writer);

		});
	}

}
