<?php

namespace App\Controller;

use App\Helpers\S;
use App\Model\Eleve;
use App\Model\DBTable;


use App\Helpers\Helpers;
use App\Model\Personnel;
use Config\Invariant\API;
use App\Model\GroupeFamilial;
use App\Controller\Admin\AppController;

class GroupeFamilialController  extends AppController
{

    public function __construct(){
        $this->model = GroupeFamilial::table();
    }
    
    // api_save_groupe_familial
    public function api_get_groupe_familial($code) 
    {
        $groupe_familial_id = Eleve::table()->select('groupe_familial_id')->where('code', $code)->where('visibilite', 1)->one()['groupe_familial_id'];

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $results = $this->model->select(
                                            [
                                                'groupe_familial.code' => 'id',
                                                'groupe_familial.famille' => 'famille',
                                                'groupe_familial.reduction' => 'reduction',
                                                'eleve.nom' => 'nom',
                                                'eleve.prenom' => 'prenom',
                                                'eleve.code' => 'eleve_code',
                                            ]
                                        )
                                ->join('eleve', 'eleve.groupe_familial_id', '=', 'groupe_familial.id')
                                ->where('groupe_familial.visibilite', 1)
                                ->where('groupe_familial.id', $groupe_familial_id)
                                ->where('eleve.visibilite', 1)
                                ->get();
      


        $results[API::TAG_STATUS] = API::TAG_SUCCESS;
        $results[API::TAG_DATATABLE_DR] = API::TAG_DATATABLE_VALUE_DR;
        $results[API::TAG_DATATABLE_RT] = count($results);
        $results[API::TAG_DATATABLE_RF] = count($results);
        $results[API::TAG_DATA] = $results;
        echo Helpers::toJSON($results) ;
    }

  

}
