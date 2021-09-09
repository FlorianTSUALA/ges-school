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
use App\Model\TrancheScolaireMois;
use App\Model\TypeTrancheScolaire;
use App\Helpers\TraitCRUDController;
use App\Model\GroupeFamilialReduction;
use App\Controller\Admin\AppController;
use ClanCats\Hydrahon\Query\Expression;
use App\Repository\GroupeFamilialRepository;
use App\Repository\TrancheScolaireRepository;

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

    public function get_all(){
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        return (new GroupeFamilialRepository() )->getAllTrancheScolaires($annee_scolaire_id);
    }

    public function get_one($code){
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        $result = (new GroupeFamilialRepository() )->getTrancheScolaire($annee_scolaire_id, $code);
        // dd($result);
        return $result;
    }

    public function save()
    {
        $description = $_POST['description'];
        $type_groupe_familial_code = Request::getSecParam('type_groupe_familial_id');
        $date_limite_paiement = Request::getSecParam('date_limite_paiement');
        // $annee_scolaire_code = Request::getSecParam('annee_scolaire_id');
        // $annee_scolaire_id = TypeTrancheScolaire::table()->select('id')->where('code', $type_groupe_familial_code)->one()['id'];
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $libelle = Request::getSecParam('libelle');
        $groupe_familial_code = TrancheScolaire::generateCode();
        $data_groupe_familial = [
            'code' => $groupe_familial_code,
            'annee_scolaire_id' => $annee_scolaire_id,
            'date_limite_paiement' => $date_limite_paiement,
            'type_groupe_familial_id' => TypeTrancheScolaire::get_id($type_groupe_familial_code),
            'libelle' => $libelle,
        ];
        TrancheScolaire::table()->insert($data_groupe_familial)->execute();
        $groupe_familial_id = TrancheScolaire::table()->select('id')->where('code', $groupe_familial_code)->one()['id'];
        foreach($description as $key => $value){
            $groupe_familial_mois_code = TrancheScolaireMois::generateCode();
            $data_groupe_familial_mois = [
                'code' => $groupe_familial_mois_code,
                'mois_id' => Mois::table()->select('id')->where('code', $value)->one()['id'],
                'groupe_familial_id' => $groupe_familial_id,
            ];
            TrancheScolaireMois::table()->insert($data_groupe_familial_mois)->execute();                
        }

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
        $type_groupe_familial_code = Request::getSecParam('type_groupe_familial_id');
        $date_limite_paiement = Request::getSecParam('date_limite_paiement');
        // $annee_scolaire_code = Request::getSecParam('annee_scolaire_id');
        // $annee_scolaire_id = TypeTrancheScolaire::table()->select('id')->where('code', $type_groupe_familial_code)->one()['id'];
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $libelle = Request::getSecParam('libelle');
        $data_groupe_familial = [
            'annee_scolaire_id' => $annee_scolaire_id,
            'date_limite_paiement' => $date_limite_paiement,
            'type_groupe_familial_id' => TypeTrancheScolaire::table()->select('id')->where('code', $type_groupe_familial_code)->one()['id'],
            'libelle' => $libelle,
        ];
        $groupe_familial_id = TrancheScolaire::get_id($code);
        TrancheScolaire::table()->update($data_groupe_familial)->where('id', $groupe_familial_id)->execute();
        TrancheScolaireMois::table()->delete()->where('groupe_familial_id', $groupe_familial_id)->execute();
        foreach($description as $key => $value){
            $groupe_familial_mois_code = TrancheScolaireMois::generateCode();
            $data_groupe_familial_mois = [
                'code' => $groupe_familial_mois_code,
                'mois_id' => Mois::table()->select('id')->where('code', $value)->one()['id'],
                'groupe_familial_id' => $groupe_familial_id,
            ];
            TrancheScolaireMois::table()->insert($data_groupe_familial_mois)->execute();                
        }

        $result = true;
        if ($result) {
            $items = $this->get_all();
            $data = HTMLHelper::genBodyTable($items, $this->class_name, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $this->{$this->vairant}->fillables));
            $this->sendResponseAndExit($data);
        } else {
            $this->sendResponseAndExit($result, false, 400, 'DB Error');
        }
    }
    
    // api_save_groupe_familial
    public function api_get_groupe_familial($code) 
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

        $data['reduction'] =  GroupeFamilialReduction::table()->select()->where('annee_scolaire_id', $annee_scolaire_id)->where('groupe_familial_id', $groupe_familial_id)->where('visibilite', 1)->one();

        $results[API::TAG_STATUS] = API::TAG_SUCCESS;
        $results[API::TAG_DATATABLE_DR] = API::TAG_DATATABLE_VALUE_DR;
        $results[API::TAG_DATATABLE_RT] = count($data);
        $results[API::TAG_DATATABLE_RF] = count($data);
        $results[API::TAG_DATA] = $data;

        echo Helpers::toJSON($results) ;
    }

}
