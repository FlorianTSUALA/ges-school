<?php

namespace App\Controller;

use App\Model\DBTable;
use App\Controller\Admin\AppController;
use EleveRepository;

class IntegrationEleveController extends AppController
{

    
    private $eleve_repository;

    public function __construct()
    {
        parent::__construct();
        /*
            Provide from inscription
            Begin
        */  
        
        parent::__construct();
        $this->loadModel('pays');
        $this->loadModel('statut_eleve');
        $this->loadModel('classe');
        $this->loadModel('salle_classe');
        $this->loadModel('annee_scolaire');

        $this->loadModel('dossier_parental');
        $this->loadModel('dossier_medical');
        $this->loadModel('antecedent_scolaire');
        $this->loadModel('eleve');
        $this->loadModel('parcours');
    
        
        /*
            Provide from inscription
            End
        */
        
        $this->eleve_repository = new EleveRepository();

        $this->vairant = DBTable::ELEVE;
        $this->folder_view_index = 'eleve.index1';
        
        $this->loadModel($this->vairant);

        $this->base_route = 'eleve';
        $this->class_name = 'eleve';

        $this->title_page = 'Gestion des eleves - ' . $this->organisation;
        $this->title_home = 'Gestion des eleves';
        $this->create_title = "Creation d'un eleve";
        $this->view_title = "Information d'un eleve";
        $this->update_title = "Mise à jour d'un eleve";
        $this->delete_title = "Suppression d'un eleve";
        $this->msg_delete = "Voulez-vous vraiment supprimer l eleve ";
    }

    public function index()
    {
        $this->liste();
    }

    public function eleve_detail(string $code)
    {
        return $this->eleve_repository->get_eleve_info($code);
    }

    public function eleve_classe(string $code)
    {
        $classe_id = DBTable::getModel(DBTable::CLASSE)->select('id')->find($code, 'code')[0];
        $eleves =  $this->eleve->getEleveClass($classe_id);
        if ($eleves) {
            $this->sendResponseAndExit($eleves);
        } else {
            $this->sendResponseAndExit($code, false, 400, 'DB Error');
        }
    }

    public function eleve_all()
    {
        $classes = DBTable::getModel(DBTable::CLASSE)->select(['code' => 'id', 'libelle' => 'value'])->where('visibilite', '=', 1)->get();
    }

    public function eleve_info(string $search)
    {
        return $this->eleve_repository->info($search);
    }
}
