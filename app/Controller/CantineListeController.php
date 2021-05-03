<?php

namespace App\Controller;

use App\Model\DBTable;
use App\Repository\EleveRepository;
use App\Controller\Admin\AppController;

class CantineListeController extends AppController
{
    private $eleve_repository;

    public function __construct()
    {
        parent::__construct();

        //$this->eleve_repository = new EleveRepository;

        $this->vairant = DBTable::CANTINE_LISTE;
        $this->folder_view_index = 'cantineliste.index1';

        $this->loadModel($this->vairant);

        
        $this->base_route = 'cantineliste';
        $this->class_name = 'cantineliste';

        $this->title_page = 'Gestion des eleves - Ges-School';
        $this->title_home = 'Gestion des eleves';
        $this->create_title = "Creation d'un eleve";
        $this->view_title = "Information d'un eleve";
        $this->update_title = "Mise à jour d'un eleve";
        $this->delete_title = "Suppression d'un eleve";
        $this->msg_delete = "Voulez-vous vraiment supprimer l eleve ";
    }

    public function index()
    {
        $this->app->setTitle('Liste des élèves inscrits  - Ges-School');
        $title = $this->title_page;
        $eleves = $this->eleve->getEleveInscriptionInfo();
        $classes = DBTable::getModel(DBTable::CLASSE)->select(['code' => 'id', 'libelle' => 'value'])->where('visibilite', '=', 1)->get();
        //die();
        $this->render('cantineliste.index1', compact('eleves', 'title', 'classes'));
    }

    public function eleve_detail(string $code)
    {
        return $this->eleve_repository->detail($code);
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
