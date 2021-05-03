<?php

namespace Core\Helper;

trait RequestHelpers
{

    public static function getValidRequestInput($field, $requestType = "GET")
    {
        switch($requestType){
            case REQUEST_POST:
                return isset($_POST[$field])? self::stringProtected($_POST[$field]) : NULL;
            break;
            case REQUEST_GET:
                return isset($_GET[$field])? self::stringProtected($_GET[$field]) : NULL;
            break;
            default:
                return NULL;
        }
    }


    function json_encode_unicode($data)
    {
        return preg_replace_callback('/(?<!\\\\)\\\\u([0-9a-f]{4})/i',
        function ($matches) {
            $d = pack("H*", $matches[1]);
            return mb_convert_encoding($d, "UTF-8", "UTF-16BE");
        }, json_encode($data)
        );
    }

}