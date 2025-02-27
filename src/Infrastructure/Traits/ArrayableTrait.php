<?php

namespace App\Infrastructure\Traits;

trait ArrayableTrait
{
    public function toArray(): array
    {
        $data = [];
        foreach (get_class_vars(get_class($this)) as $name => $v) {
            $value = $this->$name;
            if (is_object($value)) {
                $array = $value->toArray();//todo
            } else {
                if (!in_array($name, ['email', 'password'])) {
                    $data[$name] = $value;
                }
            }
        }

        return $data;
    }
}
