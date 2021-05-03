<?php 

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class DossierMedical extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;   
    
    const ALLERGIE = "allergie";
    const GROUPE_SANGUIN = "groupe_sanguin";
    const PROBLEME_PARTICULIER = "probleme_particulier";
    const MALADIE_RECURRENTE = "maladie_recurrente";
    const NOM_MEDECIN = "nom_medecin";
    const TELEPHONE_MEDECIN = "telephone_medecin";
    const EMAIL_MEDECIN = "email_medecin";
    const AUTRES = "autres";

    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(true, self::ALLERGIE ),
                new FormModel(true, self::GROUPE_SANGUIN , 'Groupe sanguin', InputType::TEXT),
                new FormModel(true, self::PROBLEME_PARTICULIER,'Problème particulier',InputType::TEXT ),
                new FormModel(true, self::MALADIE_RECURRENTE,'Maladie recurrente',InputType::TEXT ),
                new FormModel(true, self::NOM_MEDECIN,'Nom du médecin',InputType::TEXT ),
                new FormModel(true, self::TELEPHONE_MEDECIN , 'Téléphone du médecin', InputType::TEL),
                new FormModel(true, self::EMAIL_MEDECIN , 'email médecin', InputType::EMAIL),
                new FormModel(true, self::AUTRES ),

            ];

    }
}