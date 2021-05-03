<?php

namespace Core\Session;


class InputRequestControl
{

  

    public static function stringProtected($string)
    {
        return trim(htmlspecialchars($string));
    }

    public static function validRequestInput($field, $requestType = "GET")
    {
        switch($requestType){
            case "POST":
                return isset($_POST[$field])? self::stringProtected($_POST[$field]) : NULL;
            break;
            case "GET":
                return isset($_GET[$field])? self::stringProtected($_GET[$field]) : NULL;
            break;
            default:
                return NULL;
        }
    }

    public static function getValidRequestInput($field)
    {
        return isset($_GET[$field])? self::stringProtected($_GET[$field]) : NULL;
    }
    
    public static function postValidRequestInput($field, $requestType = "GET")
    {
        switch($requestType){
            case "POST":
                return isset($_POST[$field])? self::stringProtected($_POST[$field]) : NULL;
            break;
            case "GET":
                return isset($_GET[$field])? self::stringProtected($_GET[$field]) : NULL;
            break;
            default:
                return NULL;
        }
    }

    public static function stringProtectedUcword($string)
    {
        return trim(htmlspecialchars(ucwords(mb_strtolower($string))));
    }

    public static function stringProtectedLower($string)
    {
        return trim(htmlspecialchars(mb_strtolower($string)));
    }

    public static function stringProtectedUpper($string)
    {
        return trim(htmlspecialchars(mb_strtoupper($string)));
    }


}

