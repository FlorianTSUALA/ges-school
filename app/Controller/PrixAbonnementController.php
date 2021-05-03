<?php

namespace App\Controller;

use App\Model\PrixAbonnement;
use App\Model\DBTable;
use App\Model\Activite;
use App\Helpers\TraitCRUDController;

use ClanCats\Hydrahon\Query\Expression as Ex;
use ClanCats\Hydrahon\Query\Sql\Func as F;

use Core\Session\Request;
use App\Helpers\HTMLHelper;
use App\Helpers\Helpers;
use Core\HTML\Form\FormModel;
use App\Controller\Admin\AppController;

class PrixAbonnementController extends AppController
{
    use TraitCRUDController;

    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::PRIX_ABONNEMENT;
        $this->folder_view_index = 'prix_abonnement.index';
        $this->class_name = 'prix_abonnement';

        $this->loadModel($this->vairant);
        $this->base_route = 'prix_abonnement';

        $this->title_page = 'Gestion des affections des prix de differents abonements - Ges-School';
        $this->title_home = 'Gestion des prix de differents abonements';
        $this->create_title = "Définition du prix d'un abonnement";
        $this->view_title = "Prix de l'abonnement";
        $this->update_title = "Mise à jour d'un prix d'un abonnement";
        $this->delete_title = "Suppression dprix d'un abonnement selon une periode ";
        $this->msg_delete = "Voulez-vous vraiment supprimer cette affectation ";
    }

    public function index()
    {
        $this->app->setTitle($this->title_page);
        $title = $this->title_home;
        $items = $this->getall();
        $fillables = $this->{$this->vairant}->fillables;
        $class_name = $this->class_name;
        $base_route = $this->base_route;
        $create_title = $this->create_title;
        $view_title = $this->view_title;
        $update_title = $this->update_title;
        $delete_title = $this->delete_title;
        $msg_delete = $this->msg_delete;
        $this->render('sections.'.$this->folder_view_index, compact('items', 'class_name', 'fillables', 'base_route', 'title', 'create_title', 'view_title', 'update_title', 'delete_title', 'msg_delete'));
    }

    public function save()
    {
        $type_abonnement_code = Request::getSecParam('type_abonnement_id', '');
        $activite = DBTable::getModel('activite')->select(['id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->where('code', '=', $type_abonnement_code)->one();

        $type_abonnement_id = ($type_abonnement_code === 0)? 0 :  (int)$activite['id'];
        $periode = Request::getSecParam('periode', '');
        $type_abonnement = ($type_abonnement_code === 0)? 'CANTINE' : 'ACTIVITE';


        $existe = (DBTable::getModel('prix_abonnement')
                                //->select('id')
                                ->select(new F('count', 'prix_abonnement.id'))
                                ->where('periode', '=', $periode)->where('type_abonnement_id', '=', $type_abonnement_id)
                                ->where('visibilite', '=', 1)->where('type_abonnement', '=', $type_abonnement)->one());

        if ($existe["count(`prix_abonnement`.`id`)"] !== "0") {
            $this->sendResponseAndExit('Violation de contriantes d\'integrité, Duplication', false, true, 300, 'Erreur : Enreegistrement existant !!!');
            return;
        }

        $data = [
            'montant' => Request::getSecParam('montant', ''),
            'periode' => $periode,
            'type_abonnement' => $type_abonnement,
            'type_abonnement_id' => $type_abonnement_id,
            'description' => ($type_abonnement_code === 0)? 'CANTINE' : $activite['libelle']
        ] ;

        $data += ['code' => $this->{$this->vairant}->genCode()];

        $result = $this->{$this->vairant}->save($data);
        if ($result) {
            $items = $this->getall();
            $data = HTMLHelper::genBodyTable($items, $this->class_name, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $this->{$this->vairant}->fillables));
            $this->sendResponseAndExit($data);
        } else {
            $this->sendResponseAndExit('Erreur', false, 400, 'DB Error');
        }
    }

    public function all()
    {
        return Helpers::toJSON($this->getall()) ;
    }

    public function list()
    {
        echo Helpers::toJSON($this->getall()) ;
    }

    public function show($code)
    {
        $entity = $this->{$this->vairant}->find('code', $code);

        $entity = $this->resolveExternalId2Value($entity, $this->{$this->vairant}->fillables);
        if($entity['type_abonnement_id'] === "0"){
            $entity['type_abonnement_id'] = 0;
        }else{
            $activite = DBTable::getModel('activite')->select(['code', 'libelle'])->where('visibilite', '=', 1)->where('id', '=', (int)$entity['type_abonnement_id'] )->one();
            $entity['type_abonnement_id'] = $activite['code'];
        }

        if (is_object($entity)) {
            $entity = (array) $entity;
        }
        $entity = $this->resolveId2CodeInput($entity, $this->{$this->vairant}->fillables);
        if ($entity) {
            $this->sendResponseAndExit(Helpers::toJSON($entity, true));
        } else {
            $this->sendResponseAndExit($entity, false, 400, 'DB Error');
        }
    }


    public function detail($code)
    {
        $entity = $this->{$this->vairant}->find('code', $code);
        $activite = DBTable::getModel('activite')->select(['code', 'libelle'])->where('visibilite', '=', 1)->where('id', '=', (int)$entity->type_abonnement_id )->one();

        $entity = $this->resolveExternalId2Value($entity, $this->{$this->vairant}->fillables);
        if($entity['type_abonnement_id'] === "0"){
            $entity['type_abonnement_id'] = 'Cantine';
        }else{
            $entity['type_abonnement_id'] = $activite['libelle'];
        }

        if ($entity) {
            $html = Helpers::buildDetailModel($entity, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $this->{$this->vairant}->fillables));
            $this->sendResponseAndExit($html);
        } else {
            $this->sendResponseAndExit($entity, false, 400, 'DB Error');
        }
    }

    public function update($code)
    {
        $data = Request::getSecPostParam($this->{$this->vairant}->fillables);
        $type_abonnement_code = Request::getSecParam('type_abonnement_id', '');

        $activite = DBTable::getModel('activite')->select(['id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->where('code', '=', $type_abonnement_code)->one();
        $type_abonnement_id = ($type_abonnement_code === "0")? 0 :  (int)$activite['id'];
        $periode = Request::getSecParam('periode', '');
        $type_abonnement = ($type_abonnement_code === "0")? 'CANTINE' : 'ACTIVITE';


        $existe = (DBTable::getModel('prix_abonnement')
                                ->select(new F('count', 'prix_abonnement.id'))
                                ->where('periode', '=', $periode)->where('type_abonnement_id', '=', $type_abonnement_id)
                                ->where('visibilite', '=', 1)->where('type_abonnement', '=', $type_abonnement)->one());

        if ($existe["count(`prix_abonnement`.`id`)"] !== "0" ) {
            $this->sendResponseAndExit('Violation de contriantes d\'integrité, Duplication', false, true, 300, 'Erreur : Enreegistrement existant !!!');
            return;
        }

        $data = $this->resolveCode2IdInput($data, $this->fillExternal($this->{$this->vairant}->fillables));

        if($type_abonnement_id === 0 && $type_abonnement === "CANTINE"){
            $data['type_abonnement_id'] = 0;
            $data['type_abonnement'] = 'CANTINE';
            $data['description'] = 'Cantine';
        }else{
            $activite = DBTable::getModel('activite')->select(['id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->where('code', '=', $type_abonnement_code)->one();
            $data['type_abonnement_id'] = $activite['id'];
            $data['type_abonnement'] = 'ACTIVITE';
            $data['description'] = $activite['libelle'];
        }

        $clause = [ 'code' => $code ];
        $result = $this->{$this->vairant}->update($data, $clause);

        if ($result) {
            $items = $this->getall();
            $data = HTMLHelper::genBodyTable($items, $this->class_name, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $this->{$this->vairant}->fillables));
            $this->sendResponseAndExit($data);
        } else {
            $this->sendResponseAndExit($data, false, 400, 'DB Error');
        }
    }

    public function delete($code)
    {
        $result = $this->{$this->vairant}->delete('code', $code);
        if ($result) {
            $items = $this->getall();
            $data = HTMLHelper::genBodyTable($items, $this->class_name, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $this->{$this->vairant}->fillables));
            $this->sendResponseAndExit($data);
        } else {
            $this->sendResponseAndExit($code, false, 400, 'DB Error');
        }
    }

    public function getall()
    {
        $model = PrixAbonnement::table();
        $results = $model->select(
            [
            new Ex('case when type_abonnement=\'CANTINE\' then \'Cantine\' else activite.libelle end as type_abonnement_id'),
            'prix_abonnement.type_abonnement_id' => 'motif_id',
            'prix_abonnement.code' => 'code',
            'prix_abonnement.montant' => 'montant',
            'prix_abonnement.periode' => 'periode',
            'prix_abonnement.description' => 'description']
        )
        ->where('prix_abonnement.visibilite', 1)
        ->whereNotNull('prix_abonnement.type_abonnement_id')
        ->join('activite', 'prix_abonnement.type_abonnement_id', '=', 'activite.id')->get();

        return $results;
    }
}
