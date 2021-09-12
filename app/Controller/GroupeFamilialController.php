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
use App\Model\GroupeFamilial;
use function Core\Helper\dd;
use App\Helpers\TraitCRUDController;
use App\Model\ReductionFamiliale;
use App\Controller\Admin\AppController;
use ClanCats\Hydrahon\Query\Expression;
use App\Repository\GroupeFamilialRepository;

class GroupeFamilialController  extends AppController
{

    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::GROUPE_FAMILIAL;
        $this->folder_view_index = 'groupe_familial.index';

        $this->loadModel($this->vairant);
        $this->model = GroupeFamilial::table();
       
        $this->base_route = 'groupe_familial';
        $this->class_name = 'groupe_familial';

        $this->title_page = 'Gestion des groupes familiaux - Ges-School';
        $this->title_home = 'Gestion des groupes familiaux';
        $this->create_title = "Creation d'un groupe familial";
        $this->view_title = "Information d'un groupe familial";
        $this->update_title = "Mise à jour d'un groupe familial";
        $this->delete_title = "Suppression d'un groupe familial";
        $this->msg_delete = "Voulez-vous vraiment supprimer le groupe familial ";
    }

    public function index_groupe_familial()
    {
        $this->app->setTitle($this->title_page);
        $title = $this->title_home;
        $items = $this->get_all();
        $fillables = $this->{$this->vairant}->fillables;
        $class_name = $this->class_name;
        $base_route = $this->base_route;
        $route = $this->base_route;
        $sub_route = "groupe_familial";
        $create_title = $this->create_title;
        $view_title = $this->view_title;
        $update_title = $this->update_title;
        $delete_title = $this->delete_title;
        $msg_delete = $this->msg_delete;
        $this->render('sections.'.$this->folder_view_index, compact('route', 'items', 'class_name', 'fillables', 'base_route', 'title', 'create_title', 'view_title', 'update_title', 'delete_title', 'msg_delete'));
    }


    public function get_all(){
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        return (new GroupeFamilialRepository() )->get_all_groupe_familial_reduction($annee_scolaire_id);
    }

    public function get_one($code){
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        $result = (new GroupeFamilialRepository() )->get_one_groupe_familial_reduction($code);
        return $result;
    }
   
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

     

    public function save()
    {
        $description = $_POST['description'];
        $famille = Request::getSecParam('famille');

        $groupe_familial_code = GroupeFamilial::generateCode();
        $data_groupe_familial = [
            'code' => $groupe_familial_code,
            'famille' => $famille,
        ];
        GroupeFamilial::table()->insert($data_groupe_familial)->execute();
        $groupe_familial_id = GroupeFamilial::get_id($groupe_familial_code);

        foreach($description as $key => $value)
            Eleve::table()->update()->set('groupe_familial_id', $groupe_familial_id)->where('code', $value)->execute();

        $result = true;
        if ($result) {
            $items = $this->get_all();
            $data = HTMLHelper::genBodyTable($items, $this->class_name, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $this->{$this->vairant}->fillables));
            $this->sendResponseAndExit($data);
        } else {
            $this->sendResponseAndExit($result, false, 400, 'DB Error');
        }
    }

    /**
     *
     * @param string $code
     * @return void
     */
    public function update($code)
    {
        // dd($code);
        $description = $_POST['description'];
        $famille = Request::getSecParam('famille');

        $groupe_familial_id = GroupeFamilial::get_id($code);

        GroupeFamilial::table()->update()->set('famille', $famille)->where('id', $groupe_familial_id)->execute();
        
        $old_eleves = Eleve::table()  ->select('id')->where('groupe_familial_id', $groupe_familial_id)->where('visibilite', 1)->get();
        foreach ($old_eleves as $eleve_id) 
            Eleve::table()->update()->set('groupe_familial_id', null)->where('groupe_familial_id', $groupe_familial_id)->execute();

        foreach($description as $key => $value)
            Eleve::table()->update()->set('groupe_familial_id', $groupe_familial_id)->where('code', $value)->execute();

        $result = true;
        if ($result) {
            $items = $this->get_all();
            $data = HTMLHelper::genBodyTable($items, $this->class_name, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $this->{$this->vairant}->fillables));
            $this->sendResponseAndExit($data);
        } else {
            $this->sendResponseAndExit($result, false, 400, 'DB Error');
        }
    }
   

}
