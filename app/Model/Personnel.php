<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Personnel extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const TYPE_PERSONNEL_ID = "type_personnel_id";
    const PAYS_ID = "pays_id";
    const NOM = "nom";
    const PRENOM = "prenom";
    const SEXE = "sexe";
    const PHOTO = "photo";
    const TELEPHONE = "telephone";
    const EMAIL = "email";
    const ADRESSE = "adresse";
    const LOGIN = "login";
    const PASSWORD = "password";
    const DATE_PRISE_SERVICE = "date_prise_service";
    const DATE_FIN_CARRIERE = "date_fin_carriere";
    const BIBLIOGRAPHIE = "bibliographie";
    const ASSURANCE = "assurance";
    const PIECE_JOINTES = "piece_jointes";

    public function __construct(){
        parent::__construct();
        
        $type_personnels = TypePersonnel::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        $pays = Pays::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        
        $this->fillables =
            [
                new FormModel(false, self::TYPE_PERSONNEL_ID,'Type de personnel', InputType::SELECT2, $type_personnels, '', 'Choisir un type de personnel', true, 'select2 form-control'),
                new FormModel(false, self::PAYS_ID,'Pays d\'origine', InputType::SELECT2, $pays, '', 'Choisir un pays', true, 'select2 form-control'),
                new FormModel(true, self::NOM ),
                new FormModel(true, self::PRENOM, 'Prénom', null, null, null, null, false),
                new FormModel(true, self::SEXE,"Civilité", InputType::RADIO, [['id'=>'F', 'value'=>'Madame'], ['id'=>'H', 'value'=>'Monsieur']]  ),
                new FormModel(true, self::PHOTO, 'Photo de profil', InputType::TEXT, null, null, null, false),
                new FormModel(true, self::TELEPHONE,'Téléphone', InputType::NUMBER, null, null, null, false),
                new FormModel(true, self::EMAIL,'Email', InputType::EMAIL, null, null, null, false ),
                new FormModel(true, self::ADRESSE, 'Adresse', null, null, null, null, false ),
                new FormModel(true, self::LOGIN, 'Login', null, null, null, null, false ),
                new FormModel(true, self::PASSWORD, 'Mot de passe', InputType::PASSWORD, null, null, null, false),
                new FormModel(true, self::DATE_PRISE_SERVICE , 'Date de prise de service', InputType::DATE, null, null, null, false),
                new FormModel(true, self::DATE_FIN_CARRIERE,'Date de fin de carrière', InputType::DATE, null, null, null, false ),
                new FormModel(true, self::BIBLIOGRAPHIE, 'Bibliographie', null, null, null, null, false ),
                new FormModel(true, self::ASSURANCE, 'Assurance', null, null, null, null, false ),
                new FormModel(true, self::PIECE_JOINTES, 'Pieces jointes', null, null, null, null, false ),

            ];

    }

    
    public static function getColumns()        
    {
        $columns = '';
        $columns .= '{ "data": "id" },';
        // $columns .= '{ "data": "num" },';
        $columns .= '{ "data": "nom_complet" },';
        $columns .= '{ "data": "fonction" },';
        $columns .= '{ "data": "telephone" },';
        // $columns .= '{ "data": "sexe" },';
        // $columns .= '{ "data": "email" },';
        $columns .= '{ "data": null }';
        return $columns;
    }
}