<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\Model\HydrahonModel;

class GroupeFamilial extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const REFENCE = 'reference';
    
    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(true, self::LIBELLE),
                new FormModel(true, self::REFENCE),
                new FormModel(true, self::DESCRIPTION),
            ];
    }
}