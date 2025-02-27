<?php
declare(strict_types=1);

use App\Controller\Api\BookController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->add(
        'api_v1_authors',
        '/api/v1/authors'
    )
        ->controller([ BookController::class, 'authorsList' ])
        ->methods([ 'GET' ]);

    $routes->add(
        'api_v1_books_id',
        '/api/v1/books/{authorId}'
    )
        ->controller([ BookController::class, 'getBooksByAuthor' ])
        ->methods([ 'GET' ]);

};
