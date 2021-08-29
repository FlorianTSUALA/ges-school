<?php

namespace App\Model;

use App\Model\Classe;
use Core\Model\Model;
use App\Model\TypePension;
use App\Model\TrancheScolaire;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use App\Model\FrequentlyReapeat;
use Core\Model\HydrahonModel;

class PensionClasse extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const TYPE_PENSION_ID = "type_pension_id";
    const Classe_ID = "classe_id";
    const TRANCHE_SCOLAIRE_ID = "tranche_scolaire_id";
    const MONTANT = "montant";
    const OPTIONNEL = "optionnel";
    const MENTUALITE = "mensualite";
    const EST_MENSUEL = "est_mensuel";


    public function __construct()
    {

        $type_pensions = TypePension::table()->select(['code' => 'id', 'libelle' => 'value'])->where('visibilite', 1)->get();
        $tranche_scolaires = TrancheScolaire::table()->select(['code' => 'id', 'libelle' => 'value'])->where('visibilite', 1)->get();
        $classes = Classe::table()->select(['code' => 'id', 'libelle' => 'value'])->where('visibilite', 1)->get();

        $this->fillables =
            [
                new FormModel(false, self::TYPE_PENSION_ID, 'Type de pension', InputType::SELECT2, $type_pensions, '', 'Choisir une pension', true, 'select2 form-control'),
                new FormModel(false, self::Classe_ID, 'Classe', InputType::SELECT2, $classes, '', 'Choisir une classe', true, 'select2 form-control'),
                new FormModel(false, self::TRANCHE_SCOLAIRE_ID, 'Tranche Scolaire', InputType::SELECT2, $tranche_scolaires, '', 'Choisir une tranche', true, 'select2 form-control'),
                // new FormModel(true, self::LIBELLE ),    
                // new FormModel(true, self::CODE ,'Code', InputType::TEXT ),
                new FormModel(true, self::MONTANT, 'Montant', InputType::NUMBER),
                // new FormModel(true, self::OPTIONNEL, self::OPTIONNEL, InputType::RADIO, [['id'=>'1', 'value'=>'Oui'], ['id'=>'0', 'value'=>'Non']]),
                //  new FormModel(true, self::EST_MENSUEL, 'Est mensuel ?', InputType::RADIO, [['id'=>'1', 'value'=>'Oui'], ['id'=>'0', 'value'=>'Non']]),
                // new FormModel(true, self::MENTUALITE ,'Mensualité',InputType::NUMBER ),
            ];
    }
}
