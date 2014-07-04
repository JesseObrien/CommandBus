<?php

use App;
use Log;

class InsertNewBookLogger {
	
	public function log(Request $request) {
		if (App::environment('local'))
		{
			Log::info("A ".get_class($request)." request was sent through the bus.");
			Log::info("It contained ".get_object_vars($request));
		}
	}

}

