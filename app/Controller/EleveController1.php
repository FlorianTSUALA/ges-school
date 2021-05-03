<?php

namespace App\Controller;

use App\Model\DBTable;
use App\Repository\EleveRepository;
use App\Helpers\TraitCRUDController;

class EleveController2 extends AppController
{
    use TraitCRUDController;
    private $eleve_repository;

    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::ELEVE;
        $this->folder_view_index = 'eleve.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'eleve';
        $this->class_name = 'eleve';

        $this->title_page = 'Gestion des eleves - Ges-School';
        $this->title_home = 'Gestion des eleves';
        $this->create_title = "Creation d'un eleve";
        $this->view_title = "Information d'un eleve";
        $this->update_title = "Mise à jour d'un eleve";
        $this->delete_title = "Suppression d'un eleve";
        $this->msg_delete = "Voulez-vous vraiment supprimer l eleve ";
    }

}