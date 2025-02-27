<?php

namespace App\Factories;

use App\Dto\LocationDto;

class LocationDtoFactory
{
    public static function create(array $data): LocationDto
    {
        $dto = new LocationDto();
        foreach ($data as $property => $value) {
            if (property_exists($dto, $property)) {
                $dto->$property = $value;
            }
        }

        return $dto;
    }
}
