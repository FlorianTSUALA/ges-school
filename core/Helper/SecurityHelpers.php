<?php

namespace Core\Helper;

trait SecurityHelpers
{

    public static function passwordEncrypt($password){
        return sha1($password);
    }

    public static function crypted($string)
    {
        return md5(
            sha1(
                md5(
                    base64_encode(
                        base64_encode(
                            base64_encode($string)
                        )
                    )
                )
            )
        );
    }

    public static function encodeURL($url)
    {
        return base64_encode(
            base64_encode(
                base64_encode(
                    base64_encode(
                        base64_encode(
                            $url
                        )
                    )
                )
            )
        ) ;
    }


    public static function decodeURL($url)
    {
        return base64_decode(
            base64_decode(
                base64_decode(
                    base64_decode(
                        base64_decode(
                            $url
                        )
                    )
                )
            )
        ) ;
    }

    public static function encodeFileText($text)
    {
        return base64_encode(
            base64_encode(
                base64_encode(
                    base64_encode(
                        base64_encode(
                            $text
                        )
                    )
                )
            )
        ) ;
    }

    public static function decodeFileText($text)
    {
        return base64_decode(
            base64_decode(
                base64_decode(
                    base64_decode(
                        base64_decode(
                            $text
                        )
                    )
                )
            )
        ) ;
    }



}