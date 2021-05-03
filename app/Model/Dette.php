<?php 

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Dette extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const MOTIF = "motif";
    const MONTANT = "montant";
    const DATE_EMPRUNT = "date_emprunt";
    const DATE_LIMITE = "date_emprunt";
    const MONTANT_INTERET = "montant_interet";

    public function __construct(){
        parent::__construct();
        $this->fillables =
        [
            new FormModel(true, self::MOTIF, 'Motif'),
        new FormModel(true, self::MONTANT, 'Montant', InputType::NUMBER),
        new FormModel(true, self::DATE_EMPRUNT, 'Date de l\'emprunt', InputType::DATE),
        new FormModel(true, self::DATE_LIMITE, 'Date limite', InputType::DATE),
        ];

    }
}