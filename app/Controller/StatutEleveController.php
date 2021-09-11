<?php

namespace App\Controller;
    
use App\Model\Cycle;
use App\Model\Eleve;
use App\Model\DBTable;
use App\Model\Parcours;
use Core\Session\Request;
use App\Model\StatutEleve;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;
use App\Repository\StatutEleveRepository;
use App\Repository\AnneeScolaireRepository;

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
    
    public function actualiser_statut($annee_scolaire_id){
        (new StatutEleveRepository())->actualiser_statut( $annee_scolaire_id);
    } 
    
    /**
     * actualise le statut de l'élève (ancien, nouveau, démissionnaire, fin de cycle) au cours d'une année scolaire donnée
     *
     * @param [staut_eleve_id, eleve_id] $eleve
     * @param [type] $annee_scolaire_id
     * @return void
     */
    public function actualiser_statut_eleve($eleve, $annee_scolaire_id){
        (new StatutEleveRepository())->actualiser_statut_eleve($eleve, $annee_scolaire_id);
    } 

}