<?php

namespace App\Controller;

use App\Model\Pays;
use App\Model\Eleve;
use App\Model\DBTable;
use App\Helpers\Helpers;
use App\Model\TypeEleve;
use Config\Invariant\API;
use Core\Session\Request;
use App\Model\SalleClasse;
use App\Model\StatutEleve;
use App\Helpers\HTMLHelper;

use function Core\Helper\dd;
use function Core\Helper\vd;
use Core\HTML\Form\FormModel;
use App\Model\DossierParental;
use App\Model\StatutApprenant;

use App\Repository\EleveRepository;
use App\Helpers\TraitCRUDController;
use App\Repository\ClasseRepository;
use ClanCats\Hydrahon\Query\Expression;
use App\Repository\AnneeScolaireRepository;
use ClanCats\Hydrahon\Query\Expression as Ex;


trait EleveControllerTraitCRUD
{

    use TraitCRUDController;

    public function index_eleve_ajout()
    {
        $this->app->setTitle('Inscription d\'un(e) élève  - Ges-School');
        $route = "eleve_ajout";
        $pays = $this->pays->all();
        $classes = $this->classe->all();
        $salle_classes = $this->salle_classe->all();
        $statut_eleves = $this->statut_eleve->all();
        $annee_scolaires =  $this->annee_scolaire->all();
        $data_info_eleves = $this->eleve_repository->getInfoEleves();
        
        $this->render('sections.scolarite.eleve.ajout.eleve_ajout', compact('route', 'annee_scolaires', 'pays', 'classes', 'statut_eleves', 'salle_classes'));
    }
    /**
     * Affiche la page de mise à jour d'un eleve à partir de son code
     *
     * @param string $code
     * @return page
     */
    public function modifier($code = null)
    {
        if(is_null($code))
            return $this->liste();

        $route = 'eleve_modifier';
        $eleve = $this->eleve_repository->getInfoEleve($code);

        $pays = $this->pays->all();
        $classes = $this->classe->all();
        $salle_classes = $this->salle_classe->all();
        $statut_eleves = $this->statut_eleve->all();
        $annee_scolaires =  $this->annee_scolaire->all();
        $data_info_eleves = $this->eleve_repository->getInfoEleves();
        
        $this->render('sections.scolarite.eleve.modification.eleve_modification', compact('route', 'eleve', 'annee_scolaires', 'pays', 'classes', 'statut_eleves', 'salle_classes'));
    }


