<?php

namespace App\Factories;

use App\Dto\LocationDto;

class LocationDtoFactory
{
    public static function create(array $data): LocationDto
    {
//        var_dump($data);die;
        $dto = new LocationDto();
        foreach ($data as $property => $value) {
//            var_dump($property);
//            var_dump($value);
//            var_dump(property_exists($dto, $property));die;
            if (property_exists($dto, $property)) {
                $dto->$property = $value;
            }
        }

        return $dto;
    }
}
