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

If you would like an example of how the buses are instantiated, check the service provider's `register()` included in the source here.

### Laravel Service Provider

If you wish to integrate the commandbus with Laravel, there is one provided. You can simply add it to your providers array in `app/config/app.php` and start injecting the `CommandBus\CommandBus` interface into your controllers and classes.

`'CommandBus\CommandBusServiceProvider',`

**Note**: The execution order of the busses is:`Request -> LoggingBus -> ValidationBus -> ExecutionBus -> Handler`. If you wish to re-arrange the bus execution order, by all means make your own service provider and reorganize them. You could even write your own bus if you wanted.

### Example Request Cycle

To set up an example request cycle, we simply need a request object and handler and response objects to match.

Examples can be found in the [examples](https://github.com/JesseObrien/CommandBus/tree/master/examples) directory.
