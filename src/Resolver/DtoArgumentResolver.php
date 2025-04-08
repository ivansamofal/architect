<?php

namespace App\Resolver;

use App\Dto\ProfileDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DtoArgumentResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), ProfileDto::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        try {
            $dto = $this->serializer->deserialize($request->getContent(), $argument->getType(), 'json');
        } catch (\Throwable $e) {
            throw new BadRequestHttpException('Ошибка формата JSON: '.$e->getMessage());
        }

        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }

            $json = json_encode($errorMessages, JSON_UNESCAPED_UNICODE);

            throw new \RuntimeException($json);

        }

        yield $dto;
    }
}
