<?php namespace JesseObrien\CommandBus;

interface CommandBus {
	public function execute(Request $request);
}
