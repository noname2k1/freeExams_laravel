<?php
namespace App\Helpers;

class helpers {
    public static function array_find($array, $key, $value) {
        foreach ($array as $item) {
            if (isset($item[$key]) && $item[$key] == $value) {
                return $item;
            }
        }
        return false;
    }
}