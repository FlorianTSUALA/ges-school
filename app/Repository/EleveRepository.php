<?php

namespace App\Repository;

use DateTime;
use App\Model\Eleve;
use App\Model\DBTable;
use App\Model\Parcours;
use App\Helpers\Helpers;
use App\Model\AnneeScolaire;
use Core\Repository\BaseRepository;
use ClanCats\Hydrahon\Query\Expression;
use Core\helper\DateHelpers;

use function Core\Helper\dd;
use App\Helpers\S;

class EleveRepository extends BaseRepository{
    
    /**
     * @version ok
     */
    public function __construct() {
    }
    
    /**
     * @version ok
     */
    public function getEleve($eleve_code = NULL)
    {
        $model = DBTable::getModel('eleve')
        ->select(
            [
                new Expression("concat(eleve.nom,' ',eleve.prenom) AS nom_complet"),
                'eleve.code' => 'id',
                'eleve.matricule' => 'matricule',
                'eleve.date_naissance' => 'date_naissance',
                'eleve.lieu_naissance' => 'lieu_naissance'
            ]
        )->where('visibilite', '=', 1);
        if(is_null($eleve_code)){
            return $model->get();
        }else{
            return $model->where('code', '=', $eleve_code)->one();
        }
    }

    /**
     * @version stable
     * @uses in VesementController.php
     */
    public function getEleveParcours($annee_scolaire_id, $eleve_code = NULL)
    {
        $model = DBTable::getModel('eleve')
        ->select(
            [
                new Expression("concat(eleve.nom,' ',eleve.prenom) AS libelle"),
                'eleve.code' => 'id',
                'eleve.matricule' => 'matricule',
                'eleve.date_naissance' => 'date_naissance',
                'eleve.lieu_naissance' => 'lieu_naissance',
                'parcours.classe_id' => 'classe_id'
            ]
        )
        ->join(DBTable::PARCOURS, 'parcours.eleve_id', '=', 'eleve.id')
        ->where('eleve.visibilite', '=', 1);

        if(!is_null($annee_scolaire_id)){
            $model = $model->where('parcours.annee_scolaire_id', '=', $annee_scolaire_id);
        }else{
            return null;   
        }

        if(is_null($eleve_code)){
            $model = $model->get();
        }else{
            $model = $model->where('code', '=', $eleve_code)->one();
        }

        return $model;
        
    }
    