    /**
     * permet la connexion d'utilisateur à la BD
     **/
    public function save()
    {
        //ANTECEDANT SCOLAIRE
        $code_antecedent_scolaire = $this->antecedent_scolaire->genCode();
        $data_antecedent_scolaire = [
            'code' => $code_antecedent_scolaire,
            'email' => Request::getSecParam('email', ''),
            'telephone' => Request::getSecParam('telephone', ''),
            'classe' => Request::getSecParam('classe', ''),
            'ecole' => Request::getSecParam('ecole', '')
        ];
        $result_antecedent_scolaire = $this->antecedent_scolaire->save($data_antecedent_scolaire);
        $id_antecedent_scolaire = $this->antecedent_scolaire->id($code_antecedent_scolaire);


        //DOSSIER MEDICAL
        $code_dossier_medical = $this->dossier_medical->genCode();
        $data_dossier_medical = [
            'code' => $code_dossier_medical,
            'autres' => Request::getSecParam('autres', ''),
            'probleme_particulier' => Request::getSecParam('probleme_particulier', ''),
            'email_medecin' => Request::getSecParam('email_medecin', ''),
            'telephone_medecin' => Request::getSecParam('telephone_medecin', ''),
            'nom_medecin' => Request::getSecParam('nom_medecin', ''),
            'maladie_recurrente' => Request::getSecParam('maladie_recurrente', ''),
            'allergie' => Request::getSecParam('allergie', ''),
            'groupe_sanguin' => Request::getSecParam('groupe_sanguin', ''),
        ];
        $result_dossier_medical = $this->dossier_medical->save($data_dossier_medical);
        $id_dossier_medical = $this->dossier_medical->id($code_dossier_medical);
        $id_pays_mere = ($this->pays->id(Request::getSecParam('pays_mere', ''), Pays::LIBELLE) == false)? null : $this->pays->id(Request::getSecParam('pays_mere', ''), Pays::LIBELLE) ;
        $id_pays_pere = ($this->pays->id(Request::getSecParam('pays_pere', ''), Pays::LIBELLE) == false)? null : $this->pays->id(Request::getSecParam('pays_pere', ''), Pays::LIBELLE) ;
        $id_pays = ($this->pays->id(Request::getSecParam('pays_eleve', ''), Pays::LIBELLE) == false)? null : $this->pays->id(Request::getSecParam('pays_eleve', ''), Pays::LIBELLE) ;
        //DOSSIER PARENTAL
        $code_dossier_parental = $this->dossier_parental->genCode();
        $data_dossier_parental = [
            'code' => $code_dossier_parental,
           // 'est_tuteur_mere' => Request::getSecParam('est_tuteur_mere', ''),
            'email_mere' => Request::getSecParam('email_mere', ''),
            'bureau_mere' => Request::getSecParam('bureau_mere', ''),
            'telephone_mere' => Request::getSecParam('telephone_mere', ''),
            'lieu_travail_mere' => Request::getSecParam('lieu_travail_mere', ''),
            'profession_mere' => Request::getSecParam('profession_mere', ''),
            'employeur_mere' => Request::getSecParam('employeur_mere', ''),
            DossierParental::PAYS_MERE_ID => $id_pays_mere,
            'prenom_mere' => Request::getSecParam('prenom_mere', ''),
            'nom_mere' => Request::getSecParam('nom_mere', ''),
            'nom_pere' => Request::getSecParam('nom_pere', ''),
            'prenom_pere' => Request::getSecParam('prenom_pere', ''),
            DossierParental::PAYS_PERE_ID => $id_pays_pere,
            'employeur_pere' => Request::getSecParam('employeur_pere', ''),
            'profession_pere' => Request::getSecParam('profession_pere', ''),
            'lieu_travail_pere' => Request::getSecParam('lieu_travail_pere', ''),
            'telephone_pere' => Request::getSecParam('telephone_pere', ''),
            'bureau_pere' => Request::getSecParam('bureau_pere', ''),
            'email_pere' => Request::getSecParam('email_pere', ''),
           // 'est_tuteur_pere' => Request::getSecParam('est_tuteur_pere', ''),
            'telephone_personne_urgence' => Request::getSecParam('telephone_personne_urgence', ''),
            'nom_personne_urgence' => Request::getSecParam('nom_personne_urgence', ''),
            'prenom_personne_urgence' => Request::getSecParam('prenom_personne_urgence', ''),
            'lien' => Request::getSecParam('lien', ''),
        ];
        $result_dossier_parental = $this->dossier_parental->save($data_dossier_parental);
        $id_dossier_parental = $this->dossier_parental->id($code_dossier_parental);

        //INFO ELEVE
        $code_eleve = $this->eleve->genCode();

        
        $matricule =  $this->eleve_repository->getMatricule() ;

        $photo_name = Request::saveImg($matricule);
        if ($photo_name === 1) {
            $photo_name = 'no-photo.jpg';
        }


        $data_eleve = [
            'code' => $code_eleve,
            'matricule' => $matricule,
            'nom' => strtoupper(Request::getSecParam('nom_eleve', '')) ,
            'prenom' => ucfirst(Request::getSecParam('prenom_eleve', '')) ,
            'prenom_usage' => Request::getSecParam('prenom_usage', ''),
            'lieu_naissance' => Request::getSecParam('lieu_naissance_eleve', ''),
            'date_naissance' => Request::getSecParam('date_naissance_eleve', ''),
            'sexe' => Request::getSecParam('sexe_eleve', ''),
            'pays_id' => $id_pays,
            'photo' => $photo_name,
            Eleve::PAYS_ID => $this->pays->id(Request::getSecParam('pays_eleve', ''), Pays::LIBELLE),
            'anciennete' => (Request::getSecParam('anciennete_eleve', '') === '')? 0 : Request::getSecParam('anciennete_eleve', ''),
            Eleve::STATUT_ELEVE_ID => $this->statut_eleve->id(Request::getSecParam('statut_eleve', ''), StatutEleve::LIBELLE),
            Eleve::DOSSIER_PARENTAL_ID => $id_dossier_parental,
            Eleve::GROUPE_FAMILIAL_ID => null,
            Eleve::DOSSIER_MEDICAL_ID => $id_dossier_medical,
            Eleve::ANTECEDENT_SCOLAIRE_ID => $id_antecedent_scolaire,
        ];

        $result_eleve = $this->eleve->save($data_eleve);

        $id_salle_classe = $this->salle_classe->id(Request::getSecParam('salle_classe_eleve', ''), SalleClasse::LIBELLE);
        $id_salle_classe = ($id_salle_classe == false) ? null : $id_salle_classe;


        if ($result_antecedent_scolaire && $result_dossier_medical && $result_dossier_parental && $result_eleve /*&& $result_parcours*/) {
            $this->sendResponseAndExit(Helpers::toJSON($result_eleve, TRUE));
        } else {
            $this->sendResponseAndExit($result_eleve, false, 400, 'DB Error');
        }
    }
     
