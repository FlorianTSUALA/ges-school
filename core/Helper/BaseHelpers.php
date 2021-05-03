<?php

namespace Core\Helper;

use stdClass;

class BaseHelpers
{

use DateHelpers, HelpersBusinessLogic, HTMLHelper, RequestHelpers, SecurityHelpers, SessionHelpers, StrHelpers, DebugHelpers, DBHelpers ;

    public static function generateReference(){
        return strtoupper(substr(md5(microtime()), 0, 10)); 
        /*
        $length = 10;
        $str = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        echo uniqid();
        echo substr(str_shuffle($str), 0, $length);
        echo substr(md5(microtime()), 0, 8); */
        
    }



    //echo random_code(8);
    function randomCode($limit)
    {
        return strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit));
    }
 
 
    public static function toJSONString($value, $isAsssoc= true){
        return json_decode(json_encode($value), $isAsssoc  );
    }

    public static function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    // Don't change
    public static function toJSON($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public static function toJSON2($data)
    {

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        // return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($data));
        // return json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    }


    public static function object_to_array($obj) {
        if(is_object($obj)) $obj = (array)($obj);
        if(is_array($obj)) {
            $new = array();
            foreach($obj as $key => $val) {
                $new[$key] =  self::object_to_array($val);
            }
        }
        else $new = $obj;
        return $new;       
    }


    /**
     * UTF8 de- oder en-codes a total Object/Array.
     * WARNING: De-/Encodes Only the Values, not the keys!
     * @version 17.07.2015 NS:  Created
     * @version 17.02.2016 NS:  html_entity_decode/preg_replace, $b_entity_replace inserted!
     *                          -> Now undefined ISO characters get replaced by its entities when decoding UTF-8 and vice versa.
     * @version 01.03.2016 NS: WARNING: This function does not work for SimpleXMLElement's
     *
     * @param mixed $input          The Input (Array/Object/String-Mix)
     * @param bool  $b_encode           enocde or decode?
     * @param bool  $b_entity_replace   New parameter to define, whether its ok to replace entities.
     *                                  -> There is barely no reason to set this to FALSE except it does not work or takes too much time, no errors found, yet.
     *
     * @return mixed    The de-/encoded Object-/Array-/String- value.
     */
    static function utf8_code_deep($input, $b_encode = TRUE, $b_entity_replace = TRUE)
    {
        if (is_string($input))
        {
            if($b_encode)
            {
                $input = utf8_encode($input);

                    //return Entities to UTF8 characters
                    //important for interfaces to blackbox-pages to send the correct UTF8-Characters and not Entities.
                    if($b_entity_replace)
                    {
                        $input = html_entity_decode($input, ENT_NOQUOTES/* | ENT_HTML5*/, 'UTF-8'); //ENT_HTML5 is a PHP 5.4 Parameter.
                    }
            }
            else
            {
                //Replace NON-ISO Characters with their Entities to stop setting them to '?'-Characters.
                if($b_entity_replace)
                {
                    $input = preg_replace("/([\304-\337])([\200-\277])/e", "'&#'.((ord('\\1')-192)*64+(ord('\\2')-128)).';'", $input);
                }

                $input = utf8_decode($input);
            }
                return $input;
        }
        elseif (is_array($input))
        {
            foreach ($input as &$value)
            {
                $value = self::utf8_code_deep($value, $b_encode, $b_entity_replace);
            }
            return $input;
        }
        elseif (is_object($input) )
        {
            if(! $input instanceof stdClass )
                foreach ($input as $k=>$val)
                    $input->$k = self::utf8_code_deep($input->$k, $b_encode, $b_entity_replace);
            return $input;
        }
        }
    }