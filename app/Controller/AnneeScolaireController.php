<?php

namespace App\Controller;

use App\Helpers\TraitCRUDController;
use App\Model\DBTable;
use App\Controller\Admin\AppController;

class AnneeScolaireController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::ANNEE_SCOLAIRE;
        $this->folder_view_index = 'annee_scolaire.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'annee_scolaire';
        $this->class_name = 'AnneeScolaire';

        $this->title_page = 'Gestion des annnée scolaire - Ges-School';
        $this->title_home = 'Gestion des années scolaires';
        $this->create_title = "Creation d'une année scolaire";
        $this->view_title = "Information d'une année scolaire";
        $this->update_title = "Mise à jour d'une année scolaire";
        $this->delete_title = "Suppression d'une année scolaire";
        $this->msg_delete = "Voulez-vous vraiment supprimer l'année scolaire ";
    }

    //TODO GESTION DES ERREURS LORS DE LA SUPPRESSION D UNE ANNEE SCOLAIRE
    // MISE A JOUR DE LA VISIBILITE

    //TODO MASQUAGE DE CERTAINS BOUTTONS SUR CERTAINES PAGES DE CRUD
}
