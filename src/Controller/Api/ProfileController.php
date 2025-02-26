<?php

namespace App\Controller\Api;

use App\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ProfileController extends AbstractController
{
    public function __construct(private ProfileService $profileService)
    {
    }

    public function index()
    {
        $profiles = $this->profileService->getList();

        return new JsonResponse(
            $profiles,
            Response::HTTP_OK
        );
    }

    /**
     *
     * #[Route('/profiles/{id}')]
     */
    public function get($id): JsonResponse
    {
        $profile = $this->profileService->find($id);

        return new JsonResponse(
            $profile ? current($profile) : (object)[],
            Response::HTTP_OK
        );
    }

    /**
     *
     * #[Route('/profiles')]
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $profile = $this->profileService->createProfile($data);

        return new JsonResponse(['id' => $profile->getId()], 201);
    }
}
