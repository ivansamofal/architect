<?php
declare(strict_types=1);

use App\Controller\Api\LocationController;
use App\Controller\Api\ProfileController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes): void {
    $routes->add(
        'api_v1_location_save',
        '/api/v1/location'
    )
        ->controller([ LocationController::class, 'save' ])
        ->methods([ 'POST' ]);
};
