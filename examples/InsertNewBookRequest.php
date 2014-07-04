<?php 

/**
 * This request object is simply a DTO (Data Transfer Object)
 * It provides a way of passing 
 */
class InsertNewBookRequest implements CommandBus\Request {

	public $author;
	public $title;
	public $isbn;

	public function __construct($author, $title, $isbn) {
		$this->author = $author;
		$this->title = $title;
		$this->isbn = $isbn;
	}

}

