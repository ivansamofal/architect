<?php
declare(strict_types=1);

use App\Controller\Api\AuthController;
use App\Controller\IndexController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->add('home', '/')
        ->controller([ IndexController::class, 'index' ]);

    $routes->add('api/login', '/api/login')
        ->controller([ AuthController::class, 'login' ])
        ->methods(['POST']);

    $routes->import('routes/profile_routes.php');
    $routes->import('routes/location_routes.php');
    $routes->import('routes/book_routes.php');
    $routes->import('routes/review_routes.php');
};
