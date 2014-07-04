## CommandBus Base

This package provides an opinionated base to get started using the Command Bus architecture in PHP. Most of what's here has been derived from code and discussions with @ShawnMcCool. The structure may not fit with everyone's definitions of how a Command Bus should be implemented, however it provides a path of little resistance for newcomers.

### Um.. wat

If you're unfamiliar with Command Bus style architecture I urge you to check out a talk that @ShawnMcCool gave at [Laracon 2014](http://www.youtube.com/watch?v=2_380DKU93U). Another great resource on learning the concepts and reasons for this style of architecture is a series at [Laracasts](http://laracasts.com) called [Commands and Domain Events](https://laracasts.com/series/commands-and-domain-events). For more advance reading and learning, check out [Mathias Verraes' website](http://verraes.net/#talks).

### Buses

This package comes by default with:

* ExecutionBus
* ValidationBus
* LoggingBus

How you stack them is up to you, however the ExecutionBus must come last to deliver the request to the final `handle()` call.

### Example Bus
```php

# Instantiate shared dependencies
$inflector = new CommandBus\NameInflector;
$container = new Illuminate\Container\Container;
$logger = new Illuminate\Log\Writer;

# Instantiate busses
$executionBus = new ExecutionBus($container, $inflector);

$validationBus = new CommandBus\ValidationBus($executionBus, $container, $inflector, $logger);

# In this instance, each command passed to the bus will
# first run through the logging bus, which then executes
# the validation bus, and finally the execution bus.
return new CommandBus\LoggingBus($validationBus, $container, $inflector, $logger);
```

### Laravel Service Provider

If you wish to integrate the commandbus with Laravel, there is one provided. You can simply add it to your providers array in `app/config/app.php` and start injecting the `CommandBus\CommandBus` interface into your controllers and classes.

**Note**: The default execution order of the busses is `Request -> LoggingBus -> ValidationBus -> ExecutionBus -> Handler`. If you wish to re-arrange the bus execution order, by all means make your own service provider and reorganize them. You could even write your own bus if you wanted.

```php
	# Add this provider to the providers array
	'CommandBus\CommandBusServiceProvider',
```



### Example Request Cycle

To set up an example request cycle, we simply need a request object and handler and response objects to match.
```php
class InsertNewBookRequest {

	public $author;
	public $title;
	public $isbn;

	public function __construct($author, $title, $isbn) {
		$this->author = $author;
		$this->title = $title;
		$this->isbn = $isbn;
	}

}
```

```php
class InsertNewBookResponse {

	public $book;

	public function __construct($book) {
		$this->book = $book;
	}

}
```

```php
class InsertNewBookHandler implements Handler {

	private $bookRepository;

	public function __construct(BookRepository $bookRepository) {
		$this->bookRepository = $bookRepository;
	}

	public function handle(Request $request) {
		$book = Book::new(
			$author,
			$title,
			$isbn
		);

		$this->bookRepository->save($book);

		return new InsertBookResponse($book);
	}

}
```

```php
# If we want to use a validator, we can create a validation object as well
class InsertNewBookValidator implements Validator {
	
	public $rules = [
		'author' => 'required',
		'title' => 'required',
	];

	public function validate(Request $request) {
		$requestData = [
			'author' => $request->author,
			'title' => $request->title
		];

		$validator = Validator::make($rules, $data);

		if ( ! $ validator->passes()) {
			throw new ValidationException($validator->messages());
		}

	}

}
```

```php
# If we want to use a logger for a request, we can
class InsertNewBookLogger {
	
	public function log(Request $request) {
		if (App::environment('local'))
		{
			Log::info("A ".get_class($request)." request was sent through the bus.");
			Log::info("It contained ".get_object_vars($request));
		}
	}

}
```
