<?php

namespace Core\Helper;

trait DBHelpers{

    /**
     * https://stackoverflow.com/questions/7574857/group-array-by-subarray-values 
     * 
     * Group items from an array together by some criteria or value.
     *
     * @param  $arr array The array to group items from
     * @param  $criteria string|callable The key to group by or a function the returns a key to group by.
     * @return array
     *
     */
    public static function groupBy(&$arr, $criteria): array
    {
        $temp = array_reduce($arr, function($accumulator, $item) use ($criteria) {
            $key = (is_callable($criteria)) ? $criteria($item) : $item[$criteria];
            if (!array_key_exists($key, $accumulator)) {
                $accumulator[$key] = [];
            }

            array_push($accumulator[$key], $item);
            return $accumulator;
        }, []);
    
        $arr = $temp;
        return $temp;
    }
}