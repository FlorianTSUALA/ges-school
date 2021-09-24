<?php

namespace App\Controller;

use App\Helpers\S;
use App\Model\Eleve;
use App\Model\DBTable;
use App\Helpers\Helpers;
use Core\Session\Request;
use App\Model\StatutEleve;
use App\Helpers\HTMLHelper;
use Core\HTML\Form\FormModel;
use App\Model\ReductionFamiliale;
use function Core\Helper\dd;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;
use ClanCats\Hydrahon\Query\Expression;
use App\Repository\ReductionFamilialeRepository;

class ReductionFamilialeController  extends AppController
{


    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::REDUCTION_FAMILIALE;
        $this->folder_view_index = 'reduction_familiale.index';

        $this->loadModel($this->vairant);
        $this->model = ReductionFamiliale::table();
       
        $this->base_route = 'reduction_familiale';
        $this->class_name = 'reduction_familiale';

        $this->title_page = 'Gestion des reductions familiales - ' . $this->organisation;
        $this->title_home = 'Gestion des reductions familiales';
        $this->create_title = "Creation d'une reduction familiale";
        $this->view_title = "Information d'une reduction familiale";
        $this->update_title = "Mise à jour d'une reduction familiale";
        $this->delete_title = "Suppression d'une reduction familiale";
        $this->msg_delete = "Voulez-vous vraiment supprimer la reduction familiale ";
    }

    public function index()
    {
        $this->app->setTitle($this->title_page);
        $title = $this->title_home;
        $items = $this->get_all();
        $fillables = $this->{$this->vairant}->fillables;
        $class_name = $this->class_name;
        $base_route = $this->base_route;
        $route = $this->base_route;
        $sub_route = "reduction_familiale";
        $create_title = $this->create_title;
        $view_title = $this->view_title;
        $update_title = $this->update_title;
        $delete_title = $this->delete_title;
        $msg_delete = $this->msg_delete;
        $this->render('sections.'.$this->folder_view_index, compact('route', 'items', 'class_name', 'fillables', 'base_route', 'title', 'create_title', 'view_title', 'update_title', 'delete_title', 'msg_delete'));
    }

    public function get_all(){
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        return (new ReductionFamilialeRepository() )->get_all_reduction_familiale_reduction($annee_scolaire_id);
    }
   
    public function api_get_reduction_familiale($code) 
    {
        $reduction_familiale_id = Eleve::table()->select('reduction_familiale_id')->where('visibilite', 1)->where('eleve.code', $code)->one()['reduction_familiale_id'];
        if(is_null($reduction_familiale_id))
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
                                        ->where('eleve.reduction_familiale_id', $reduction_familiale_id)
                                        ->whereNotIn('eleve.statut_eleve_id', [StatutEleve::get_id(StatutEleve::DEMISSINAIRE_CODE), StatutEleve::get_id(StatutEleve::FIN_CYCLE_CODE)])
                                        ->where('eleve.visibilite', 1)
                                        ->get();

        $data['reduction_familiale_info'] = ReductionFamiliale::table()->select()->where('id', $reduction_familiale_id)->where('visibilite', 1)->one();

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $data['reduction'] = 0;//  ReductionFamiliale::table()->select()->where('annee_scolaire_id', $annee_scolaire_id)->where('reduction_familiale_id', $reduction_familiale_id)->where('visibilite', 1)->one();

        echo Helpers::toJSON($data) ;
    }

}
