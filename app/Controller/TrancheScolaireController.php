<?php

namespace App\Controller;

use App\Helpers\S;
use App\Model\Mois;
use App\Model\DBTable;
use Core\Session\Request;
use App\Helpers\HTMLHelper;
use function Core\Helper\dd;
use Core\HTML\Form\FormModel;
use App\Model\TrancheScolaire;
use App\Model\TrancheScolaireMois;
use App\Model\TypeTrancheScolaire;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;
use App\Repository\TrancheScolaireRepository;
use ClanCats\Hydrahon\Query\Expression as Ex;

class TrancheScolaireController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::TRANCHE_SCOLAIRE;
        $this->folder_view_index = 'tranche_scolaire.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'tranche_scolaire';
        $this->class_name = 'tranche_scolaire';

        $this->title_page = 'Gestion des tranches scolaire - Ges-School';
        $this->title_home = 'Gestion des tranches scolaire';
        $this->create_title = "Creation d'une tranche scolaire";
        $this->view_title = "Information d'une tranche scolaire";
        $this->update_title = "Mise à jour d'une tranche scolaire";
        $this->delete_title = "Suppression d'une tranche scolaire";
        $this->msg_delete = "Voulez-vous vraiment supprimer la tranche scolaire ";
    }

    public function get_all(){
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        return (new TrancheScolaireRepository() )->getAllTrancheScolaires($annee_scolaire_id);
    }

    public function get_one($code){
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        $result = (new TrancheScolaireRepository() )->getTrancheScolaire($annee_scolaire_id, $code);
        // dd($result);
        return $result;
    }

    public function save()
    {
        $description = $_POST['description'];
        $type_tranche_scolaire_code = Request::getSecParam('type_tranche_scolaire_id');
        // $annee_scolaire_code = Request::getSecParam('annee_scolaire_id');
        // $annee_scolaire_id = TypeTrancheScolaire::table()->select('id')->where('code', $type_tranche_scolaire_code)->one()['id'];
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $libelle = Request::getSecParam('libelle');
        $tranche_scolaire_code = TrancheScolaire::generateCode();
        $data_tranche_scolaire = [
            'code' => $tranche_scolaire_code,
            'annee_scolaire_id' => $annee_scolaire_id,
            'type_tranche_scolaire_id' => TypeTrancheScolaire::get_id($type_tranche_scolaire_code),
            'libelle' => $libelle,
        ];
        TrancheScolaire::table()->insert($data_tranche_scolaire)->execute();
        $tranche_scolaire_id = TrancheScolaire::table()->select('id')->where('code', $tranche_scolaire_code)->one()['id'];
        foreach($description as $key => $value){
            $tranche_scolaire_mois_code = TrancheScolaireMois::generateCode();
            $data_tranche_scolaire_mois = [
                'code' => $tranche_scolaire_mois_code,
                'mois_id' => Mois::table()->select('id')->where('code', $value)->one()['id'],
                'tranche_scolaire_id' => $tranche_scolaire_id,
            ];
            TrancheScolaireMois::table()->insert($data_tranche_scolaire_mois)->execute();                
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
        $type_tranche_scolaire_code = Request::getSecParam('type_tranche_scolaire_id');
        // $annee_scolaire_code = Request::getSecParam('annee_scolaire_id');
        // $annee_scolaire_id = TypeTrancheScolaire::table()->select('id')->where('code', $type_tranche_scolaire_code)->one()['id'];
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $libelle = Request::getSecParam('libelle');
        $data_tranche_scolaire = [
            'annee_scolaire_id' => $annee_scolaire_id,
            'type_tranche_scolaire_id' => TypeTrancheScolaire::table()->select('id')->where('code', $type_tranche_scolaire_code)->one()['id'],
            'libelle' => $libelle,
        ];
        $tranche_scolaire_id = TrancheScolaire::get_id($code);
        TrancheScolaire::table()->update($data_tranche_scolaire)->where('id', $tranche_scolaire_id)->execute();
        TrancheScolaireMois::table()->delete()->where('tranche_scolaire_id', $tranche_scolaire_id)->execute();
        foreach($description as $key => $value){
            $tranche_scolaire_mois_code = TrancheScolaireMois::generateCode();
            $data_tranche_scolaire_mois = [
                'code' => $tranche_scolaire_mois_code,
                'mois_id' => Mois::table()->select('id')->where('code', $value)->one()['id'],
                'tranche_scolaire_id' => $tranche_scolaire_id,
            ];
            TrancheScolaireMois::table()->insert($data_tranche_scolaire_mois)->execute();                
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


}