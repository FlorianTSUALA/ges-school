<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;        
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class AntecedentScolaire extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const CLASSE = "classe";
    const TELEPHONE = "telephone";
    const EMAIL = "email";
    const ECOLE = "ecole";

    public function __construct(){
        parent::__construct();
        $this->fillables =
        [
            new FormModel(true,self::CLASSE),
            new FormModel(true,self::TELEPHONE, 'Téléphone', InputType::NUMBER),
            new FormModel(true,self::EMAIL, 'Email', InputType::EMAIL),
            new FormModel(true,self::ECOLE),

        ];


}
}
