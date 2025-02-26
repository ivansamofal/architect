<?php

namespace App\Infrastructure\Traits;

use App\Infrastructure\Interfaces\ArrayableInterface;

trait ArrayableTrait
{
    public function toArray(): array
    {
        $data = [];
        foreach (get_class_vars(get_class($this)) as $name => $v) {
            $value = $this->$name;
            if (is_object($value)) {
                $array = $value->toArray();
//                foreach ($array as $item) {
//                    $data[$name] = $item->toArray();
//                }
//                if ($value instanceof ArrayableInterface) {
//                    var_dump($value->toArray());die;
//                    $data[$name] = $value->toArray();
//                }
            } else {
                if (!in_array($name, ['email', 'password'])) {
                    $data[$name] = $value;
                }
            }
        }

        return $data;
    }
}
