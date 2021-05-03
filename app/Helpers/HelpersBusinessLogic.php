<?php

namespace App\Helpers;

trait HelpersBusinessLogic
{
    public static function genMatricule($length=6)
    {
        return  Date('y').Helpers::getRandomString($length);
    }

    public static function calcAge($length=6)
    {
        return  Date('y').Helpers::getRandomString($length);
    }
}