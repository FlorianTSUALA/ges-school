<?php 

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Depense extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const PERSONNEL_ID = "personnel_id";
    const MOTIF = "motif";
    const MONTANT = "montant";
    const PIECE_JOINTES = "piece_jointes";
    const QUANTITE = "quantite";
    const DATE_ACHAT = "date_achat";

    public function __construct(){
        parent::__construct();
        $this->fillables =
        [
            new FormModel(false, 'personnel', 'Personnel'),
            new FormModel(true, self::MOTIF),
            new FormModel(true, self::MONTANT, 'Montant', InputType::NUMBER),
            // new FormModel(true, self::DATE_DEBUT, 'Date de debut', InputType::DATE),
            // new FormModel(true, self::DATE_FIN, 'Date de fin', InputType::DATE),
        ];
}
}