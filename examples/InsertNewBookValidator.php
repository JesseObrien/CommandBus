<?php

use Illuminate\Validation\Factory;
use Acme\ValidationException;

class InsertNewBookValidator implements Validator {
	
	public $rules = [
		'author' => 'required',
		'title' => 'required',
	];

	public function __construct(Factory $validator) {
		$this->validator = $validator;
	}

	public function validate(Request $request) {
	
		$validator = $this->validator->make($this->rules, $this->extractRequestData($request));

		if ( ! $validator->passes()) {
			$this->onFail($validator);
		}

	}

	public function extractRequestData($request) {
		return [
			'author' => $request->author,
			'title' => $request->title
		];
	}

	public function onFail($validator, $request) {
		throw new ValidationException($validator->messages());
	}

}

