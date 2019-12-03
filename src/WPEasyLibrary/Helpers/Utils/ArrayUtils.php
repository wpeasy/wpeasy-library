<?php


namespace WPEasyLibrary\Helpers\Utils;


class ArrayUtils
{

    static function attributesArraygetDefaults($arr)
    {
        $callback = function ($value) { return $value['default']; };
        return array_map( $callback , $arr);;
    }
}