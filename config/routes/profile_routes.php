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

//    $routes->add(
//        'api_v1_business_case_complete_project_extra',
//        '/api/v1/investment-project/{id}/v{version}/business-case/complete-project-extra'
//    )
//        ->controller([ CompleteProjectApiController::class, 'extra' ])
//        ->methods([ 'GET' ]);
//
//    $routes->add(
//        'api_v1_business_case_revenue_card_blocks_fetch',
//        '/api/v1/investment-project/{id}/v{version}/opex-card-blocks'
//    )
//        ->controller([ B2cCommonParametersApiController::class, 'projectRevenueOpexCardBlocks' ])
//        ->methods([ 'GET' ]);
//
//    $routes->add(
//        'api_v1_business_case_revenue_card_blocks_save',
//        '/api/v1/investment-project/{id}/v{version}/opex-card-blocks'
//    )
//        ->controller([ B2cCommonParametersApiController::class, 'changeProjectRevenueOpexCardBlocks' ])
//        ->methods([ 'PUT' ]);
//
//    $routes->add(
//        'api_v1_business_case_revenue_other_services_opex_save_default_project',
//        '/api/v1/investment-project/{id}/v{version}/business-case/revenue/other-services/opex/default'
//    )
//        ->controller([ B2cSavedOpexApiController::class, 'putDefaultProject' ])
//        ->methods([ 'PUT' ]);
//
//    $routes->add(
//        'api_v1_business_case_revenue_other_services_opex_delete_default_project',
//        '/api/v1/investment-project/{id}/v{version}/business-case/revenue/other-services/opex/default'
//    )
//        ->controller([ B2cSavedOpexApiController::class, 'deleteDefaultProject' ])
//        ->methods([ 'DELETE' ]);
};
