<?php
declare(strict_types=1);

use App\Controller\Api\BookController;
use App\Controller\Api\ProfileController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->add(
        'api_v1_books/test',
        '/api/v1/books'
    )
        ->controller([ BookController::class, 'test' ])
        ->methods([ 'GET' ]);

    $routes->add(
        'api_v1_books/load',
        '/api/v1/books/load'
    )
        ->controller([ \App\Controller\Api\BookController::class, 'load' ])
        ->methods([ 'GET' ]);

};
