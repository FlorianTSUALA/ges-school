<?php

namespace App\Controller;

use App\App;
use DateTime;
use App\Helpers\S;
use App\Model\Pays;
use App\Model\Eleve;
use App\Model\Classe;
use Core\Routing\URL;
use App\Model\Parcours;
use Core\Session\Request;
use App\Model\SalleClasse;
use App\Model\AnneeScolaire;

use function Core\Helper\dd;
use App\Model\DossierParental;
use App\Model\StatutApprenant;
use App\Repository\EleveRepository;
use App\Controller\Admin\AppController;

class InscriptionController extends AppController
{
    /**
     * Initialise les Models qu'on charge dans ce controller
     **/
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('pays');
        $this->loadModel('statut_apprenant');
        $this->loadModel('classe');
        $this->loadModel('salle_classe');
        $this->loadModel('annee_scolaire');

        $this->loadModel('dossier_parental');
        $this->loadModel('dossier_medical');
        $this->loadModel('antecedent_scolaire');
        $this->loadModel('eleve');
        $this->loadModel('parcours');
    }

    public function index()
    {
        $this->app->setTitle('Inscription d\'un(e) élève  - Ges-School');
        $route = "inscrire";
        $pays = $this->pays->all();
        $classes = $this->classe->all();
        $salle_classes = $this->salle_classe->all();
        $statut_apprenants = $this->statut_apprenant->all();
        $annee_scolaires =  $this->annee_scolaire->all();
        $this->render('sections.inscription.inscription', compact('route', 'annee_scolaires', 'pays', 'classes', 'statut_apprenants', 'salle_classes'));
    }

    /**
     * permet la connexion d'utilisateur à la BD
     **/
    public function inscrire()
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

        
        $matricule =  (new EleveRepository())->getMatricule() ;

        $photo_name = Request::saveImg($matricule);
        if ($photo_name === 1) {
            $photo_name = 'no-photo.jpg';
        }


        $data_eleve = [
            'code' => $code_eleve,
            'matricule' => $matricule,
            'nom' => Request::getSecParam('nom_eleve', ''),
            'prenom' => Request::getSecParam('prenom_eleve', ''),
            'prenom_usage' => Request::getSecParam('prenom_usage', ''),
            'lieu_naissance' => Request::getSecParam('lieu_naissance_eleve', ''),
            'date_naissance' => Request::getSecParam('date_naissance_eleve', ''),
            'sexe' => Request::getSecParam('sexe_eleve', ''),
            'photo' => $photo_name,
            Eleve::PAYS_ID => $this->pays->id(Request::getSecParam('pays_eleve', ''), Pays::LIBELLE),
            'anciennete' => (Request::getSecParam('anciennete_eleve', '') === '')? 0 : Request::getSecParam('anciennete_eleve', ''),
            Eleve::DOSSIER_PARENTAL_ID => $id_dossier_parental,
            Eleve::GROUPE_FAMILIAL_ID => null,
            Eleve::DOSSIER_MEDICAL_ID => $id_dossier_medical,
            Eleve::ANTECEDENT_SCOLAIRE_ID => $id_antecedent_scolaire,
        ];

        $result_eleve = $this->eleve->save($data_eleve);
        $id_eleve = $this->eleve->id($code_eleve);

        $id_salle_classe = $this->salle_classe->id(Request::getSecParam('salle_classe_eleve', ''), SalleClasse::LIBELLE);
        $id_salle_classe = ($id_salle_classe == false) ? null : $id_salle_classe;

        $id_annee_scolaire = $this->annee_scolaire->id(Request::getSecParam('annee_scolaire', ''), AnneeScolaire::LIBELLE);
        $code_annee_scolaire = $this->annee_scolaire->code(Request::getSecParam('annee_scolaire', ''), AnneeScolaire::LIBELLE);
        //PARCOURS ELEVE
        $code_parcours = $this->parcours->genCode();
        $data_parcours = [
            'code' => $code_parcours,
            Parcours::ANNEE_SCOLAIRE_ID => $id_annee_scolaire,
            'date_inscription' => (new DateTime('NOW'))->format('Y-m-d H:i:s'),
            Parcours::ELEVE_ID => $id_eleve,
            Parcours::STATUT_APPRENANT_ID => $this->statut_apprenant->id(Request::getSecParam('statut_apprenant_eleve', ''), StatutApprenant::LIBELLE),
            Parcours::CLASSE_ID => $this->classe->id(Request::getSecParam('classe_eleve', ''), Classe::LIBELLE),
            Parcours::SALLE_CLASSE_ID => $id_salle_classe,
        ];

        $result_parcours = $this->parcours->save($data_parcours);
        $id_parcours = $this->parcours->id($code_parcours);


        if ($result_antecedent_scolaire && $result_dossier_medical && $result_dossier_parental && $result_eleve && $result_parcours) {

            $code_classe = $this->classe->code(Request::getSecParam('classe_eleve', ''), Classe::LIBELLE) ;

            $msg_inscriptpion = 'Inscription Enregistrée avec success';
            $data_inscriptpion = [];
            $data_inscriptpion['msg_inscriptpion'] = 'Inscription Enregistrée';
            $data_inscriptpion['code_classe'] = $code_classe;
            $data_inscriptpion['code_eleve'] = $code_eleve;
            $data_inscriptpion['nom_eleve'] = Request::getSecParam('nom_eleve', '');
            $data_inscriptpion['prenom_eleve'] = Request::getSecParam('prenom_eleve', '');
            $data_inscriptpion['code_parcours'] = $code_parcours;
            $data_inscriptpion['annee_scolaire'] = Request::getSecParam('annee_scolaire', '');
            $data_inscriptpion['code_annee_scolaire'] = $code_annee_scolaire;
            $_SESSION[S::DATA_TRANSPORT] = $data_inscriptpion;
            $location = URL::link('versement');

            $this->renderAtLocation($location, 'sections.versement.versement_scolarite', compact('data_inscriptpion'));
        } else {
            $this->sendResponseAndExit($result_parcours, false, 400, 'DB Error');
        }
    }
}
