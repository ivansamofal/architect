<?php
declare(strict_types=1);

use App\Controller\Api\ProfileController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->add(
        'api_v1_profiles_list',
        '/api/v1/profiles'
    )
        ->controller([ ProfileController::class, 'index' ])
        ->methods([ 'GET' ]);

    $routes->add(
        'api_v1_profile_page',
        '/api/v1/profiles/{id}'
    )
        ->controller([ ProfileController::class, 'get' ])
        ->methods([ 'GET' ]);

    $routes->add(
        'api_v1_profile_create',
        '/api/v1/profiles'
    )
        ->controller([ ProfileController::class, 'create' ])
        ->methods([ 'POST' ]);
};
