<?php

namespace Core\Helper;

use App\Model\FrequentlyReapeat;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;

trait HTMLHelper
{
    public static $COLORS = [
        '#2D95BF',
        '#48CFAE',
        '#50C1E9',
        '#FB6E52',
        '#ED5564',
        '#F8B195',
        '#6C5B7B',
        '#355C7D',
        '#547A8B',
        '#3EACAB',
        '#2D95BF'
    ];


    public static function getRandomBootstrapColor($with_light_color = false){
        $arrX = array("warning", "info","success", "danger", "primary", "dark");
        if($with_light_color)
            $arrX += array('light');

        // get random index from array $arrX
        $randIndex = array_rand($arrX);
        // output the value for the random index
        return $arrX[$randIndex];
    }

    public static function getRandomAnimation($with_light_color = false){
        $arrX = array("slideInDown", "zoomIn", "fadeInDown", "slideInUp", "zoomInLeft", "fadeInLeft");
        
        // get random index from array $arrX
        $randIndex = array_rand($arrX);
        // output the value for the random index
        return $arrX[$randIndex];
    }


   public static function repeatChar($char = "*", $nbre = 10)
    {
        return str_repeat($char, $nbre);
    }



}