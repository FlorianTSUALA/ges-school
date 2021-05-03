<?php
namespace App\Controller;

use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

class TypePersonnelController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = 'type_personnel';
        $this->folder_view_index = 'type_personnel.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'type_personnel';
        $this->class_name = 'TypePersonnel';

        $this->title_page = 'Gestion des types de personnels - Ges-School';
        $this->title_home = 'Gestion des types de personnels';
        $this->create_title = "Creation d'un type de personnels";
        $this->view_title = "Information d'un type de personnels";
        $this->update_title = "Mise à jour d'un type de personnels";
        $this->delete_title = "Suppression d'un type de personnels";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce type de personnels ";
    }

}