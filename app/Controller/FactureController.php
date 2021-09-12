<?php

namespace App\Controller;

use App\Helpers\S;
use App\Model\DBTable;
use App\Model\Facture;
use App\Helpers\Helpers;


use App\Model\Personnel;
use Config\Invariant\API;
use Core\Session\Request;
use App\Model\StatutEleve;

use App\Helpers\HTMLHelper;
use function Core\Helper\dd;
use function Core\Helper\vd;
use Core\HTML\Form\FormModel;
use App\Helpers\TraitCRUDController;
use App\Repository\ClasseRepository;
use App\Repository\FactureRepository;
use App\Controller\Admin\AppController;
use App\Repository\VersementRepository;

class FactureController  extends AppController
{

    public function facture_totale()
    {
        $route = 'facture_totale';
        $sub_route = 'facture_totale';

        $date = Request::getSecParam('date', NULL);
        $personnel_code = $this->session->get(S::PERS_CODE); 
        $personnel_id = Personnel::get_id($personnel_code);
        $data_total = (new FactureRepository())->get_paie_facture_total($personnel_id, $date);
        $data_cantine = (new FactureRepository())->get_paie_facture_cantine($personnel_id, $date);
        $data_activite = (new FactureRepository())->get_paie_facture_activite($personnel_id, $date);
        $data_scolarite = (new FactureRepository())->get_paie_facture_scolarite($personnel_id, $date);
        $data_inscription = (new FactureRepository())->get_paie_facture_inscription($personnel_id, $date);
        $data_activite_total = (new FactureRepository())->get_paie_facture_activite_total($personnel_id, $date);

        $this->render('sections.versement.liste.versement_total.index', compact( 'route',  'sub_route', 'data_total', 'data_cantine', 'data_activite', 'data_scolarite', 'data_inscription','data_activite_total'));
       
    }

    public function api_facture_info_api_paie() 
    {
        $date = Request::getSecParam('date', NULL);
        $filter_by = Request::getSecParam('filter_by', 'ALL');

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        $personnel_code = $this->session->get(S::PERS_CODE); 
        $personnel_id = Personnel::get_id($personnel_code);
        $data = [];
        if($filter_by === 'ALL'){
            $data = (new FactureRepository())->get_paie_facture_total($personnel_id, $date);
        }else{
        }
        $results[API::TAG_STATUS] = API::TAG_SUCCESS;
        $results[API::TAG_DATATABLE_DR] = API::TAG_DATATABLE_VALUE_DR;
        $results[API::TAG_DATATABLE_RT] = count($results);
        $results[API::TAG_DATATABLE_RF] = count($results);
        $results[API::TAG_DATA] = $results;
        echo Helpers::toJSON($results) ;
    }

  

}
