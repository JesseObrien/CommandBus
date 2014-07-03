<?php namespace JesseObrien\CommandBus;

interface Handler {
	public function handle(Request $request);
}
