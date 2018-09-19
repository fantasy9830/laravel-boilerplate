<?php

namespace App\Auth\Libraries;

class Guard
{
    protected function trimArray(array $values)
    {
        return array_map(function ($value) {
            return trim($value);
        }, $values);
    }

    protected function checkEmpty(array $values)
    {
        return count(array_filter($values, function ($value) {
            return empty($value);
        })) == 0;
    }
}
