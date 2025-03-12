<?php
declare(strict_types=1);

use App\Controller\Api\ReviewController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->add(
        'api_v1_reviews',
        '/api/v1/reviews'
    )
        ->controller([ ReviewController::class, 'index' ])
        ->methods([ 'GET' ]);

    $routes->add(
        'api_v1_reviews_add',
        '/api/v1/reviews'
    )
        ->controller([ ReviewController::class, 'create' ])
        ->methods([ 'POST' ]);

};
