# Borsch - RequestHandler

A simple PSR-15 Request Handler implementation.  

This package is part of the Borsch Framework.

## Installation

Via [composer](https://getcomposer.org/) :

`composer require borschphp/requesthandler`

## Usage

```php
require_once __DIR__.'/vendor/autoload.php';

use Borsch\RequestHandler\RequestHandler;

$request_handler = new RequestHandler();

$request_handler->middleware(new SomeMiddleware());
$request_handler->middlewares([
    new AnotherMiddleware(),
    new YetAnotherOneMiddleware(),
    // ...
]);

$response = $request_handler->handle(ServerRequestFactory::fromGlobals());
```

## License

The package is licensed under the MIT license. See [License File](https://github.com/borschphp/borsch-requesthandler/blob/master/LICENSE.md) for more information.