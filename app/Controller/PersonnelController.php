<?php

namespace App\Controller;

use App\Model\Pays;
use Core\Model\Model;
use App\Model\DBTable;
use App\Helpers\Helpers;
use App\Model\Personnel;
use Config\Invariant\API;
use Core\Session\Request;
use App\Helpers\HTMLHelper;

use App\Model\TypePersonnel;
use function Core\Helper\dd;
use function Core\Helper\vd;
use Core\HTML\Form\FormModel;
use App\Helpers\TraitCRUDController;

use App\Repository\ClasseRepository;
use App\Controller\Admin\AppController;
use App\Repository\PersonnelRepository;
use ClanCats\Hydrahon\Query\Expression;
use App\Repository\AnneeScolaireRepository;
use ClanCats\Hydrahon\Query\Expression as Ex;

class PersonnelController extends AppController
{
    use TraitCRUDController;
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::PERSONNEL;
        // $this->folder_view_index = 'personnel.index';

        $this->loadModel($this->vairant);
        $this->loadModel('pays');
        $this->loadModel('type_personnel');
        $this->base_route = 'personnel';
        $this->class_name = 'personnel';

        $this->title_page = 'Gestion du personnel - Ges-School';
        $this->title_home = 'Gestion du personnel';
        $this->create_title = "Ajout d'un personnel";
        $this->view_title = "Information sur un personnel";
        $this->update_title = "Mise à jour des informations du perosnnel";
        $this->delete_title = "Suppression du personnel";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce personnel ";
    }

    public function liste()
    {
        $route = 'personnel_liste';

        $type_personnels = (new PersonnelRepository())->getPersonnelGroupByTypePersonnel();   

        
        $annee_scolaire_id =  (new AnneeScolaireRepository())->getActive('id');

        $data_info_personnels = (new PersonnelRepository())->getInfoPersonnels($annee_scolaire_id);

        // dd($data_info_personnels);
        $this->render('sections.personnel.liste.personnel_liste', compact( 'route', 'data_info_personnels', 'type_personnels'));
    }

    public function getall()
    {
        $model = Personnel::table();
        $results = $model->select('
                type_personnel.libelle as type_personnel_id,
                pays.libelle as pays_id,
                personnel.code as code,
                personnel.nom,
                personnel.prenom,
                personnel.sexe,
                personnel.photo,
                personnel.assurance,
                personnel.telephone,
                personnel.email,
                personnel.adresse,
                personnel.login,
                personnel.password,
                personnel.date_prise_service,
                personnel.date_fin_carriere,
                personnel.bibliographie')
            ->where('personnel.visibilite', 1)
            ->join('type_personnel', 'personnel.type_personnel_id', '=', 'type_personnel.id')
            ->join('pays', 'personnel.pays_id', '=', 'pays.id')
            ->get();


        return $results;
    }


    public function ajout()
    {
        $route = 'ajout_personnel';

        $this->app->setTitle('Ajout d\'un personnel  - Ges-School');
        // $type_personnels = $this->type_personnel->all(); 
        $type_personnels = TypePersonnel::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        // $pays = $this->pays->all();
        $pays = Pays::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get() ;

        $this->render('sections.personnel.ajout.ajout_personnel', compact('route', 'pays',  'type_personnels'));

    }

    /**
     * Affiche la page de mise à jour d'un personnel à partir de son code
     *
     * @param string $code
     * @return page
     */
    public function modifier($code = null)
    {
        if(is_null($code))
            return $this->liste();

        $route = 'modifier_personnel';

        $personnel = Personnel::table()
            ->select(
                [ 
                    'type_personnel_id' => 'type_personnel_id', 
                    'pays_id' => 'pays_id', 
                    'nom' => 'nom', 
                    'prenom' => 'prenom', 
                    'sexe' => 'sexe', 
                    'telephone' => 'telephone', 
                    'email' => 'email', 
                    'adresse' => 'adresse', 
                    'login' => 'login', 
                    // 'password' => 'password', 
                    'date_prise_service' => 'date_prise_service', 
                    'date_fin_carriere' => 'date_fin_carriere', 
                    'bibliographie' => 'bibliographie', 
                    'assurance' => 'assurance', 
                    'fonction' => 'fonction', 
                    'autres' => 'autres', 
                    'pieces_jointes' => 'pieces_jointes', 
                    'code' => 'id', 
                    'photo' => 'photo' 
                    
                ])->where('code', $code)->one();
        // dd($personnel);
        $this->app->setTitle('Mise à jour d\'un personnel  - Ges-School');
        $type_personnels = TypePersonnel::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get();
        $pays = Pays::table()->select([ 'code' => 'id' , 'libelle' => 'value'])->where('visibilite', 1)->get() ;

        $this->render('sections.personnel.modification.modifier_personnel', compact('route', 'pays',  'type_personnels', 'personnel', 'code'));

    }

    public function save()
    {
        //INFO PERSONNEL
        $code_personnel = Personnel::generateCode();
        
        $matricule = $code_personnel;

        $photo_name = Request::saveImg($matricule . '_photo_profile', 'photo', 'img/personnel');
        if ($photo_name === 1) {
            $photo_name = 'no-photo.jpg';
        }

        $piece_jointes ='photo_autres';
        $photo_peices_jointes = Request::saveImg($matricule . '_photo_peices_jointes', 'photo_autres', 'img/personnel');
        if ($photo_peices_jointes === 1) {
            $photo_peices_jointes = 'attachement.jpg';
        }
      
        $password = Request::getSecParam('password', '');
        if($password != '' && $password != 'aucun'){
            $data_info_personnels['password'] = Helpers::passwordEncrypt($password);
        }

        $data_personnel = [
            'type_personnel_id' =>  Personnel::getId(DBTable::TYPE_PERSONNEL, Request::getSecParam('type_personnel', ''), TypePersonnel::CODE),
            'pays_id' =>  Pays::getId(DBTable::PAYS, Request::getSecParam('pays', ''), Pays::CODE),
            'nom' => Request::getSecParam('nom', '') ,
            'prenom' => Request::getSecParam('prenom', '') ,
            'sexe' => Request::getSecParam('sexe', '') ,
            'autres' => Request::getSecParam('autres', '') ,
            'telephone' => Request::getSecParam('telephone', '') ,
            'email' => Request::getSecParam('email', '') ,
            'adresse' => Request::getSecParam('adresse', '') ,
            'login' => Request::getSecParam('login', '') ,
            'password' => $password ,
            'date_prise_service' => Request::getSecParam('date_prise_service', NULL) ,
            // 'date_fin_carriere' => Request::getSecParam('date_fin_carriere', '') ,
            'bibliographie' => Request::getSecParam('bibliographie', '') ,
            'assurance' => Request::getSecParam('assurance', '') ,
            'fonction' => Request::getSecParam('fonction', '') ,
            'pieces_jointes' =>  $photo_peices_jointes ,
            'code' => $code_personnel,
            'photo' => $photo_name
        ];

        $result_personnel = Personnel::table()->insert($data_personnel)->execute();
        $result_personnel = true;
        

        if ($result_personnel) {
            $this->sendResponseAndExit(Helpers::toJSON($result_personnel, TRUE));
        } else {
            $this->sendResponseAndExit($result_personnel, false, 400, 'DB Error');
        }
    }

    /**
     * update : permet de mettre à jour un personnel en base de données grace 
     * aux données envoyées en post par le formulaire grace à son code
     *
     * @param string $code
     * @return void
     */
    public function update($code)
    {
        //INFO PERSONNEL
        $code_personnel = $code;

        $matricule = $code_personnel;

        if(isset($_FILES['photo']))
        {
            $photo_name = Request::saveImg($matricule . '_photo_profile', 'photo', 'img/personnel');
            if ($photo_name === 1) {
                $photo_name = 'no-photo.jpg';
            }
        }
        $piece_jointes ='photo_autres';
        if(isset($_FILES[$piece_jointes])){
            $photo_peices_jointes = Request::saveImg($matricule . '_photo_peices_jointes', $piece_jointes, 'img/personnel');
            if ($photo_peices_jointes === 1) {
                $photo_peices_jointes = 'attachement.jpg';
            }
        }
      

        $data_personnel = [
            'type_personnel_id' =>  Personnel::getId(DBTable::TYPE_PERSONNEL, Request::getSecParam('type_personnel', ''), TypePersonnel::CODE),
            'pays_id' =>  Pays::getId(DBTable::PAYS, Request::getSecParam('pays', ''), Pays::CODE),
            'nom' => Request::getSecParam('nom', '') ,
            'prenom' => Request::getSecParam('prenom', '') ,
            'sexe' => Request::getSecParam('sexe', '') ,
            'autres' => Request::getSecParam('autres', '') ,
            'telephone' => Request::getSecParam('telephone', '') ,
            'email' => Request::getSecParam('email', '') ,
            'adresse' => Request::getSecParam('adresse', '') ,
            'login' => Request::getSecParam('login', '') ,
            'date_prise_service' => Request::getSecParam('date_prise_service', NULL) ,
            // 'date_fin_carriere' => Request::getSecParam('date_fin_carriere', '') ,
            'bibliographie' => Request::getSecParam('bibliographie', '') ,
            'assurance' => Request::getSecParam('nom_personnel', '') ,
            'fonction' => Request::getSecParam('fonction', '') ,
            'code' => $code_personnel,
        ];

        $password = Request::getSecParam('password', '');

        if($password != '' && $password != 'aucun'){
            $data_personnel['password'] = Helpers::passwordEncrypt($password);
        }

        // dd($data_info_personnels['password']);
        if($photo_peices_jointes != 'attachement.jpg' &&  $photo_peices_jointes != '' ){
            $data_personnel['pieces_jointes'] =  $photo_peices_jointes;
        }

        if($photo_name != 'no-photo.jpg' && $photo_name != ''){
            $data_personnel['photo'] =  $photo_name;
        }

        $result_personnel = Personnel::table()  ->update($data_personnel)
                                                ->where('code', $code_personnel)
                                                ->execute();
        $result_personnel = true;

        if ($result_personnel) {
            $this->sendResponseAndExit(Helpers::toJSON('Mise à jour réalisée avec sucess !!!', TRUE));
        } else {
            $this->sendResponseAndExit($result_personnel, false, 400, 'DB Error');
        }
    }

    public function apiDeletePersonnel($code){
         $data_personnel['visibilite'] = 0;

         $result_personnel = Personnel::table()  ->update($data_personnel)
                                                 ->where('code', $code)
                                                 ->execute();
         $result_personnel = true;
 
         if ($result_personnel) {
             $this->sendResponseAndExit(Helpers::toJSON('Suppression réalisée avec sucess !!!', TRUE));
         } else {
             $this->sendResponseAndExit($result_personnel, false, 400, 'DB Error');
         }
    }

    /**
     * aux données envoyées en post par le formulaire grace à son code
     *
     * @param string $code
     * @return void
     */
    public function index_update($code)
    {
        $data = Request::getSecPostParam($this->{$this->vairant}->fillables);
        $data = $this->resolveCode2IdInput($data, $this->fillExternal($this->{$this->vairant}->fillables));
        $clause = [ 'code' => $code ];

        $data[Personnel::PASSWORD] = sha1($data[Personnel::PASSWORD]);

        $result = $this->{$this->vairant}->update($data, $clause);

        if($result){
            $items = $this->getall();
            $data = HTMLHelper::genBodyTable($items, $this->class_name, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $this->{$this->vairant}->fillables));
            $this->sendResponseAndExit($data);
        }else{
            $this->sendResponseAndExit($data, FALSE, 400, 'DB Error');
        }
    }

    public function save1()
    {
        $data = Request::getSecPostParam($this->{$this->vairant}->fillables);
        $data = $this->resolveCode2IdInput($data, $this->fillExternal($this->{$this->vairant}->fillables));
        $data += ['code' => $this->{$this->vairant}->genCode()];

        $data[Personnel::PASSWORD] = sha1($data[Personnel::PASSWORD]);

        $result = $this->{$this->vairant}->save($data);
        if($result){
            $items = $this->getall();
            $data = HTMLHelper::genBodyTable($items, $this->class_name, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $this->{$this->vairant}->fillables));
            $this->sendResponseAndExit($data);
        }else{
            $this->sendResponseAndExit($data, FALSE, 400, 'DB Error');
        }
    }

    public function liste_classe()
    {

        // $personnels = (new PersonnelRepository())->getPersonnelGroupByTypePersonnel();   
        $classes = (new ClasseRepository())->getSalleClasseGroupByClasse();
        
        $annee_scolaire_id =  (new AnneeScolaireRepository())->getActive('id');

        $data_info_personnels = (new PersonnelRepository())->getInfoPersonnels($annee_scolaire_id);

        // dd($data_info_personnels);
        $this->render('sections.personnel.personnel_salle_classe', compact( 'classes','data_info_personnels'));
    }


    /**
     * @todo not implemented
     *
     * @param code personnel $id
     * @return Personnel 
     */
    public function getApiPersonnel($code)  
    {
        $annee_scolaire_id =  (new AnneeScolaireRepository())->getActive('id');

        $data_info_personnels = (new PersonnelRepository())->getInfoPersonnel($annee_scolaire_id, $code);

        // vd( Helpers::toJSON($data_info_personnels));
        echo Helpers::toJSON($data_info_personnels);
    }


    public function getApiPersonnels()  
    {
        $code = Request::getSecParam('code', NULL);
        $filter_by = Request::getSecParam('filter_by', 'ALL');

        $annee_scolaire_id =  (new AnneeScolaireRepository())->getActive('id');

        if($filter_by === 'ALL'){
            $data_info_personnels = (new PersonnelRepository())->getInfoPersonnels($annee_scolaire_id);
        }else{
            $type_personnel_id = Model::getId(DBTable::TYPE_PERSONNEL, $code);
            $data_info_personnels = (new PersonnelRepository())->getInfoPersonnels($annee_scolaire_id, $type_personnel_id);
        }
        
        $results[API::TAG_STATUS] = API::TAG_SUCCESS;
        $results[API::TAG_DATATABLE_DR] = API::TAG_DATATABLE_VALUE_DR;
        $results[API::TAG_DATATABLE_RT] = count($data_info_personnels);
        $results[API::TAG_DATATABLE_RF] = count($data_info_personnels);
        $results[API::TAG_DATA] = $data_info_personnels;
        echo Helpers::toJSON($results) ;
    }

    public function getApiAllEssentiel()  
    {
        $personnels = Helpers::toJSON(Personnel::table()->select([ 'id' => 'id' , new Expression("concat(nom,' ',prenom) as value")])->where('visibilite', 1)->get());
        $this->sendResponseAndExit(Helpers::toJSON($personnels, TRUE));
    }


}