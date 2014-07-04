<?php namespace CommandBus;

interface CommandBus {
	public function execute(Request $request);
}
