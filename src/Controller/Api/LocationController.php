<?php

namespace App\Controller\Api;

use App\Factories\LocationDtoFactory;
use App\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LocationController extends AbstractController
{
    public function __construct(private ProfileService $profileService)
    {
    }

    public function index()
    {

        echo 444;die;
        $profiles = $this->profileService->getList();

        return new JsonResponse(
            $profiles,
            Response::HTTP_OK
        );
    }

    public function save(Request $request)
    {
        $dto = LocationDtoFactory::create($request->toArray());
        $entity = $this->profileService->saveLocation($dto);

        return new JsonResponse($entity, Response::HTTP_OK);
    }
}
