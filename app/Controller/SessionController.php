<?php

namespace App\Controller;

use App\Helpers\S;
use App\Model\Session;
use App\Helpers\Helpers;
use Core\Session\Request;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

class SessionController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = 'session';
        $this->folder_view_index = 'session.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'session';
        $this->class_name = 'Session';

        $this->title_page = 'Gestion des sessions - Ges-School';
        $this->title_home = 'Gestion des sessions';
        $this->create_title = "Creation d'une session";
        $this->view_title = "Information d'une session";
        $this->update_title = "Mise à jour d'une session";
        $this->delete_title = "Suppression d'une session";
        $this->msg_delete = "Voulez-vous vraiment supprimer cette session ";
    }

            
    public function getall(){
        //PROBLEMATIQUE : DOIT ON FILTRER LES SESSIONS
        //TODO : GENERATION AUTOMATIQUE DE SESSIONS EN SE BASANT SUR CELLE DE L ANNEE ANTERIEURE
        
        $model = Session::table();
        
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $results = $model->select(' annee_scolaire.libelle as annee_scolaire_id, session.code as code, session.libelle as libelle, session.date_debut as date_debut, session.date_fin as date_fin')
                    ->where('session.visibilite', 1)
                    ->join('annee_scolaire', 'annee_scolaire.id', '=', 'session.annee_scolaire_id')
                    // ->where('session.annee_scolaire_id', $annee_scolaire_id)
                    ->get();

        return $results;
    }

    public function apiListeSession()
    {
        $model = ($this->getall());
        $this->sendResponseAndExit(Helpers::toJSON($model, TRUE));
    }


}
