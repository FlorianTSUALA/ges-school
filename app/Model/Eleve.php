<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use Core\Model\HydrahonModel;

class Eleve extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const DOSSIER_MEDICAL_ID = "dossier_medical_id";
    const PAYS_ID = "pays_id";
    const GROUPE_FAMILIAL_ID = "groupe_familial_id";
    const DOSSIER_PARENTAL_ID = "dossier_parental_id";
    const ANTECEDENT_SCOLAIRE_ID = "antecedent_scolaire_id";
    const STATUT_ELEVE_ID = "statut_eleve_id";
    const MATRICULE = "matricule";
    const NOM = "nom";
    const PRENOM = "prenom";
    const SURNOM = "surnom";
    const SEXE = "sexe";
    const DATE_NAISSANCE = "date_naissance";
    const LIEU_NAISSANCE = "lieu_naissance";
    const PHOTO = "photo";
    const ANCIENNETE = "anciennete";


    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(false, 'dossier_medical','Dossier médical'),
                new FormModel(false, self::PAYS_ID, 'Pays'),
                new FormModel(false, self::GROUPE_FAMILIAL_ID, 'Groupe familial'),
                new FormModel(false, 'dossier_parental','Dossier parental'),
                new FormModel(false, 'antecedent_scolaire','Antécédent scolaire' ),
                new FormModel(true, self::MATRICULE, 'Matricule', null, null, null, null, false),
                new FormModel(true, self::NOM),
                new FormModel(true, self::PRENOM),
                new FormModel(true, self::SURNOM),
                new FormModel(true, self::SEXE),
                new FormModel(true, self::DATE_NAISSANCE ,'Date de naissance',InputType::DATE ),
                new FormModel(true, self::LIEU_NAISSANCE , 'Lieu de naissance', InputType::TEXT),
                new FormModel(true, self::PHOTO),

            ];

    }

   public static function getColumns($table_name = 'tout_eleve')
    {
      $columns = '';
      switch($table_name){
        case 'tout_eleve':
          $columns .= '{ "data": "id" },';
          $columns .= '{ "data": "nom_complet" },';
          $columns .= '{ "data": "sexe" },';
          $columns .= '{ "data": "salle_classe" },';
          $columns .= '{ "data": "date_naissance" },';
          $columns .= '{ "data": "statut_eleve" },';
          // $columns .= '{ "data": "photo" },';
          // $columns .= '{ "data": "lieu_naisance" },';
          $columns .= '{ "data": null }';
        break;
        
        case 'table_eleve_inscrit':
          $columns .= '{ "data": "id" },';
          $columns .= '{ "data": "nom_complet" },';
          $columns .= '{ "data": "classe" },';
          $columns .= '{ "data": "surnom" },';
          $columns .= '{ "data": "sexe" },';
          $columns .= '{ "data": "date_naissance" },';
          $columns .= '{ "data": "statut_eleve" },';
          // $columns .= '{ "data": "photo" },';
          // $columns .= '{ "data": "lieu_naisance" },';
          $columns .= '{ "data": null }';
        break;
        
        case 'table_eleve_non_inscrit':
          $columns .= '{ "data": "id" },';
          $columns .= '{ "data": "matricule" },';
          $columns .= '{ "data": "nom_complet" },';
          $columns .= '{ "data": "surnom" },';
          $columns .= '{ "data": "sexe" },';
          $columns .= '{ "data": "date_naissance" },';
          // $columns .= '{ "data": "photo" },';
          // $columns .= '{ "data": "lieu_naisance" },';
          $columns .= '{ "data": null }';
        break;
        
        case NULL:
          $columns .= '{ "data": "id" },';
          $columns .= '{ "data": "matricule" },';
          $columns .= '{ "data": "nom_complet" },';
          $columns .= '{ "data": "surnom" },';
          $columns .= '{ "data": "sexe" },';
          $columns .= '{ "data": "date_naissance" },';
          // $columns .= '{ "data": "photo" },';
          // $columns .= '{ "data": "lieu_naisance" },';
          $columns .= '{ "data": null }';
        break;

      }
      return $columns;
    }


    public static function get_parcours_eleve($id_eleve)
    {
      $parcours_classe_eleve = DBTable::getModel('salle_classe')->select(['salle_classe.libelle'=>'libelle', 'salle_classe.id' => 'classe_id'])
                ->join('parcours', 'salle_classe.id', '=', 'parcours.salle_classe_id')
                ->where('parcours.visibilite', '=', 1)
                ->where('salle_classe.visibilite', '=', 1)
                ->where('parcours.eleve_id', '=', $id_eleve)
                ->orderBy('parcours.id', 'DESC')
                ->get();

      if (!empty($parcours_classe_eleve)) {
        return $parcours_classe_eleve[0];
      }
      else {
        return array();
      }
    }

    
}
