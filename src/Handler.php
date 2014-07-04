<?php namespace CommandBus;

interface Handler {
	public function handle(Request $request);
}
