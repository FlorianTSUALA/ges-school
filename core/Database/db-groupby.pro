<?php


$arr = array(
    'a' => array ( 'id' => 20, 'name' => 'chimpanzee' ),
    'b' => array ( 'id' => 40, 'name' => 'meeting' ),
    'c' => array ( 'id' => 20, 'name' => 'dynasty' ),
    'd' => array ( 'id' => 50, 'name' => 'chocolate' ),
    'e' => array ( 'id' => 10, 'name' => 'bananas' ),
    'f' => array ( 'id' => 50, 'name' => 'fantasy' ),
    'g' => array ( 'id' => 50, 'name' => 'football' )
);

$q = groupBy($arr, 'id');
// print_r($q);

$r = groupBy($arr, function($item) {
    return $item['id'];
});
print_r($r);

