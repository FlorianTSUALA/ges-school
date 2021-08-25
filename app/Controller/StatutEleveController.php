<?php

namespace App\Controller;
    
use App\Model\DBTable;
use Core\Session\Request;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;
use App\Model\Parcours;

class StatutEleveController extends AppController
{
    use TraitCRUDController;

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('statut_eleve');

        $this->vairant = DBTable::STATUT_ELEVE;
        $this->folder_view_index = 'statut_eleve.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'statut_eleve';
        $this->class_name = 'statut_eleve';

        $this->title_page = 'Gestion des statuts eleves - Ges-School';
        $this->title_home = 'Gestion des statuts eleves';
        $this->create_title = "Creation d'un statut eleve";
        $this->view_title = "Information d'un statut eleve";
        $this->update_title = "Mise à jour d'un statut eleve";
        $this->delete_title = "Suppression d'un statut eleve";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce statut eleve ";
    }
    
    public function actualiserstatut($eleve_id, $annee_scolaire_id){
      
        $eleve_affecte = Parcours::table()
      ->select(
      [
          'classe.libelle' => 'classe',           
          'classe.id' => 'classe_id',           
          'statut_eleve.id' => 'statut_eleve_id',
          'statut_eleve.libelle' => 'statut_eleve',
          'parcours.annee_scolaire_id' => 'annee_scolaire_id',
          'annee_scolaire.libelle' => 'annee_scolaire',
      ])
  ->join('classe', 'classe.id', '=', 'parcours.classe_id')
  ->join('eleve', 'eleve.id', '=', 'parcours.eleve_id')
  ->join('annee_scolaire', 'annee_scolaire.id', '=', 'parcours.annee_scolaire_id')
  ->join('statut_eleve', 'eleve.statut_eleve_id', '=', 'statut_eleve.id')
  ->where('parcours.visibilite', 1)
  ->where('parcours.eleve_id',$annee_scolaire_id)
  ->orderBy('parcours.annee_scolaire_id')
  ->get();
    } 

}