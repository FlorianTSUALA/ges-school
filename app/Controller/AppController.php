<?php

namespace App\Controller;

use App\App;
use Core\HTML\Form\FormModel;
use Core\Controller\BaseController;

class AppController extends BaseController
{

    /**
     * Initialise les variables pour cette application
     **/
    public function __construct()
    {
        parent::__construct(App::getAppInstance());
        $this->template = 'default';
        $this->viewPath = ROOT . '/ressources/views/';
    }

    protected function fill($to_extract, $fillables){


        return array_map( function($fillable) use ($to_extract)
        {   
            if(is_array($to_extract) && count($to_extract) > 1){
                if(is_object($fillable)){
                    $fillable  = (array) $fillable;
                }
                $tmp = [];
                foreach($to_extract as $item){
                    $tmp += [$item => $fillable[$item]];
               }
                return $tmp;
            }else{
                if(is_array($to_extract))
                {
                    
                    return $fillable[$to_extract];
                }else{
                    return $fillable->{$to_extract};
                }
            } 
        }, $fillables);


    }
 
    protected function fillExternal($fillables){
        $fillables = array_filter($fillables, function($item){
            return !$item->{FormModel::INTERNAL};
        });
        
        return array_map( function($fillable)
        {   
            if(is_object($fillable)){
                $fillable  = (array) $fillable;
            }
            $tmp = ['code' => $fillable[FormModel::NAME], 'table' => $fillable[FormModel::TABLE]];
            return $tmp;
          
        }, $fillables);
    }


}