    public function liste()
    {
        $route = 'eleve_liste';
        $this->render('sections.scolarite.eleve.liste.eleve_liste', compact( 'route'));
    }

    public function getall_person()
    {
        $model = Eleve::table();
        $results = $model->select('
                type_eleve.libelle as type_eleve_id,
                pays.libelle as pays_id,
                eleve.code as code,
                eleve.nom,
                eleve.prenom,
                eleve.sexe,
                eleve.photo,
                eleve.assurance,
                eleve.telephone,
                eleve.email,
                eleve.adresse,
                eleve.login,
                eleve.password,
                eleve.date_prise_service,
                eleve.date_fin_carriere,
                eleve.bibliographie')
            ->where('eleve.visibilite', 1)
            ->join('type_eleve', 'eleve.type_eleve_id', '=', 'type_eleve.id')
            ->join('pays', 'eleve.pays_id', '=', 'pays.id')
            ->get();


        return $results;
    }

    public function save_person()
    {
        //INFO PERSONNEL
        $code_eleve = Eleve::generateCode();
        
        $matricule = $code_eleve;

        $photo_name = Request::saveImg($matricule . '_photo_profile', 'photo', 'img/eleve');
        if ($photo_name === 1) {
            $photo_name = 'no-photo.jpg';
        }

        $piece_jointes ='photo_autres';
        $photo_peices_jointes = Request::saveImg($matricule . '_photo_peices_jointes', 'photo_autres', 'img/eleve');
        if ($photo_peices_jointes === 1) {
            $photo_peices_jointes = 'attachement.jpg';
        }
        
        $password = Request::getSecParam('password', '');
        if($password != '' && $password != 'aucun'){
            $data_info_eleves['password'] = Helpers::passwordEncrypt($password);
        }

        $data_eleve = [
            'type_eleve_id' =>  Eleve::getId(DBTable::TYPE_PERSONNEL, Request::getSecParam('type_eleve', ''), TypeEleve::CODE),
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
            'code' => $code_eleve,
            'photo' => $photo_name
        ];

        $result_eleve = Eleve::table()->insert($data_eleve)->execute();
        $result_eleve = true;
        

        if ($result_eleve) {
            $this->sendResponseAndExit(Helpers::toJSON($result_eleve, TRUE));
        } else {
            $this->sendResponseAndExit($result_eleve, false, 400, 'DB Error');
        }
    }

    /**
     * update : permet de mettre à jour un eleve en base de données grace 
     * aux données envoyées en post par le formulaire grace à son code
     *
     * @param string $code
     * @return void
     */
    public function update($code)
    {
        //INFO PERSONNEL
        $code_eleve = $code;

        $matricule = $code_eleve;

        if(isset($_FILES['photo']))
        {
            $photo_name = Request::saveImg($matricule . '_photo_profile', 'photo', 'img/eleve');
            if ($photo_name === 1) {
                $photo_name = 'no-photo.jpg';
            }
        }
        $piece_jointes ='photo_autres';
        if(isset($_FILES[$piece_jointes])){
            $photo_peices_jointes = Request::saveImg($matricule . '_photo_peices_jointes', $piece_jointes, 'img/eleve');
            if ($photo_peices_jointes === 1) {
                $photo_peices_jointes = 'attachement.jpg';
            }
        }
        

        $data_eleve = [
            'type_eleve_id' =>  Eleve::getId(DBTable::TYPE_PERSONNEL, Request::getSecParam('type_eleve', ''), TypeEleve::CODE),
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
            'assurance' => Request::getSecParam('nom_eleve', '') ,
            'fonction' => Request::getSecParam('fonction', '') ,
            'code' => $code_eleve,
        ];

        $password = Request::getSecParam('password', '');

        if($password != '' && $password != 'aucun'){
            $data_eleve['password'] = Helpers::passwordEncrypt($password);
        }

        // dd($data_info_eleves['password']);
        if($photo_peices_jointes != 'attachement.jpg' &&  $photo_peices_jointes != '' ){
            $data_eleve['pieces_jointes'] =  $photo_peices_jointes;
        }

        if($photo_name != 'no-photo.jpg' && $photo_name != ''){
            $data_eleve['photo'] =  $photo_name;
        }

        $result_eleve = Eleve::table()  ->update($data_eleve)
                                                ->where('code', $code_eleve)
                                                ->execute();
        $result_eleve = true;

        if ($result_eleve) {
            $this->sendResponseAndExit(Helpers::toJSON('Mise à jour réalisée avec sucess !!!', TRUE));
        } else {
            $this->sendResponseAndExit($result_eleve, false, 400, 'DB Error');
        }
    }

    public function apiDeleteEleve($code){
            $data_eleve['visibilite'] = 0;

            $result_eleve = Eleve::table()  ->update($data_eleve)
                                                    ->where('code', $code)
                                                    ->execute();
            $result_eleve = true;
    
            if ($result_eleve) {
                $this->sendResponseAndExit(Helpers::toJSON('Suppression réalisée avec sucess !!!', TRUE));
            } else {
                $this->sendResponseAndExit($result_eleve, false, 400, 'DB Error');
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

        $data[Eleve::PASSWORD] = sha1($data[Eleve::PASSWORD]);

        $result = $this->{$this->vairant}->update($data, $clause);

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

        // $eleves = $this->eleve_repository->getEleveGroupByTypeEleve();   
        $classes = (new ClasseRepository())->getSalleClasseGroupByClasse();
        
        $annee_scolaire_id =  (new AnneeScolaireRepository())->getActive('id');

        $data_info_eleves = $this->eleve_repository->getInfoEleves($annee_scolaire_id);

        // dd($data_info_eleves);
        $this->render('sections.eleve.eleve_salle_classe', compact( 'classes','data_info_eleves'));
    }


    /**
     * @todo not implemented
     *
     * @param code eleve $id
     * @return Eleve 
     */
    public function getApiEleve($code)  
    {
        $data_info_eleve = $this->eleve_repository->getInfoEleve($code);
        echo Helpers::toJSON($data_info_eleve);
    }


    public function getApiEleves()  
    {
        $code = Request::getSecParam('code', NULL);
        $filter_by = Request::getSecParam('filter_by', 'ALL');

        $annee_scolaire_id =  (new AnneeScolaireRepository())->getActive('id');

        if($filter_by === 'ALL'){
            $data_info_eleves = $this->eleve_repository->getInfoEleves();
        }else{
            // $type_eleve_id = Model::getId(DBTable::TYPE_PERSONNEL, $code);
            // $data_info_eleves = $this->eleve_repository->getInfoEleves($annee_scolaire_id, $type_eleve_id);
        }
        
        $results[API::TAG_STATUS] = API::TAG_SUCCESS;
        $results[API::TAG_DATATABLE_DR] = API::TAG_DATATABLE_VALUE_DR;
        $results[API::TAG_DATATABLE_RT] = count($data_info_eleves);
        $results[API::TAG_DATATABLE_RF] = count($data_info_eleves);
        $results[API::TAG_DATA] = $data_info_eleves;
        echo Helpers::toJSON($results) ;
    }

    public function getApiAllEssentiel()  
    {
        $eleves = Helpers::toJSON(Eleve::table()->select([ 'id' => 'id' , new Expression("concat(nom,' ',prenom) as value")])->where('visibilite', 1)->get());
        $this->sendResponseAndExit(Helpers::toJSON($eleves, TRUE));
    }


}
