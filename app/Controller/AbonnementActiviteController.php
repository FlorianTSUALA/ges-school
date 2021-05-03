<?php

namespace App\Controller;

use App\Model\DBTable;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

class AbonnementActiviteController extends AppController
{
    use TraitCRUDController;
   
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::ABONNEMENT_ACTIVITE;
        $this->folder_view_index = 'abonnement_activite.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'abonnement_activite';
        $this->class_name = 'abonnement_activite';

        $this->title_page = 'Gestion des abonnements d\'activités - Ges-School';
        $this->title_home = 'Gestion des abonnements d\'activités';
        $this->create_title = "Creation d'un abonnement d\'activités";
        $this->view_title = "Information d'un abonnement d\'activités";
        $this->update_title = "Mise à jour d'un abonnement d\'activités";
        $this->delete_title = "Suppression d'un abonnement d\'activités";
        $this->msg_delete = "Voulez-vous vraiment supprimer l'abonnement d\'activité";
    }

}
