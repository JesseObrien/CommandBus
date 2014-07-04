<?php

use Acme\Library;

class InsertNewBookHandler implements CommandBus\Handler {

	private $library;

	public function __construct(Library $library) {
		$this->library = $libraryy;
	}

	public function handle(Request $request) {

		$book = new Book();
		$book->author = $request->author;
		$book->title = $request->title;
		$book->isbn = $request->isbn;

		$book = $this->library->addBook($book);

		return new InsertBookResponse($book);

	}

}

