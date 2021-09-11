<?php

namespace App\Controller;

use App\Helpers\S;
use App\Model\Mois;
use App\Model\Eleve;


use App\Model\DBTable;
use App\Helpers\Helpers;
use App\Model\Personnel;
use Config\Invariant\API;
use Core\Session\Request;
use App\Model\StatutEleve;
use App\Helpers\HTMLHelper;
use App\Model\GroupeFamilial;
use Core\HTML\Form\FormModel;
use App\Model\TrancheScolaire;
use function Core\Helper\dd;
use App\Model\TrancheScolaireMois;
use App\Model\TypeTrancheScolaire;
use App\Helpers\TraitCRUDController;
use App\Model\ReductionFamiliale;
use App\Controller\Admin\AppController;
use ClanCats\Hydrahon\Query\Expression;
use App\Repository\GroupeFamilialRepository;
use App\Repository\TrancheScolaireRepository;

class GroupeFamilialController  extends AppController
{
    
    public function api_get_groupe_familial($code) 
    {
        $groupe_familial_id = Eleve::table()->select('groupe_familial_id')->where('visibilite', 1)->where('eleve.code', $code)->one()['groupe_familial_id'];
        if(is_null($groupe_familial_id))
        {
            echo Helpers::toJSON('empty');
            return ;
        }
        
        $data['eleves'] = Eleve::table()->select(
                                                    [
                                                        new Expression("concat(eleve.nom,' ',eleve.prenom) AS nom_complet"),
                                                        'eleve.code' => 'id',
                                                        'eleve.matricule' => 'matricule',
                                                        'eleve.date_naissance' => 'date_naissance',
                                                        'eleve.lieu_naissance' => 'lieu_naissance'
                                                    ]
                                                )
                                        ->where('eleve.groupe_familial_id', $groupe_familial_id)
                                        ->whereNotIn('eleve.statut_eleve_id', [StatutEleve::get_id(StatutEleve::DEMISSINAIRE_CODE), StatutEleve::get_id(StatutEleve::FIN_CYCLE_CODE)])
                                        ->where('eleve.visibilite', 1)
                                        ->get();

        $data['groupe_familial_info'] = GroupeFamilial::table()->select()->where('id', $groupe_familial_id)->where('visibilite', 1)->one();

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $data['reduction'] = 0;//  ReductionFamiliale::table()->select()->where('annee_scolaire_id', $annee_scolaire_id)->where('groupe_familial_id', $groupe_familial_id)->where('visibilite', 1)->one();

        echo Helpers::toJSON($data) ;
    }
    
    
    public function api_get_groupe_familial_all_info($code) 
    {
        $groupe_familial_id = Eleve::table()->select('groupe_familial_id')->where('visibilite', 1)->where('eleve.code', $code)->one()['groupe_familial_id'];
        if(is_null($groupe_familial_id))
            return [];
        
        $data['eleves'] = Eleve::table()->select(
                                                    [
                                                        new Expression("concat(eleve.nom,' ',eleve.prenom) AS nom_complet"),
                                                        'eleve.code' => 'id',
                                                        'eleve.matricule' => 'matricule',
                                                        'eleve.date_naissance' => 'date_naissance',
                                                        'eleve.lieu_naissance' => 'lieu_naissance'
                                                    ]
                                                )
                                        ->where('eleve.groupe_familial_id', $groupe_familial_id)
                                        ->whereNotIn('eleve.statut_eleve_id', [StatutEleve::get_id(StatutEleve::DEMISSINAIRE_CODE), StatutEleve::get_id(StatutEleve::FIN_CYCLE_CODE)])
                                        ->where('eleve.visibilite', 1)
                                        ->get();

        $data['groupe_familial_info'] = GroupeFamilial::table()->select()->where('id', $groupe_familial_id)->where('visibilite', 1)->one();

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $data['reduction'] = ReductionFamiliale::table()->select()->where('annee_scolaire_id', $annee_scolaire_id)->where('groupe_familial_id', $groupe_familial_id)->where('visibilite', 1)->one();

        echo Helpers::toJSON($data) ;
    }

}
