<?php

namespace Core\Helper;

trait StrHelpers
{

    // returns true if $needle is a substring of $haystack
    public static function contains($needle, $haystack)
    {
        return strpos($haystack, $needle) !== false;
    }
    /*
    $tests = array(
        'simpleTest' => 'simple_test',
        'easy' => 'easy',
        'HTML' => 'html',
        'simpleXML' => 'simple_xml',
        'PDFLoad' => 'pdf_load',
        'startMIDDLELast' => 'start_middle_last',
        'AString' => 'a_string',
        'Some4Numbers234' => 'some4_numbers234',
        'TEST123String' => 'test123_string',
      );
      
      foreach ($tests as $test => $result) {
        $output = from_camel_case($test);
        if ($output === $result) {
          echo "Pass: $test => $result\n";
        } else {
          echo "Fail: $test => $result [$output]\n";
        }
      }

        Pass: simpleTest => simple_test
        Pass: easy => easy
        Pass: HTML => html
        Pass: simpleXML => simple_xml
        Pass: PDFLoad => pdf_load
        Pass: startMIDDLELast => start_middle_last
        Pass: AString => a_string
        Pass: Some4Numbers234 => some4_numbers234
        Pass: TEST123String => test123_string
      */
    public static function toCamelCase($input) {
        /*preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
          $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);*/
        return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $input));
    }

    public static function toUpper($input) {
        return strtoupper($input) ;
    }

    public static function toPascalCase($word) {
        return $word = preg_replace_callback(
            "/(^|_)([a-z])/",
            function($m) { return strtoupper("$m[2]"); },
            $word
        );
    
    } 

    public static function getRandomString($length = 8) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
    
        return $string;
    }

    // Exemple (a, 2) => c
    // Exemple (c, 1) => d
    public static function getIncCharacter($character, $inc){
        return chr(ord($character)+$inc);
    }


    public static function swap(&$a, &$b)
    {
        $tmp = $a;
        $a = $b;
        $b = $tmp;
    }


}