    /**
     * using in eleve liste
     * @author Prodigit <prodigit7@gmail.com>
     * @return void
     */
    public function get_eleve_detail_all(){
        $req =
            "                
            SELECT  InfoEleve.pays_mere AS pays_mere, InfoEleve.pays_pere AS pays_pere,
            InfoEleve.email AS email, InfoEleve.ecole AS ecole,
            InfoEleve.classe_precedente AS classe_precedente, InfoEleve.telephone AS telephone,
            InfoEleve.allergie AS allergie, InfoEleve.groupe_sanguin AS groupe_sanguin,
            InfoEleve.maladie_recurrente AS maladie_recurrente, InfoEleve.probleme_particulier AS probleme_particulier,
            InfoEleve.nom_medecin AS nom_medecin, InfoEleve.telephone_medecin AS telephone_medecin,
            InfoEleve.email_medecin AS email_medecin, InfoEleve.autres AS autres,
            InfoEleve.matricule AS matricule, InfoEleve.nom AS nom,  InfoEleve.prenom_usage AS surnom, InfoEleve.prenom AS prenom, concat(InfoEleve.nom, ' ', InfoEleve.prenom) AS nom_complet,
            InfoEleve.sexe AS sexe,
            InfoEleve.date_naissance AS date_naissance, InfoEleve.lieu_naissance AS lieu_naissance,
            InfoEleve.anciennete AS anciennete, InfoEleve.photo AS photo,
            InfoEleve.statut_eleve_id AS statut_eleve_id, InfoEleve.statut_eleve AS statut_eleve,
            InfoEleve.code AS id, InfoParcours.classe_parcours AS classe, InfoParcours.salle_classe_parcours AS salle_classe
            from
            (
                SELECT  dp.pays_mere AS pays_mere, dp.pays_pere AS pays_pere,
                        antecedent_scolaire.email AS email, antecedent_scolaire.ecole AS ecole,
                        antecedent_scolaire.classe AS classe_precedente, antecedent_scolaire.telephone AS telephone,
                        dossier_medical.allergie AS allergie, dossier_medical.groupe_sanguin AS groupe_sanguin,
                        dossier_medical.maladie_recurrente AS maladie_recurrente, dossier_medical.probleme_particulier AS probleme_particulier,
                        dossier_medical.nom_medecin AS nom_medecin, dossier_medical.telephone_medecin AS telephone_medecin,
                        dossier_medical.email_medecin AS email_medecin, dossier_medical.autres AS autres,
                        eleve.id AS id, eleve.code AS code, eleve.prenom_usage AS prenom_usage,
                        eleve.matricule AS matricule, eleve.nom AS nom, eleve.prenom AS prenom, eleve.sexe AS sexe,
                        eleve.date_naissance AS date_naissance, eleve.lieu_naissance AS lieu_naissance,
                        eleve.anciennete AS anciennete, eleve.photo AS photo,
                        statut_eleve.code AS statut_eleve_id, statut_eleve.libelle AS statut_eleve
                from
                    (
                        SELECT dossier_parental.id AS id, pp.libelle AS pays_pere, pm.libelle AS pays_mere
                        FROM dossier_parental
                        LEFT  JOIN  pays AS pp ON pp.id = dossier_parental.pays_pere_id
                        LEFT  JOIN  pays AS pm ON pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        LEFT  JOIN  antecedent_scolaire ON eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        LEFT  JOIN  dossier_medical ON eleve.dossier_medical_id = dossier_medical.id
                        LEFT  JOIN  pays ON pays.id = eleve.pays_id
                        LEFT  JOIN  statut_eleve ON statut_eleve.id = eleve.statut_eleve_id
                WHERE dp.id = eleve.dossier_parental_id  AND eleve.visibilite = 1
            ) InfoEleve,
            (
               SELECT  parcours.eleve_id AS id, parcours.date_inscription AS date_inscription, classe.libelle AS classe_parcours,
                       annee_scolaire.debut_annee AS annee_scolaire, annee_scolaire.statut AS statut_annee_scolaire, statut_apprenant.libelle AS statut_apprenant,
                       salle_classe.libelle AS salle_classe_parcours
               FROM parcours
               LEFT  JOIN  classe ON classe.id = parcours.classe_id
               LEFT  JOIN  statut_apprenant ON statut_apprenant.id = parcours.statut_apprenant_id
               LEFT  JOIN  salle_classe ON salle_classe.id = parcours.salle_classe_id
               LEFT  JOIN  annee_scolaire ON annee_scolaire.id = parcours.annee_scolaire_id
               #WHERE annee_scolaire.statut = 1
            )  InfoParcours
           WHERE InfoEleve.id = InfoParcours.id
           ORDER BY InfoParcours.date_inscription
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

    /**
     * using in eleve liste
     * @author Prodigit <prodigit7@gmail.com>
     * @return void
     */
    public function get_eleve_detail($value, $tag = 'code'){
       
        $req =
            "                
            SELECT  InfoEleve.pays_mere AS pays_mere, InfoEleve.pays_pere AS pays_pere,
            InfoEleve.email AS email, InfoEleve.ecole AS ecole,
            InfoEleve.classe AS classe, InfoEleve.telephone AS telephone,
            InfoEleve.allergie AS allergie, InfoEleve.groupe_sanguin AS groupe_sanguin,
            InfoEleve.maladie_recurrente AS maladie_recurrente, InfoEleve.probleme_particulier AS probleme_particulier,
            InfoEleve.nom_medecin AS nom_medecin, InfoEleve.telephone_medecin AS telephone_medecin,
            InfoEleve.email_medecin AS email_medecin, InfoEleve.autres AS autres,
            InfoEleve.matricule AS matricule, InfoEleve.nom AS nom,  InfoEleve.prenom_usage AS prenom_usage, InfoEleve.prenom AS prenom, concat(InfoEleve.nom, ' ', InfoEleve.prenom) AS nom_complet,
            InfoEleve.sexe AS sexe,
            InfoEleve.date_naissance AS date_naissance, InfoEleve.lieu_naissance AS lieu_naissance,
            InfoEleve.anciennete AS anciennete, InfoEleve.photo AS photo,
            InfoEleve.code AS id, InfoEleve.pays AS pays,

            
            InfoEleve.nom_pere AS nom_pere, InfoEleve.prenom_pere AS prenom_pere, InfoEleve.profession_pere AS profession_pere, 
            InfoEleve.employeur_pere AS employeur_pere, InfoEleve.lieu_travail_pere AS lieu_travail_pere, 
            InfoEleve.quartier_pere AS quartier_pere, InfoEleve.telephone_pere AS telephone_pere, 
            InfoEleve.ville_pere AS ville_pere, InfoEleve.bureau_pere AS bureau_pere, InfoEleve.est_tuteur AS est_tuteur, 
            InfoEleve.email_pere AS email_pere, InfoEleve.signature_pere AS signature_pere, InfoEleve.nom_mere AS nom_mere, 
            InfoEleve.prenom_mere AS prenom_mere, InfoEleve.profession_mere AS profession_mere, 
            InfoEleve.employeur_mere AS employeur_mere, InfoEleve.lieu_travail_mere AS lieu_travail_mere, 
            InfoEleve.quartier_mere AS quartier_mere, InfoEleve.telephone_mere AS telephone_mere, 
            InfoEleve.ville_mere AS ville_mere, InfoEleve.bureau_mere AS bureau_mere, InfoEleve.est_tutrice AS est_tutrice, 
            InfoEleve.email_mere AS email_mere, InfoEleve.signature_mere AS signature_mere, 
            InfoEleve.nom_personne_urgence AS nom_personne_urgence, InfoEleve.prenom_personne_urgence AS prenom_personne_urgence, 
            InfoEleve.telephone_personne_urgence AS telephone_personne_urgence, InfoEleve.lien AS lien,
            InfoEleve.statut_eleve_id AS statut_eleve_id, InfoEleve.statut_eleve AS statut_eleve
            from
            (
                SELECT  dp.pays_mere AS pays_mere, dp.pays_pere AS pays_pere,
                        antecedent_scolaire.email AS email, antecedent_scolaire.ecole AS ecole,
                        antecedent_scolaire.classe AS classe, antecedent_scolaire.telephone AS telephone,
                        dossier_medical.allergie AS allergie, dossier_medical.groupe_sanguin AS groupe_sanguin,
                        dossier_medical.maladie_recurrente AS maladie_recurrente, dossier_medical.probleme_particulier AS probleme_particulier,
                        dossier_medical.nom_medecin AS nom_medecin, dossier_medical.telephone_medecin AS telephone_medecin,
                        dossier_medical.email_medecin AS email_medecin, dossier_medical.autres AS autres,
                        eleve.id AS id, eleve.code AS code, eleve.prenom_usage AS prenom_usage,
                        eleve.matricule AS matricule, eleve.nom AS nom, eleve.prenom AS prenom, eleve.sexe AS sexe,
                        eleve.date_naissance AS date_naissance, eleve.lieu_naissance AS lieu_naissance,
                        eleve.anciennete AS anciennete, eleve.photo AS photo, pays.libelle AS pays,
                        statut_eleve.code AS statut_eleve_id, statut_eleve.libelle AS statut_eleve,

                        dp.nom_pere AS nom_pere, dp.prenom_pere AS prenom_pere, dp.profession_pere AS profession_pere, 
                        dp.employeur_pere AS employeur_pere, dp.lieu_travail_pere AS lieu_travail_pere, 
                        dp.quartier_pere AS quartier_pere, dp.telephone_pere AS telephone_pere, 
                        dp.ville_pere AS ville_pere, dp.bureau_pere AS bureau_pere, dp.est_tuteur AS est_tuteur, 
                        dp.email_pere AS email_pere, dp.signature_pere AS signature_pere, dp.nom_mere AS nom_mere, 
                        dp.prenom_mere AS prenom_mere, dp.profession_mere AS profession_mere, 
                        dp.employeur_mere AS employeur_mere, dp.lieu_travail_mere AS lieu_travail_mere, 
                        dp.quartier_mere AS quartier_mere, dp.telephone_mere AS telephone_mere, 
                        dp.ville_mere AS ville_mere, dp.bureau_mere AS bureau_mere, dp.est_tutrice AS est_tutrice, 
                        dp.email_mere AS email_mere, dp.signature_mere AS signature_mere, 
                        dp.nom_personne_urgence AS nom_personne_urgence, dp.prenom_personne_urgence AS prenom_personne_urgence, 
                        dp.telephone_personne_urgence AS telephone_personne_urgence, dp.lien AS lien                         
            
                from
                    (
                        SELECT dossier_parental.id AS id, pp.libelle AS pays_pere, pm.libelle AS pays_mere,

                        dossier_parental.nom_pere AS nom_pere, dossier_parental.prenom_pere AS prenom_pere, dossier_parental.profession_pere AS profession_pere, 
                        dossier_parental.employeur_pere AS employeur_pere, dossier_parental.lieu_travail_pere AS lieu_travail_pere, 
                        dossier_parental.quartier_pere AS quartier_pere, dossier_parental.telephone_pere AS telephone_pere, 
                        dossier_parental.ville_pere AS ville_pere, dossier_parental.bureau_pere AS bureau_pere, dossier_parental.est_tuteur AS est_tuteur, 
                        dossier_parental.email_pere AS email_pere, dossier_parental.signature_pere AS signature_pere, dossier_parental.nom_mere AS nom_mere, 
                        dossier_parental.prenom_mere AS prenom_mere, dossier_parental.profession_mere AS profession_mere, 
                        dossier_parental.employeur_mere AS employeur_mere, dossier_parental.lieu_travail_mere AS lieu_travail_mere, 
                        dossier_parental.quartier_mere AS quartier_mere, dossier_parental.telephone_mere AS telephone_mere, 
                        dossier_parental.ville_mere AS ville_mere, dossier_parental.bureau_mere AS bureau_mere, dossier_parental.est_tutrice AS est_tutrice, 
                        dossier_parental.email_mere AS email_mere, dossier_parental.signature_mere AS signature_mere, 
                        dossier_parental.nom_personne_urgence AS nom_personne_urgence, dossier_parental.prenom_personne_urgence AS prenom_personne_urgence, 
                        dossier_parental.telephone_personne_urgence AS telephone_personne_urgence, dossier_parental.lien AS lien                         
            
                        FROM dossier_parental
                        LEFT  JOIN  pays AS pp ON pp.id = dossier_parental.pays_pere_id
                        LEFT  JOIN  pays AS pm ON pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        LEFT  JOIN  antecedent_scolaire ON eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        LEFT  JOIN  dossier_medical ON eleve.dossier_medical_id = dossier_medical.id
                        LEFT  JOIN  pays ON pays.id = eleve.pays_id
                        LEFT  JOIN  statut_eleve ON statut_eleve.id = eleve.statut_eleve_id
                WHERE dp.id = eleve.dossier_parental_id  AND eleve.$tag = '$value'   AND eleve.visibilite = 1
            ) InfoEleve
        ";
        $result = $this->query($req);
        if(!empty($result)){
            $result = $this->toObject($result)[0];
        }
        return $result;
    }

    /**
     * Undocumented function
     *@author Frank <fckakambi@gmail.com>
     * @param [type] $annee_scolaire_id
     * @version  to_implement
     * @return Boolean
     */
    public function checkIfInParcours($eleve_code, $annee_scolaire_id){
        $req =
        "
            SELECT  InfoEleve.pays_mere AS pays_mere, InfoEleve.pays_pere AS pays_pere,
            InfoEleve.email AS email, InfoEleve.ecole AS ecole,
            InfoEleve.classe AS classe, InfoEleve.telephone AS telephone,
            InfoEleve.allergie AS allergie, InfoEleve.groupe_sanguin AS groupe_sanguin,
            InfoEleve.maladie_recurrente AS maladie_recurrente, InfoEleve.probleme_particulier AS probleme_particulier,
            InfoEleve.nom_medecin AS nom_medecin, InfoEleve.telephone_medecin AS telephone_medecin,
            InfoEleve.email_medecin AS email_medecin, InfoEleve.autres AS autres,
            InfoEleve.matricule AS matricule, InfoEleve.nom AS nom, InfoEleve.prenom AS prenom,
            InfoEleve.sexe AS sexe,
            InfoEleve.date_naissance AS date_naissance, InfoEleve.lieu_naissance AS lieu_naissance,
            InfoEleve.anciennete AS anciennete, InfoEleve.photo AS photo,
            InfoParcours.date_inscription AS date_inscription_parcours, InfoParcours.classe AS classe_parcours,
            InfoParcours.statut_annee_scolaire AS statut_annee_scolaire,
            InfoParcours.annee_scolaire AS annee_scolaire, InfoParcours.statut_apprenant AS statut_apprenant
            from
            (
                SELECT  dp.pays_mere AS pays_mere, dp.pays_pere AS pays_pere,
                        antecedent_scolaire.email AS email, antecedent_scolaire.ecole AS ecole,
                        antecedent_scolaire.classe AS classe, antecedent_scolaire.telephone AS telephone,
                        dossier_medical.allergie AS allergie, dossier_medical.groupe_sanguin AS groupe_sanguin,
                        dossier_medical.maladie_recurrente AS maladie_recurrente, dossier_medical.probleme_particulier AS probleme_particulier,
                        dossier_medical.nom_medecin AS nom_medecin, dossier_medical.telephone_medecin AS telephone_medecin,
                        dossier_medical.email_medecin AS email_medecin, dossier_medical.autres AS autres,
                        eleve.matricule AS matricule, eleve.nom AS nom, eleve.prenom AS prenom, eleve.sexe AS sexe,
                        eleve.date_naissance AS date_naissance, eleve.lieu_naissance AS lieu_naissance,
                        eleve.anciennete AS anciennete, eleve.photo AS photo, eleve.id AS id
                from
                    (
                        SELECT dossier_parental.id AS id, pp.libelle AS pays_pere, pm.libelle AS pays_mere
                        FROM dossier_parental
                        LEFT  JOIN  pays AS pp ON pp.id = dossier_parental.pays_pere_id
                        LEFT  JOIN  pays AS pm ON pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        LEFT  JOIN  antecedent_scolaire ON eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        LEFT  JOIN  dossier_medical ON eleve.dossier_medical_id = dossier_medical.id
                        LEFT  JOIN  pays ON pays.id = eleve.pays_id
                WHERE dp.id = eleve.dossier_parental_id

            ) InfoEleve,
            (
                SELECT  parcours.eleve_id AS id, parcours.date_inscription, classe.libelle AS classe_parcours,
                        annee_scolaire.debut_annee AS annee_scolaire, annee_scolaire.statut AS statut_annee_scolaire, statut_apprenant.libelle AS statut_apprenant
                FROM parcours
                LEFT  JOIN  classe ON classe.id = parcours.classe_id
                LEFT  JOIN  statut_apprenant ON statut_apprenant.id = parcours.statut_apprenant_id
                LEFT  JOIN  annee_scolaire ON annee_scolaire.id = parcours.classe_id
                #WHERE annee_scolaire.statut = 1
            )  InfoParcours
            WHERE InfoEleve.id = InfoParcours.id
            ORDER BY InfoParcours.date_inscription
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

    public function getElevesdemissioner($annee_scolaire_id){
        $req =
        "
            SELECT  annee_scolaire.libelle, annee_scolaire.debut_annee, annee_scolaire.fin_annee
            FROM annee_scolaire
            WHERE annee_scolaire.id = $annee_scolaire_id
           
        ";    
        $result = $this->query($req);   
         foreach ($result AS $key)
         $date_passeeD = Helpers::getFullYear($key->debut_annee)-1;
         $date_passeeF = Helpers::getFullYear($key->debut_annee);
         $date_passee_libelle = "{$date_passeeD}-{$date_passeeF}";
         $date_passeeID = (new AnneeScolaireRepository)->getAnneeScolaire($date_passee_libelle, 'libelle', 'id');
         $date_passeeID = intval($date_passeeID );
    }
         
    
    
        /**
     * Undocumented function
     *@author Frank <fckakambi@gmail.com>
     * @param [type] $annee_scolaire_id
     * @version  to_implement
     * @return void
     */
    public function getElevesNonInscris($annee_scolaire_id, $classe_id='ALL'){

        $anneScolairePrecedenteID = (new AnneeScolaireRepository)->get_annee_scolaire_precedente_id($annee_scolaire_id);

        if($anneScolairePrecedenteID == 0)
          return  $this->getElevesSansParcours();
              
         $eleveIscritAnneePreds = $this->get_eleves_inscrits($anneScolairePrecedenteID) ; // eleves inscrit l'an precedent
         $eleveIscritAnneeEncours = $this->get_eleves_inscrits($annee_scolaire_id);

         $datasID = [];
         $datasEleveNonInscrit = [];

         foreach((array)$eleveIscritAnneeEncours AS $eleveIscritAnneeEncour)
                array_push($datasID , $eleveIscritAnneeEncour->id);

         foreach((array)$eleveIscritAnneePreds AS $eleve_annee_precendete){
            if( !(in_array($eleve_annee_precendete->id, $datasID)) ){
                array_push($datasEleveNonInscrit , $eleve_annee_precendete) ;
            } 
         } 
         return $datasEleveNonInscrit;
    }


    /**
     * Undocumented function
     *@author Frank <fckakambi@gmail.com>
     * @param [type] $annee_scolaire_id
     * @version  implemented
     * @return void
     */
    public function get_eleves_inscrits($annee_scolaire_id, $classe_id = 'ALL'){
        
        $clause_classe_filter = ($classe_id == 'ALL') ? "" : "  AND parcours.classe_id = $classe_id";
        // dd($classe_id);
        $req =
        "
            SELECT  InfoEleve.pays_mere AS pays_mere, InfoEleve.pays_pere AS pays_pere,
            InfoEleve.email AS email, InfoEleve.ecole AS ecole, infoEleve.id AS id,
            InfoEleve.classe_antecedant AS classe_antecedant, InfoEleve.telephone AS telephone,
            InfoEleve.allergie AS allergie, InfoEleve.groupe_sanguin AS groupe_sanguin,
            InfoEleve.maladie_recurrente AS maladie_recurrente, InfoEleve.probleme_particulier AS probleme_particulier,
            InfoEleve.nom_medecin AS nom_medecin, InfoEleve.telephone_medecin AS telephone_medecin,
            InfoEleve.email_medecin AS email_medecin, InfoEleve.autres AS autres,
            InfoEleve.matricule AS matricule, InfoEleve.nom AS nom, InfoEleve.prenom AS prenom, concat(InfoEleve.nom,' ',InfoEleve.prenom) AS nom_complet,
            InfoEleve.sexe AS sexe, InfoEleve.code AS id,
            InfoEleve.date_naissance AS date_naissance, InfoEleve.lieu_naissance AS lieu_naissance,
            InfoEleve.anciennete AS anciennete, InfoEleve.photo AS photo,
            InfoParcours.date_inscription AS date_inscription_parcours, InfoParcours.classe AS classe,
            InfoParcours.statut_annee_scolaire AS statut_annee_scolaire, InfoParcours.parcours_salle_classe AS salle_classe,
            InfoParcours.annee_scolaire AS annee_scolaire, InfoParcours.statut_apprenant AS statut_apprenant
            from
            (
                SELECT  dp.pays_mere AS pays_mere, dp.pays_pere AS pays_pere,
                        antecedent_scolaire.email AS email, antecedent_scolaire.ecole AS ecole,
                        antecedent_scolaire.classe AS classe_antecedant, antecedent_scolaire.telephone AS telephone,
                        dossier_medical.allergie AS allergie, dossier_medical.groupe_sanguin AS groupe_sanguin,
                        dossier_medical.maladie_recurrente AS maladie_recurrente, dossier_medical.probleme_particulier AS probleme_particulier,
                        dossier_medical.nom_medecin AS nom_medecin, dossier_medical.telephone_medecin AS telephone_medecin,
                        dossier_medical.email_medecin AS email_medecin, dossier_medical.autres AS autres,
                        eleve.matricule AS matricule, eleve.nom AS nom, eleve.prenom AS prenom, eleve.sexe AS sexe,
                        eleve.date_naissance AS date_naissance, eleve.lieu_naissance AS lieu_naissance,
                        eleve.anciennete AS anciennete, eleve.photo AS photo, eleve.id AS id, eleve.code AS code
                from
                    (
                        SELECT dossier_parental.id AS id, pp.libelle AS pays_pere, pm.libelle AS pays_mere
                        FROM dossier_parental
                        LEFT  JOIN  pays AS pp ON pp.id = dossier_parental.pays_pere_id
                        LEFT  JOIN  pays AS pm ON pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        LEFT  JOIN  antecedent_scolaire ON eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        LEFT  JOIN  dossier_medical ON eleve.dossier_medical_id = dossier_medical.id
                        LEFT  JOIN  pays ON pays.id = eleve.pays_id
                WHERE dp.id = eleve.dossier_parental_id 

            ) InfoEleve,
             (
                SELECT  parcours.eleve_id AS id, parcours.date_inscription AS date_inscription, classe.libelle AS classe, salle_classe.libelle AS parcours_salle_classe,
                        annee_scolaire.debut_annee AS annee_scolaire, annee_scolaire.statut AS statut_annee_scolaire, statut_apprenant.libelle AS statut_apprenant
                FROM parcours
                LEFT  JOIN  classe ON classe.id = parcours.classe_id
                LEFT  JOIN  statut_apprenant ON statut_apprenant.id = parcours.statut_apprenant_id
                LEFT  JOIN  salle_classe ON salle_classe.id = parcours.salle_classe_id
                LEFT  JOIN  annee_scolaire ON annee_scolaire.id = parcours.annee_scolaire_id
                WHERE annee_scolaire.id = $annee_scolaire_id $clause_classe_filter
             )  InfoParcours
            where InfoEleve.id = InfoParcours.id
            order by nom_complet
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

    //eleves sans parcours

    public function getElevesSansParcours(){
        $req =
        "
            SELECT  InfoEleve.pays_mere AS pays_mere, InfoEleve.pays_pere AS pays_pere,
            InfoEleve.email AS email, InfoEleve.ecole AS ecole, infoEleve.id AS id,
            InfoEleve.classe_antecedant AS classe_antecedant, InfoEleve.telephone AS telephone,
            InfoEleve.allergie AS allergie, InfoEleve.groupe_sanguin AS groupe_sanguin,
            InfoEleve.maladie_recurrente AS maladie_recurrente, InfoEleve.probleme_particulier AS probleme_particulier,
            InfoEleve.nom_medecin AS nom_medecin, InfoEleve.telephone_medecin AS telephone_medecin,
            InfoEleve.email_medecin AS email_medecin, InfoEleve.autres AS autres,
            InfoEleve.matricule AS matricule, InfoEleve.nom AS nom, InfoEleve.prenom AS prenom, concat(InfoEleve.nom,' ',InfoEleve.prenom) AS nom_complet,
            InfoEleve.sexe AS sexe,
            InfoEleve.date_naissance AS date_naissance, InfoEleve.lieu_naissance AS lieu_naissance,
            InfoEleve.anciennete AS anciennete, InfoEleve.photo AS photo
            from
            (
                SELECT  dp.pays_mere AS pays_mere, dp.pays_pere AS pays_pere,
                        antecedent_scolaire.email AS email, antecedent_scolaire.ecole AS ecole,
                        antecedent_scolaire.classe AS classe_antecedant, antecedent_scolaire.telephone AS telephone,
                        dossier_medical.allergie AS allergie, dossier_medical.groupe_sanguin AS groupe_sanguin,
                        dossier_medical.maladie_recurrente AS maladie_recurrente, dossier_medical.probleme_particulier AS probleme_particulier,
                        dossier_medical.nom_medecin AS nom_medecin, dossier_medical.telephone_medecin AS telephone_medecin,
                        dossier_medical.email_medecin AS email_medecin, dossier_medical.autres AS autres,
                        eleve.matricule AS matricule, eleve.nom AS nom, eleve.prenom AS prenom, eleve.sexe AS sexe,
                        eleve.date_naissance AS date_naissance, eleve.lieu_naissance AS lieu_naissance,
                        eleve.anciennete AS anciennete, eleve.photo AS photo, eleve.id AS id
                from
                    (
                        SELECT dossier_parental.id AS id, pp.libelle AS pays_pere, pm.libelle AS pays_mere
                        FROM dossier_parental
                        LEFT  JOIN  pays AS pp ON pp.id = dossier_parental.pays_pere_id
                        LEFT  JOIN  pays AS pm ON pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        LEFT  JOIN  antecedent_scolaire ON eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        LEFT  JOIN  dossier_medical ON eleve.dossier_medical_id = dossier_medical.id
                        LEFT  JOIN  pays ON pays.id = eleve.pays_id
                WHERE dp.id = eleve.dossier_parental_id  AND eleve.visibilite = 1

            ) InfoEleve
            WHERE id  NOT IN
              (SELECT  parcours.eleve_id FROM parcours)
        ";   
           
       
        $result = (new self)->query($req);
        return (new self)->toObject($result);

      


    }

    /**
     * Undocumented function
     *@author Frank <fckakambi@gmail.com>
     * @param [type] $annee_scolaire_id
     * @version  to_implement
     * @return void
     */
    public  function getEleveInscri($eleve_code, $annee_scolaire_id){
        $req =
        "
            SELECT  InfoEleve.pays_mere AS pays_mere, InfoEleve.pays_pere AS pays_pere,
            InfoEleve.email AS email, InfoEleve.ecole AS ecole, infoEleve.id AS id,
            InfoEleve.classe AS classe, InfoEleve.telephone AS telephone,
            InfoEleve.allergie AS allergie, InfoEleve.groupe_sanguin AS groupe_sanguin,
            InfoEleve.maladie_recurrente AS maladie_recurrente, InfoEleve.probleme_particulier AS probleme_particulier,
            InfoEleve.nom_medecin AS nom_medecin, InfoEleve.telephone_medecin AS telephone_medecin,
            InfoEleve.email_medecin AS email_medecin, InfoEleve.autres AS autres,
            InfoEleve.matricule AS matricule, InfoEleve.nom AS nom, InfoEleve.prenom AS prenom,
            InfoEleve.sexe AS sexe,
            InfoEleve.date_naissance AS date_naissance, InfoEleve.lieu_naissance AS lieu_naissance,
            InfoEleve.anciennete AS anciennete, InfoEleve.photo AS photo,
            InfoParcours.date_inscription AS date_inscription_parcours, InfoParcours.classe_parcours AS classe_parcours,
            InfoParcours.statut_annee_scolaire AS statut_annee_scolaire,
            InfoParcours.annee_scolaire AS annee_scolaire, InfoParcours.statut_apprenant AS statut_apprenant
            from
            (
                SELECT  dp.pays_mere AS pays_mere, dp.pays_pere AS pays_pere,
                        antecedent_scolaire.email AS email, antecedent_scolaire.ecole AS ecole,
                        antecedent_scolaire.classe AS classe, antecedent_scolaire.telephone AS telephone,
                        dossier_medical.allergie AS allergie, dossier_medical.groupe_sanguin AS groupe_sanguin,
                        dossier_medical.maladie_recurrente AS maladie_recurrente, dossier_medical.probleme_particulier AS probleme_particulier,
                        dossier_medical.nom_medecin AS nom_medecin, dossier_medical.telephone_medecin AS telephone_medecin,
                        dossier_medical.email_medecin AS email_medecin, dossier_medical.autres AS autres,
                        eleve.matricule AS matricule, eleve.nom AS nom, eleve.prenom AS prenom, eleve.sexe AS sexe,
                        eleve.date_naissance AS date_naissance, eleve.lieu_naissance AS lieu_naissance,
                        eleve.anciennete AS anciennete, eleve.photo AS photo, eleve.id AS id
                from
                    (
                        SELECT dossier_parental.id AS id, pp.libelle AS pays_pere, pm.libelle AS pays_mere
                        FROM dossier_parental
                        LEFT  JOIN  pays AS pp ON pp.id = dossier_parental.pays_pere_id
                        LEFT  JOIN  pays AS pm ON pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        LEFT  JOIN  antecedent_scolaire ON eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        LEFT  JOIN  dossier_medical ON eleve.dossier_medical_id = dossier_medical.id
                        LEFT  JOIN  pays ON pays.id = eleve.pays_id
                WHERE dp.id = eleve.dossier_parental_id  AND eleve.id = $eleve_code

            ) InfoEleve,
             (
                SELECT  parcours.eleve_id AS id, parcours.date_inscription AS date_inscription, classe.libelle AS classe_parcours,
                        annee_scolaire.debut_annee AS annee_scolaire, annee_scolaire.statut AS statut_annee_scolaire, statut_apprenant.libelle AS statut_apprenant
                FROM parcours
                LEFT  JOIN  classe ON classe.id = parcours.classe_id
                LEFT  JOIN  statut_apprenant ON statut_apprenant.id = parcours.statut_apprenant_id
                LEFT  JOIN  annee_scolaire ON annee_scolaire.id = parcours.annee_scolaire_id
                WHERE annee_scolaire.id = $annee_scolaire_id
             )  InfoParcours
            WHERE InfoEleve.id = InfoParcours.id
            ORDER BY InfoParcours.date_inscription
        ";
        $result = (new self)->query($req);
        return (new self)->toObject($result);
    }

    /**
     * @uses EleveController api_eleve_info
     * @since 1.0.0
     * @api api_eleve_info_post
     * @version update
     */ 
    public function info($search = "", $limit = 5){
        $eleve = Eleve::table();

        $eleve = $eleve->select(['eleve.code' => 'id', 'nom', 'prenom', 'photo', 'sexe', 'date_naissance', 'lieu_naissance', 'pays.libelle'=>'pays' ])
                ->join('pays', 'pays.id', '=', 'eleve.pays_id')
                ->where('eleve.visibilite', '=', 1);

        $data = explode(" ", $search);

        foreach($data??[] AS $item){
            $eleve = $eleve->orWhere('eleve.nom', 'like', '%'.$item.'%');
            $eleve = $eleve->orWhere('eleve.prenom', 'like', '%'.$item.'%');
            $eleve = $eleve->orWhere('pays.libelle', 'like', '%'.$item.'%');
            $eleve = $eleve->orWhere('eleve.lieu_naissance', 'like', '%'.$item.'%');
            $eleve = $eleve->orWhere('eleve.date_naissance', 'like', '%'.$item.'%');
        }

        return $eleve->limit($limit)->get();
    }

    /*******************   OLD    *****************************/
    /*******************   OLD    *****************************/
    /*******************   OLD    *****************************/
    /*******************   OLD    *****************************/
    /*******************   OLD    *****************************/


    /**
     * @version old
     */
    public function detail_exp(string $code){
        $eleve = Eleve::table();
        $parcours = Parcours::table();
    
        $eleve = $eleve->select(['id', 'code', 'nom', 'prenom', 'sexe', 'date_naissance', 'lieu_naissance', 'pays.libelle'=>'pays' ])
                ->join('pays', 'pays.id', '=', 'eleve.pays_id')
                ->where('eleve.visibilite', '=', 1)
                ->where('eleve.code', '=', $code)
                ->one();
        
        $parcours = $parcours
                ->select(
                    [
                        'id', 'code', 'nom', 'prenom', 'sexe', 
                        'date_naissance', 
                        'pension_classe.type' => '', 
                        'pension_classe.' => '', 
                        'pays.libelle'=>'pays' 
                    ]
                )
                ->join('eleve', 'eleve.id', '=', 'parcours.eleve_id')
                ->join('eleve', 'eleve.id', '=', 'parcours.eleve_id')
                ->join('pension_classe', 'pension_classe.classe_id', '=', 'parcours.classe_id')
                ->join('eleve', 'eleve.id', '=', 'parcours.eleve_id')
                ->where('parcours.visibilite', '=', 1)
                ->where('parcours.eleve_id', '=', $eleve->id)
                ->one();
            //Add pension classe
    }
    

    public function getEleveInscriptionInfoById($matricule){
        $req =
        "
            SELECT  InfoEleve.pays_mere AS pays_mere, InfoEleve.pays_pere AS pays_pere,
            InfoEleve.email AS email, InfoEleve.ecole AS ecole,
            InfoEleve.classe AS classe, InfoEleve.telephone AS telephone,
            InfoEleve.allergie AS allergie, InfoEleve.groupe_sanguin AS groupe_sanguin,
            InfoEleve.maladie_recurrente AS maladie_recurrente, InfoEleve.probleme_particulier AS probleme_particulier,
            InfoEleve.nom_medecin AS nom_medecin, InfoEleve.telephone_medecin AS telephone_medecin,
            InfoEleve.email_medecin AS email_medecin, InfoEleve.autres AS autres,
            InfoEleve.matricule AS matricule, InfoEleve.nom AS nom, InfoEleve.prenom AS prenom,
            InfoEleve.sexe AS sexe,
            InfoEleve.date_naissance AS date_naissance, InfoEleve.lieu_naissance AS lieu_naissance,
            InfoEleve.anciennete AS anciennete, InfoEleve.photo AS photo,
            InfoParcours.date_inscription AS date_inscription_parcours, InfoParcours.classe AS classe_parcours,
            InfoParcours.statut_annee_scolaire AS statut_annee_scolaire,
            InfoParcours.annee_scolaire AS annee_scolaire, InfoParcours.statut_apprenant AS statut_apprenant
            from
            (
                SELECT  dp.pays_mere AS pays_mere, dp.pays_pere AS pays_pere,
                        antecedent_scolaire.email AS email, antecedent_scolaire.ecole AS ecole,
                        antecedent_scolaire.classe AS classe, antecedent_scolaire.telephone AS telephone,
                        dossier_medical.allergie AS allergie, dossier_medical.groupe_sanguin AS groupe_sanguin,
                        dossier_medical.maladie_recurrente AS maladie_recurrente, dossier_medical.probleme_particulier AS probleme_particulier,
                        dossier_medical.nom_medecin AS nom_medecin, dossier_medical.telephone_medecin AS telephone_medecin,
                        dossier_medical.email_medecin AS email_medecin, dossier_medical.autres AS autres,
                        eleve.matricule AS matricule, eleve.nom AS nom, eleve.prenom AS prenom, eleve.sexe AS sexe,
                        eleve.date_naissance AS date_naissance, eleve.lieu_naissance AS lieu_naissance,
                        eleve.anciennete AS anciennete, eleve.photo AS photo, eleve.id AS id
                from
                    (
                        SELECT dossier_parental.id AS id, pp.libelle AS pays_pere, pm.libelle AS pays_mere
                        FROM dossier_parental
                        LEFT  JOIN  pays AS pp ON pp.id = dossier_parental.pays_pere_id
                        LEFT  JOIN  pays AS pm ON pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        LEFT  JOIN  antecedent_scolaire ON eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        LEFT  JOIN  dossier_medical ON eleve.dossier_medical_id = dossier_medical.id
                        LEFT  JOIN  pays ON pays.id = eleve.pays_id
                WHERE dp.id = eleve.dossier_parental_id

            ) InfoEleve,
            (
                SELECT  parcours.eleve_id AS id, parcours.date_inscription AS date_inscription, classe.libelle AS classe_parcours,
                        annee_scolaire.debut_annee AS annee_scolaire, annee_scolaire.statut AS statut_annee_scolaire, statut_apprenant.libelle AS statut_apprenant
                FROM parcours
                LEFT  JOIN  classe ON classe.id = parcours.classe_id
                LEFT  JOIN  statut_apprenant ON statut_apprenant.id = parcours.statut_apprenant_id
                LEFT  JOIN  annee_scolaire ON annee_scolaire.id = parcours.classe_id
                #WHERE annee_scolaire.statut = 1
            )  InfoParcours
            WHERE InfoEleve.id = InfoParcours.id  AND InfoEleve.matricule=?
            ORDER BY InfoParcours.date_inscription
        ";
        $result = $this->query($req, array($matricule));
        return $this->toObject($result);
    }



    public function getEleveInscriptionInfo(){
        $req =
            "                
            SELECT  InfoEleve.pays_mere AS pays_mere, InfoEleve.pays_pere AS pays_pere,
            InfoEleve.email AS email, InfoEleve.ecole AS ecole,
            InfoEleve.classe AS classe, InfoEleve.telephone AS telephone,
            InfoEleve.allergie AS allergie, InfoEleve.groupe_sanguin AS groupe_sanguin,
            InfoEleve.maladie_recurrente AS maladie_recurrente, InfoEleve.probleme_particulier AS probleme_particulier,
            InfoEleve.nom_medecin AS nom_medecin, InfoEleve.telephone_medecin AS telephone_medecin,
            InfoEleve.email_medecin AS email_medecin, InfoEleve.autres AS autres,
            InfoEleve.matricule AS matricule, InfoEleve.nom AS nom, InfoEleve.prenom AS prenom,
            InfoEleve.sexe AS sexe,
            InfoEleve.date_naissance AS date_naissance, InfoEleve.lieu_naissance AS lieu_naissance,
            InfoEleve.anciennete AS anciennete, InfoEleve.photo AS photo,
            InfoParcours.date_inscription AS date_inscription_parcours, InfoParcours.classe_parcours AS classe_parcours,
            InfoParcours.statut_annee_scolaire AS statut_annee_scolaire,
            InfoParcours.annee_scolaire AS annee_scolaire, InfoParcours.statut_apprenant AS statut_apprenant

            
            from
            (
                SELECT  dp.pays_mere AS pays_mere, dp.pays_pere AS pays_pere,
                        antecedent_scolaire.email AS email, antecedent_scolaire.ecole AS ecole,
                        antecedent_scolaire.classe AS classe, antecedent_scolaire.telephone AS telephone,
                        dossier_medical.allergie AS allergie, dossier_medical.groupe_sanguin AS groupe_sanguin,
                        dossier_medical.maladie_recurrente AS maladie_recurrente, dossier_medical.probleme_particulier AS probleme_particulier,
                        dossier_medical.nom_medecin AS nom_medecin, dossier_medical.telephone_medecin AS telephone_medecin,
                        dossier_medical.email_medecin AS email_medecin, dossier_medical.autres AS autres,
                        eleve.matricule AS matricule, eleve.nom AS nom, eleve.prenom AS prenom, eleve.sexe AS sexe,
                        eleve.date_naissance AS date_naissance, eleve.lieu_naissance AS lieu_naissance,
                        eleve.anciennete AS anciennete, eleve.photo AS photo, eleve.id AS id
                from
                    (
                        SELECT dossier_parental.id AS id, pp.libelle AS pays_pere, pm.libelle AS pays_mere                
                        FROM dossier_parental
                        LEFT  JOIN  pays AS pp ON pp.id = dossier_parental.pays_pere_id
                        LEFT  JOIN  pays AS pm ON pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        LEFT  JOIN  antecedent_scolaire ON eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        LEFT  JOIN  dossier_medical ON eleve.dossier_medical_id = dossier_medical.id
                        LEFT  JOIN  pays ON pays.id = eleve.pays_id
                WHERE dp.id = eleve.dossier_parental_id   AND eleve.visibilite = 1

            ) InfoEleve,
            (
                SELECT  parcours.eleve_id AS id, parcours.eleve_id, parcours.date_inscription AS date_inscription, classe.libelle AS classe_parcours,
                        annee_scolaire.debut_annee AS annee_scolaire, annee_scolaire.statut AS statut_annee_scolaire, statut_apprenant.libelle AS statut_apprenant
                FROM parcours
                LEFT  JOIN  classe ON classe.id = parcours.classe_id
                LEFT  JOIN  statut_apprenant ON statut_apprenant.id = parcours.statut_apprenant_id
                LEFT  JOIN  annee_scolaire ON annee_scolaire.id = parcours.classe_id
                WHERE annee_scolaire.statut = 1
            )  InfoParcours
            WHERE InfoEleve.id = InfoParcours.eleve_id
            ORDER BY InfoParcours.date_inscription

        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

    public function getEleveClass($classe_id){
        $req =
        "   SELECT  InfoEleve.pays_mere AS pays_mere, InfoEleve.pays_pere AS pays_pere,
                    InfoEleve.email AS email, InfoEleve.ecole AS ecole,
                    InfoEleve.classe AS classe, InfoEleve.telephone AS telephone,
                    InfoEleve.allergie AS allergie, InfoEleve.groupe_sanguin AS groupe_sanguin,
                    InfoEleve.maladie_recurrente AS maladie_recurrente, InfoEleve.probleme_particulier AS probleme_particulier,
                    InfoEleve.nom_medecin AS nom_medecin, InfoEleve.telephone_medecin AS telephone_medecin,
                    InfoEleve.email_medecin AS email_medecin, InfoEleve.autres AS autres,
                    InfoEleve.matricule AS matricule, InfoEleve.nom AS nom, InfoEleve.prenom AS prenom,
                    InfoEleve.sexe AS sexe,
                    InfoEleve.date_naissance AS date_naissance, InfoEleve.lieu_naissance AS lieu_naissance,
                    InfoEleve.anciennete AS anciennete, InfoEleve.photo AS photo,
                    InfoParcours.date_inscription AS date_inscription_parcours, InfoParcours.classe_parcours AS classe_parcours,
                    InfoParcours.statut_annee_scolaire AS statut_annee_scolaire,
                    InfoParcours.annee_scolaire AS annee_scolaire, InfoParcours.statut_apprenant AS statut_apprenant
        FROM
        (
            SELECT  dp.pays_mere AS pays_mere, dp.pays_pere AS pays_pere,
                    antecedent_scolaire.email AS email, antecedent_scolaire.ecole AS ecole,
                    antecedent_scolaire.classe AS classe, antecedent_scolaire.telephone AS telephone,
                    dossier_medical.allergie AS allergie, dossier_medical.groupe_sanguin AS groupe_sanguin,
                    dossier_medical.maladie_recurrente AS maladie_recurrente, dossier_medical.probleme_particulier AS probleme_particulier,
                    dossier_medical.nom_medecin AS nom_medecin, dossier_medical.telephone_medecin AS telephone_medecin,
                    dossier_medical.email_medecin AS email_medecin, dossier_medical.autres AS autres,
                    eleve.matricule AS matricule, eleve.nom AS nom, eleve.prenom AS prenom, eleve.sexe AS sexe,
                    eleve.date_naissance AS date_naissance, eleve.lieu_naissance AS lieu_naissance,
                    eleve.anciennete AS anciennete, eleve.photo AS photo, eleve.id AS id
            from
                (
                    SELECT dossier_parental.id AS id, pp.libelle AS pays_pere, pm.libelle AS pays_mere
                    FROM dossier_parental
                    LEFT  JOIN  pays AS pp ON pp.id = dossier_parental.pays_pere_id
                    LEFT  JOIN  pays AS pm ON pm.id = dossier_parental.pays_mere_id
                ) dp,
                eleve
                    LEFT  JOIN  antecedent_scolaire ON eleve.antecedent_scolaire_id = antecedent_scolaire.id
                    LEFT  JOIN  dossier_medical ON eleve.dossier_medical_id = dossier_medical.id
                    LEFT  JOIN  pays ON pays.id = eleve.pays_id
            WHERE dp.id = eleve.dossier_parental_id

        ) InfoEleve,
        (
            SELECT  parcours.eleve_id AS id, parcours.eleve_id, parcours.date_inscription AS date_inscription, classe.libelle AS classe_parcours,
                    annee_scolaire.debut_annee AS annee_scolaire, annee_scolaire.statut AS statut_annee_scolaire, statut_apprenant.libelle AS statut_apprenant
            FROM parcours
            LEFT  JOIN  classe ON classe.id = parcours.classe_id
            LEFT  JOIN  statut_apprenant ON statut_apprenant.id = parcours.statut_apprenant_id
            LEFT  JOIN  annee_scolaire ON annee_scolaire.id = parcours.classe_id
            WHERE parcours.classe_id="+ $classe_id +
    "  )  InfoParcours
            WHERE InfoEleve.id = InfoParcours.eleve_id
            ORDER BY InfoParcours.date_inscription
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }


    /***********************************
     ***********************************
            GESTION DE MATRICULE
     ***********************************
     **********************************/

    public function getMatricule(){
        //$matricule = HelpersBusinessLogic::genMatricule();
        $i = 0;
        $j = 6;

        $year = DBTable::getModel('annee_scolaire')
                ->select()
                ->where(AnneeScolaire::STATUT, 1)
                ->first()[AnneeScolaire::DEBUT_ANNEE];

        $eleve = DBTable::getModel('eleve');
        $lastMatricule = $eleve->select()->last()[Eleve::MATRICULE];

        $lastMatricule = ($eleve->select()->exists())? $lastMatricule : substr(date('Y'), 2, 2).'A000';

        $lastNumber = substr($lastMatricule, 3, 3);
        $character = substr($lastMatricule, 2, 1);

        if($lastNumber == 999){
            $character = Helpers::getIncCharacter($character, 1);
            $lastNumber = 0;
        }

        $this->incNumerToStringLenght($lastNumber);
        $matricule = substr($year, 2, 2).$character.$lastNumber;

        while($eleve->select()->where(Eleve::MATRICULE, '=', $matricule)->exists()){
            $matricule = $this->getMatricule();
        }

        return $matricule;
    }

    private function incNumerToStringLenght(&$number){
        $number = (int)$number;
        $number++;
        if( $number < 10){
            $number = "00".$number;
        }elseif($number < 100){
            $number = "0".$number;
        }
    }

    public function get_parcours_eleve($id_eleve, $annee_scolaire_id = null)
    {
        if(is_null($annee_scolaire_id)){
            $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE);
        }

        $parcours_classe_eleve = DBTable::getModel('parcours')
                                                        ->select(
                                                                [
                                                                    'classe.libelle'=>'libelle', 
                                                                    'classe.id' => 'classe_id',
                                                                    'salle_classe.libelle'=>'libelle', 
                                                                    'salle_classe.id' => 'salle_classe_id',
                                                                ])
                                                        ->join('salle_classe', 'salle_classe.id', '=', 'parcours.salle_classe_id')
                                                        ->join('classe', 'classe.id', '=', 'parcours.classe_id')
                                                        ->where('parcours.visibilite', '=', 1)
                                                        ->where('parcours.annee_scolaire_id', '=', $annee_scolaire_id)
                                                        ->where('salle_classe.visibilite', '=', 1)
                                                        ->where('parcours.eleve_id', '=', $id_eleve)
                                                        ->last();

      if (!empty($parcours_classe_eleve)) {
        return $parcours_classe_eleve;
      }
      else {
        return [];
      }
    }
    
}