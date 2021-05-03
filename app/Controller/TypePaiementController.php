<?php

namespace App\Controller;
    
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

class TypePaiementController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = 'type_paiement';
        $this->folder_view_index = 'type_paiement.index';

        $this->loadModel('type_paiement');
        $this->base_route = 'type_paiement';
        $this->class_name = 'TypePaiement';

        $this->title_page = 'Gestion des types de paiements - Ges-School';
        $this->title_home = 'Gestion des types de paiements';
        $this->create_title = "Creation d'un type de paiements";
        $this->view_title = "Information d'un type de paiements";
        $this->update_title = "Mise à jour d'un type de paiements";
        $this->delete_title = "Suppression d'un type de paiements";
        $this->msg_delete = "Voulez-vous vraiment supprimer le type de paiements ";
    }

}