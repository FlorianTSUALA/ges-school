<?php

namespace App\Controller;

use App\Model\DBTable;
use App\Helpers\TraitCRUDController;
use App\Repository\ExemplaireRepository;
use App\Controller\Admin\AppController;

class ExemplaireController extends AppController
{
    
    use TraitCRUDController;

    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::EXEMPLAIRE;
        $this->folder_view_index = 'exemplaire.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'exemplaire';
        $this->class_name = 'exemplaire';

        $this->title_page = 'Gestion des exemplaires de document - Ges-School';
        $this->title_home = 'Gestion des exemplaires de document';
        $this->create_title = "Création d'un exemplaire de document";
        $this->view_title = "Information d'un exemplaire de document";
        $this->update_title = "Mise à jour d'un exemplaire de document";
        $this->delete_title = "Suppression d'un exemplaire de document";
        $this->msg_delete = "Voulez-vous vraiment supprimer cet exemplaire de document? ";
        
    }

    public function getall(){
        return (new ExemplaireRepository())->getAll();
    }

}
    