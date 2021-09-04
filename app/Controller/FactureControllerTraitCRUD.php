<?php

namespace App\Controller;

use App\Helpers\S;
use App\Model\DBTable;
use App\Helpers\Helpers;
use Config\Invariant\API;


use App\Model\StatutEleve;
use App\Helpers\HTMLHelper;
use function Core\Helper\dd;
use function Core\Helper\vd;

use Core\HTML\Form\FormModel;
use App\Helpers\TraitCRUDController;
use App\Model\Personnel;
use App\Repository\ClasseRepository;
use App\Repository\VersementRepository;
use App\Model\Facture;

trait FactureControllerTraitCRUD
{

    use TraitCRUDController;

    public function versement_total()
    {
        $route = 'versement_totale';
        $menu_actif = 'versement_totale';

        $this->render('sections.versement.liste.versement_total.index', compact( 'route',  'menu_actif'));
    }
    public function api_facture_info_api_paie($code) 
    {
        $personnel_id = Personnel::get_id($code);
        $data_info_factures = Facture::get_paie_facture_total($personnel_id);
        echo Helpers::toJSON($data_info_factures) ;
    }
}
