<?php

namespace App\Controller\Api;

use App\Decorator\TraceableProfileService;
use App\Exceptions\UserNotCreatedException;
use App\Service\ProfileService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends AbstractController
{
    public function __construct(
//        private readonly ProfileService $profileService,
        private readonly TraceableProfileService $profileService,
        private readonly LoggerInterface $logger,
    )
    {
    }

    public function index(): JsonResponse
    {
        try {
            $profiles = $this->profileService->getList();
            return $this->json($profiles);
        } catch (\Throwable $e) {
            $message = "Error in profiles list endpoint. Cause: {$e->getMessage()}";
            $this->logger->error($message);

            return $this->json(['message' => $message]);
        }
    }

    /**
     *
     * #[Route('/profiles/{id}')]
     */
    public function get(int $id): JsonResponse
    {
        $profile = $this->profileService->find($id);

        return $this->json($profile);
    }

    /**
     *
     * #[Route('/profiles')]
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $profile = $this->profileService->createProfile($data);

            return new JsonResponse(['id' => $profile->getId()], 201);
        } catch (UserNotCreatedException $e) {
            return new JsonResponse(['message' => $e->getMessage()], 500);
        }
    }
}
