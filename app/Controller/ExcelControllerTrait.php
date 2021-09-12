<?php

namespace App\Controller;


// use App\Controller\Admin\AppController;
// https://jsfiddle.net/GlennSuperdude/4u6xp3t3/88
// https://github.com/tabalinas/jsgrid

trait ExcelControllerTrait
{
 
       function round_up($value, $places)
       {
           $mult = pow(10, abs($places));
           return $places < 0 ?
           ceil($value / $mult) * $mult :
               ceil($value * $mult) / $mult;
       }
    

       function salleDeClasseToClass( $salle_classe)
       {
        return substr( $salle_classe,0,-1);
       }
       
}
