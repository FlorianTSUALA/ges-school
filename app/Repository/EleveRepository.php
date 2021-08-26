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
                new Expression("concat(eleve.nom,' ',eleve.prenom) as nom_complet"),
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
                new Expression("concat(eleve.nom,' ',eleve.prenom) as libelle"),
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
    public function getInfoEleves(){
        $req =
            "                
            select  InfoEleve.pays_mere as pays_mere, InfoEleve.pays_pere as pays_pere,
            InfoEleve.email as email, InfoEleve.ecole as ecole,
            InfoEleve.classe as classe, InfoEleve.telephone as telephone,
            InfoEleve.allergie as allergie, InfoEleve.groupe_sanguin as groupe_sanguin,
            InfoEleve.maladie_recurrente as maladie_recurrente, InfoEleve.probleme_particulier as probleme_particulier,
            InfoEleve.nom_medecin as nom_medecin, InfoEleve.telephone_medecin as telephone_medecin,
            InfoEleve.email_medecin as email_medecin, InfoEleve.autres as autres,
            InfoEleve.matricule as matricule, InfoEleve.nom as nom,  InfoEleve.prenom_usage as surnom, InfoEleve.prenom as prenom, concat(InfoEleve.nom, ' ', InfoEleve.prenom) as nom_complet,
            InfoEleve.sexe as sexe,
            InfoEleve.date_naissance as date_naissance, InfoEleve.lieu_naissance as lieu_naissance,
            InfoEleve.anciennete as anciennete, InfoEleve.photo as photo,
            InfoEleve.statut_eleve_id as statut_eleve_id, InfoEleve.statut_eleve as statut_eleve,
            InfoEleve.code as id
            from
            (
                select  dp.pays_mere as pays_mere, dp.pays_pere as pays_pere,
                        antecedent_scolaire.email as email, antecedent_scolaire.ecole as ecole,
                        antecedent_scolaire.classe as classe, antecedent_scolaire.telephone as telephone,
                        dossier_medical.allergie as allergie, dossier_medical.groupe_sanguin as groupe_sanguin,
                        dossier_medical.maladie_recurrente as maladie_recurrente, dossier_medical.probleme_particulier as probleme_particulier,
                        dossier_medical.nom_medecin as nom_medecin, dossier_medical.telephone_medecin as telephone_medecin,
                        dossier_medical.email_medecin as email_medecin, dossier_medical.autres as autres,
                        eleve.id as id, eleve.code as code, eleve.prenom_usage as prenom_usage,
                        eleve.matricule as matricule, eleve.nom as nom, eleve.prenom as prenom, eleve.sexe as sexe,
                        eleve.date_naissance as date_naissance, eleve.lieu_naissance as lieu_naissance,
                        eleve.anciennete as anciennete, eleve.photo as photo,
                        statut_eleve.code as statut_eleve_id, statut_eleve.libelle as statut_eleve
                from
                    (
                        select dossier_parental.id as id, pp.libelle as pays_pere, pm.libelle as pays_mere
                        from dossier_parental
                        left join pays as pp on pp.id = dossier_parental.pays_pere_id
                        left join pays as pm on pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        left join antecedent_scolaire on eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        left join dossier_medical on eleve.dossier_medical_id = dossier_medical.id
                        left join pays on pays.id = eleve.pays_id
                        left join statut_eleve on statut_eleve.id = eleve.statut_eleve_id
                where dp.id = eleve.dossier_parental_id and eleve.visibilite = 1
            ) InfoEleve
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

    /**
     * using in eleve liste
     * @author Prodigit <prodigit7@gmail.com>
     * @return void
     */
    public function getInfoEleve($eleve_code){
       
        $req =
            "                
            select  InfoEleve.pays_mere as pays_mere, InfoEleve.pays_pere as pays_pere,
            InfoEleve.email as email, InfoEleve.ecole as ecole,
            InfoEleve.classe as classe, InfoEleve.telephone as telephone,
            InfoEleve.allergie as allergie, InfoEleve.groupe_sanguin as groupe_sanguin,
            InfoEleve.maladie_recurrente as maladie_recurrente, InfoEleve.probleme_particulier as probleme_particulier,
            InfoEleve.nom_medecin as nom_medecin, InfoEleve.telephone_medecin as telephone_medecin,
            InfoEleve.email_medecin as email_medecin, InfoEleve.autres as autres,
            InfoEleve.matricule as matricule, InfoEleve.nom as nom,  InfoEleve.prenom_usage as prenom_usage, InfoEleve.prenom as prenom, concat(InfoEleve.nom, ' ', InfoEleve.prenom) as nom_complet,
            InfoEleve.sexe as sexe,
            InfoEleve.date_naissance as date_naissance, InfoEleve.lieu_naissance as lieu_naissance,
            InfoEleve.anciennete as anciennete, InfoEleve.photo as photo,
            InfoEleve.code as id, InfoEleve.pays as pays,

            
            InfoEleve.nom_pere as nom_pere, InfoEleve.prenom_pere as prenom_pere, InfoEleve.profession_pere as profession_pere, 
            InfoEleve.employeur_pere as employeur_pere, InfoEleve.lieu_travail_pere as lieu_travail_pere, 
            InfoEleve.quartier_pere as quartier_pere, InfoEleve.telephone_pere as telephone_pere, 
            InfoEleve.ville_pere as ville_pere, InfoEleve.bureau_pere as bureau_pere, InfoEleve.est_tuteur as est_tuteur, 
            InfoEleve.email_pere as email_pere, InfoEleve.signature_pere as signature_pere, InfoEleve.nom_mere as nom_mere, 
            InfoEleve.prenom_mere as prenom_mere, InfoEleve.profession_mere as profession_mere, 
            InfoEleve.employeur_mere as employeur_mere, InfoEleve.lieu_travail_mere as lieu_travail_mere, 
            InfoEleve.quartier_mere as quartier_mere, InfoEleve.telephone_mere as telephone_mere, 
            InfoEleve.ville_mere as ville_mere, InfoEleve.bureau_mere as bureau_mere, InfoEleve.est_tutrice as est_tutrice, 
            InfoEleve.email_mere as email_mere, InfoEleve.signature_mere as signature_mere, 
            InfoEleve.nom_personne_urgence as nom_personne_urgence, InfoEleve.prenom_personne_urgence as prenom_personne_urgence, 
            InfoEleve.telephone_personne_urgence as telephone_personne_urgence, InfoEleve.lien as lien,
            InfoEleve.statut_eleve_id as statut_eleve_id, InfoEleve.statut_eleve as statut_eleve


            
            
            from
            (
                select  dp.pays_mere as pays_mere, dp.pays_pere as pays_pere,
                        antecedent_scolaire.email as email, antecedent_scolaire.ecole as ecole,
                        antecedent_scolaire.classe as classe, antecedent_scolaire.telephone as telephone,
                        dossier_medical.allergie as allergie, dossier_medical.groupe_sanguin as groupe_sanguin,
                        dossier_medical.maladie_recurrente as maladie_recurrente, dossier_medical.probleme_particulier as probleme_particulier,
                        dossier_medical.nom_medecin as nom_medecin, dossier_medical.telephone_medecin as telephone_medecin,
                        dossier_medical.email_medecin as email_medecin, dossier_medical.autres as autres,
                        eleve.id as id, eleve.code as code, eleve.prenom_usage as prenom_usage,
                        eleve.matricule as matricule, eleve.nom as nom, eleve.prenom as prenom, eleve.sexe as sexe,
                        eleve.date_naissance as date_naissance, eleve.lieu_naissance as lieu_naissance,
                        eleve.anciennete as anciennete, eleve.photo as photo, pays.libelle as pays,
                        statut_eleve.code as statut_eleve_id, statut_eleve.libelle as statut_eleve,

                        dp.nom_pere as nom_pere, dp.prenom_pere as prenom_pere, dp.profession_pere as profession_pere, 
                        dp.employeur_pere as employeur_pere, dp.lieu_travail_pere as lieu_travail_pere, 
                        dp.quartier_pere as quartier_pere, dp.telephone_pere as telephone_pere, 
                        dp.ville_pere as ville_pere, dp.bureau_pere as bureau_pere, dp.est_tuteur as est_tuteur, 
                        dp.email_pere as email_pere, dp.signature_pere as signature_pere, dp.nom_mere as nom_mere, 
                        dp.prenom_mere as prenom_mere, dp.profession_mere as profession_mere, 
                        dp.employeur_mere as employeur_mere, dp.lieu_travail_mere as lieu_travail_mere, 
                        dp.quartier_mere as quartier_mere, dp.telephone_mere as telephone_mere, 
                        dp.ville_mere as ville_mere, dp.bureau_mere as bureau_mere, dp.est_tutrice as est_tutrice, 
                        dp.email_mere as email_mere, dp.signature_mere as signature_mere, 
                        dp.nom_personne_urgence as nom_personne_urgence, dp.prenom_personne_urgence as prenom_personne_urgence, 
                        dp.telephone_personne_urgence as telephone_personne_urgence, dp.lien as lien                         
            
                from
                    (
                        select dossier_parental.id as id, pp.libelle as pays_pere, pm.libelle as pays_mere,

                        dossier_parental.nom_pere as nom_pere, dossier_parental.prenom_pere as prenom_pere, dossier_parental.profession_pere as profession_pere, 
                        dossier_parental.employeur_pere as employeur_pere, dossier_parental.lieu_travail_pere as lieu_travail_pere, 
                        dossier_parental.quartier_pere as quartier_pere, dossier_parental.telephone_pere as telephone_pere, 
                        dossier_parental.ville_pere as ville_pere, dossier_parental.bureau_pere as bureau_pere, dossier_parental.est_tuteur as est_tuteur, 
                        dossier_parental.email_pere as email_pere, dossier_parental.signature_pere as signature_pere, dossier_parental.nom_mere as nom_mere, 
                        dossier_parental.prenom_mere as prenom_mere, dossier_parental.profession_mere as profession_mere, 
                        dossier_parental.employeur_mere as employeur_mere, dossier_parental.lieu_travail_mere as lieu_travail_mere, 
                        dossier_parental.quartier_mere as quartier_mere, dossier_parental.telephone_mere as telephone_mere, 
                        dossier_parental.ville_mere as ville_mere, dossier_parental.bureau_mere as bureau_mere, dossier_parental.est_tutrice as est_tutrice, 
                        dossier_parental.email_mere as email_mere, dossier_parental.signature_mere as signature_mere, 
                        dossier_parental.nom_personne_urgence as nom_personne_urgence, dossier_parental.prenom_personne_urgence as prenom_personne_urgence, 
                        dossier_parental.telephone_personne_urgence as telephone_personne_urgence, dossier_parental.lien as lien                         
            
                        from dossier_parental
                        left join pays as pp on pp.id = dossier_parental.pays_pere_id
                        left join pays as pm on pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        left join antecedent_scolaire on eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        left join dossier_medical on eleve.dossier_medical_id = dossier_medical.id
                        left join pays on pays.id = eleve.pays_id
                        left join statut_eleve on statut_eleve.id = eleve.statut_eleve_id
                where dp.id = eleve.dossier_parental_id and eleve.code = '$eleve_code'  and eleve.visibilite = 1
            ) InfoEleve
        ";
        $result = $this->query($req);
        return $this->toObject($result)[0];
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
            select  InfoEleve.pays_mere as pays_mere, InfoEleve.pays_pere as pays_pere,
            InfoEleve.email as email, InfoEleve.ecole as ecole,
            InfoEleve.classe as classe, InfoEleve.telephone as telephone,
            InfoEleve.allergie as allergie, InfoEleve.groupe_sanguin as groupe_sanguin,
            InfoEleve.maladie_recurrente as maladie_recurrente, InfoEleve.probleme_particulier as probleme_particulier,
            InfoEleve.nom_medecin as nom_medecin, InfoEleve.telephone_medecin as telephone_medecin,
            InfoEleve.email_medecin as email_medecin, InfoEleve.autres as autres,
            InfoEleve.matricule as matricule_eleve, InfoEleve.nom as nom_eleve, InfoEleve.prenom as prenom_eleve,
            InfoEleve.sexe as sexe_eleve,
            InfoEleve.date_naissance as date_naissance_eleve, InfoEleve.lieu_naissance as lieu_naissance_eleve,
            InfoEleve.anciennete as anciennete_eleve, InfoEleve.photo as photo_eleve,
            InfoParcours.date_inscription as date_inscription_parcours, InfoParcours.classe as classe_parcours,
            InfoParcours.statut_annee_scolaire as statut_annee_scolaire,
            InfoParcours.annee_scolaire as annee_scolaire, InfoParcours.statut_apprenant as statut_apprenant
            from
            (
                select  dp.pays_mere as pays_mere, dp.pays_pere as pays_pere,
                        antecedent_scolaire.email as email, antecedent_scolaire.ecole as ecole,
                        antecedent_scolaire.classe as classe, antecedent_scolaire.telephone as telephone,
                        dossier_medical.allergie as allergie, dossier_medical.groupe_sanguin as groupe_sanguin,
                        dossier_medical.maladie_recurrente as maladie_recurrente, dossier_medical.probleme_particulier as probleme_particulier,
                        dossier_medical.nom_medecin as nom_medecin, dossier_medical.telephone_medecin as telephone_medecin,
                        dossier_medical.email_medecin as email_medecin, dossier_medical.autres as autres,
                        eleve.matricule as matricule, eleve.nom as nom, eleve.prenom as prenom, eleve.sexe as sexe,
                        eleve.date_naissance as date_naissance, eleve.lieu_naissance as lieu_naissance,
                        eleve.anciennete as anciennete, eleve.photo as photo, eleve.id as id
                from
                    (
                        select dossier_parental.id as id, pp.libelle as pays_pere, pm.libelle as pays_mere
                        from dossier_parental
                        left join pays as pp on pp.id = dossier_parental.pays_pere_id
                        left join pays as pm on pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        left join antecedent_scolaire on eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        left join dossier_medical on eleve.dossier_medical_id = dossier_medical.id
                        left join pays on pays.id = eleve.pays_id
                where dp.id = eleve.dossier_parental_id

            ) InfoEleve,
            (
                select  parcours.eleve_id as id, parcours.date_inscription, classe.libelle as classe_parcours,
                        annee_scolaire.debut_annee as annee_scolaire, annee_scolaire.statut as statut_annee_scolaire, statut_apprenant.libelle as statut_apprenant
                from parcours
                left join classe on classe.id = parcours.classe_id
                left join statut_apprenant on statut_apprenant.id = parcours.statut_apprenant_id
                left join annee_scolaire on annee_scolaire.id = parcours.classe_id
                #where annee_scolaire.statut = 1
            )  InfoParcours
            where InfoEleve.id = InfoParcours.id
            order by InfoParcours.date_inscription
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

    public static function getFullYear($datetime)
    {
        $time = strtotime($datetime);
        return date("Y", $time);
    }

    public function getElevesdemissioner($annee_scolaire_id){
        $req =
        "
            select  annee_scolaire.libelle, annee_scolaire.debut_annee, annee_scolaire.fin_annee
            from annee_scolaire
            where annee_scolaire.id = $annee_scolaire_id
           
        ";    
        $result = $this->query($req);   
         foreach ($result as $key)
         $date_passeeD = self::getFullYear($key->debut_annee)-1;
         $date_passeeF = self::getFullYear($key->debut_annee);
         $date_passee_libelle = "{$date_passeeD}-{$date_passeeF}";
         $date_passeeID = (new AnneeScolaireRepository)->getAnneeScolaireID($date_passee_libelle);
         $date_passeeID = intval($date_passeeID );
        }
         
    /**
     * Undocumented function
     *@author Frank <fckakambi@gmail.com>
     * @param [type] $annee_scolaire_id
     * @version  to_implement
     * @return void
     */
    public function getElevesNonInscris($annee_scolaire_id){

        $anneScolairePrecedenteID = (new AnneeScolaireRepository)->getAnneeScolairePrecedenteID($annee_scolaire_id);
    
         $eleveIscritAnneePreds = (new EleveRepository)->getElevesInscris($anneScolairePrecedenteID) ; // eleves inscrit l'an precedent
         $eleveIscritAnneeEncours = (new EleveRepository)->getElevesInscris($annee_scolaire_id);
         $datasID = array() ;
         $datasEleveNonInscrit = array() ;

         foreach((array)$eleveIscritAnneePreds as $eleveIscritAnneePred){

             foreach((array)$eleveIscritAnneeEncours as $eleveIscritAnneeEncour)
             array_push($datasID , $eleveIscritAnneeEncour->id);  
               
            if( !(in_array($eleveIscritAnneePred->id, $datasID)) ){
                array_push($datasEleveNonInscrit , $eleveIscritAnneePred) ;

            } 
         } 
         return $datasEleveNonInscrit;
        
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
            select  InfoEleve.pays_mere as pays_mere, InfoEleve.pays_pere as pays_pere,
            InfoEleve.email as email, InfoEleve.ecole as ecole, infoEleve.id as id,
            InfoEleve.classe as classe, InfoEleve.telephone as telephone,
            InfoEleve.allergie as allergie, InfoEleve.groupe_sanguin as groupe_sanguin,
            InfoEleve.maladie_recurrente as maladie_recurrente, InfoEleve.probleme_particulier as probleme_particulier,
            InfoEleve.nom_medecin as nom_medecin, InfoEleve.telephone_medecin as telephone_medecin,
            InfoEleve.email_medecin as email_medecin, InfoEleve.autres as autres,
            InfoEleve.matricule as matricule_eleve, InfoEleve.nom as nom_eleve, InfoEleve.prenom as prenom_eleve,
            InfoEleve.sexe as sexe_eleve,
            InfoEleve.date_naissance as date_naissance_eleve, InfoEleve.lieu_naissance as lieu_naissance_eleve,
            InfoEleve.anciennete as anciennete_eleve, InfoEleve.photo as photo_eleve,
            InfoParcours.date_inscription as date_inscription_parcours, InfoParcours.classe_parcours as classe_parcours,
            InfoParcours.statut_annee_scolaire as statut_annee_scolaire,
            InfoParcours.annee_scolaire as annee_scolaire, InfoParcours.statut_apprenant as statut_apprenant
            from
            (
                select  dp.pays_mere as pays_mere, dp.pays_pere as pays_pere,
                        antecedent_scolaire.email as email, antecedent_scolaire.ecole as ecole,
                        antecedent_scolaire.classe as classe, antecedent_scolaire.telephone as telephone,
                        dossier_medical.allergie as allergie, dossier_medical.groupe_sanguin as groupe_sanguin,
                        dossier_medical.maladie_recurrente as maladie_recurrente, dossier_medical.probleme_particulier as probleme_particulier,
                        dossier_medical.nom_medecin as nom_medecin, dossier_medical.telephone_medecin as telephone_medecin,
                        dossier_medical.email_medecin as email_medecin, dossier_medical.autres as autres,
                        eleve.matricule as matricule, eleve.nom as nom, eleve.prenom as prenom, eleve.sexe as sexe,
                        eleve.date_naissance as date_naissance, eleve.lieu_naissance as lieu_naissance,
                        eleve.anciennete as anciennete, eleve.photo as photo, eleve.id as id
                from
                    (
                        select dossier_parental.id as id, pp.libelle as pays_pere, pm.libelle as pays_mere
                        from dossier_parental
                        left join pays as pp on pp.id = dossier_parental.pays_pere_id
                        left join pays as pm on pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        left join antecedent_scolaire on eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        left join dossier_medical on eleve.dossier_medical_id = dossier_medical.id
                        left join pays on pays.id = eleve.pays_id
                where dp.id = eleve.dossier_parental_id and eleve.id = $eleve_code

            ) InfoEleve,
             (
                select  parcours.eleve_id as id, parcours.date_inscription as date_inscription, classe.libelle as classe_parcours,
                        annee_scolaire.debut_annee as annee_scolaire, annee_scolaire.statut as statut_annee_scolaire, statut_apprenant.libelle as statut_apprenant
                from parcours
                left join classe on classe.id = parcours.classe_id
                left join statut_apprenant on statut_apprenant.id = parcours.statut_apprenant_id
                left join annee_scolaire on annee_scolaire.id = parcours.annee_scolaire_id
                where annee_scolaire.id = $annee_scolaire_id
             )  InfoParcours
            where InfoEleve.id = InfoParcours.id
            order by InfoParcours.date_inscription
        ";
        $result = (new self)->query($req);
        dd($result);
        return (new self)->toObject($result);
    }

    /**
     * Undocumented function
     *@author Frank <fckakambi@gmail.com>
     * @param [type] $annee_scolaire_id
     * @version  to_implement
     * @return void
     */
    public function getElevesInscris($annee_scolaire_id){
        $req =
        "
            select  InfoEleve.pays_mere as pays_mere, InfoEleve.pays_pere as pays_pere,
            InfoEleve.email as email, InfoEleve.ecole as ecole, infoEleve.id as id,
            InfoEleve.classe as classe, InfoEleve.telephone as telephone,
            InfoEleve.allergie as allergie, InfoEleve.groupe_sanguin as groupe_sanguin,
            InfoEleve.maladie_recurrente as maladie_recurrente, InfoEleve.probleme_particulier as probleme_particulier,
            InfoEleve.nom_medecin as nom_medecin, InfoEleve.telephone_medecin as telephone_medecin,
            InfoEleve.email_medecin as email_medecin, InfoEleve.autres as autres,
            InfoEleve.matricule as matricule_eleve, InfoEleve.nom as nom_eleve, InfoEleve.prenom as prenom_eleve,
            InfoEleve.sexe as sexe_eleve,InfoEleve.code as code,
            InfoEleve.date_naissance as date_naissance_eleve, InfoEleve.lieu_naissance as lieu_naissance_eleve,
            InfoEleve.anciennete as anciennete_eleve, InfoEleve.photo as photo_eleve,
            InfoParcours.date_inscription as date_inscription_parcours, InfoParcours.classe_parcours as classe_parcours,
            InfoParcours.statut_annee_scolaire as statut_annee_scolaire,
            InfoParcours.annee_scolaire as annee_scolaire, InfoParcours.statut_apprenant as statut_apprenant
            from
            (
                select  dp.pays_mere as pays_mere, dp.pays_pere as pays_pere,
                        antecedent_scolaire.email as email, antecedent_scolaire.ecole as ecole,
                        antecedent_scolaire.classe as classe, antecedent_scolaire.telephone as telephone,
                        dossier_medical.allergie as allergie, dossier_medical.groupe_sanguin as groupe_sanguin,
                        dossier_medical.maladie_recurrente as maladie_recurrente, dossier_medical.probleme_particulier as probleme_particulier,
                        dossier_medical.nom_medecin as nom_medecin, dossier_medical.telephone_medecin as telephone_medecin,
                        dossier_medical.email_medecin as email_medecin, dossier_medical.autres as autres,
                        eleve.matricule as matricule, eleve.nom as nom, eleve.prenom as prenom, eleve.sexe as sexe,
                        eleve.date_naissance as date_naissance, eleve.lieu_naissance as lieu_naissance,
                        eleve.anciennete as anciennete, eleve.photo as photo, eleve.id as id, eleve.code as code
                from
                    (
                        select dossier_parental.id as id, pp.libelle as pays_pere, pm.libelle as pays_mere
                        from dossier_parental
                        left join pays as pp on pp.id = dossier_parental.pays_pere_id
                        left join pays as pm on pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        left join antecedent_scolaire on eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        left join dossier_medical on eleve.dossier_medical_id = dossier_medical.id
                        left join pays on pays.id = eleve.pays_id
                where dp.id = eleve.dossier_parental_id 

            ) InfoEleve,
             (
                select  parcours.eleve_id as id, parcours.date_inscription as date_inscription, classe.libelle as classe_parcours,
                        annee_scolaire.debut_annee as annee_scolaire, annee_scolaire.statut as statut_annee_scolaire, statut_apprenant.libelle as statut_apprenant
                from parcours
                left join classe on classe.id = parcours.classe_id
                left join statut_apprenant on statut_apprenant.id = parcours.statut_apprenant_id
                left join annee_scolaire on annee_scolaire.id = parcours.annee_scolaire_id
                where annee_scolaire.id = $annee_scolaire_id
             )  InfoParcours
            where InfoEleve.id = InfoParcours.id
            order by InfoParcours.date_inscription
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }


    /*******************   OLD    *****************************/
    /*******************   OLD    *****************************/
    /*******************   OLD    *****************************/
    /*******************   OLD    *****************************/
    /*******************   OLD    *****************************/
        /**
     * @version old
     */ 
    public function info(string $search){
        $eleve = Eleve::table();

        $eleve = $eleve->select(['id', 'code', 'nom', 'prenom', 'sexe', 'date_naissance', 'lieu_naissance', 'pays.libelle'=>'pays' ])
                ->join('pays', 'pays.id', '=', 'eleve.pays_id')
                ->where('eleve.visibilite', '=', 1);

        $data = explode(" ", $search);

        foreach($data as $item){
            $eleve = $eleve->orWhere('eleve.nom', 'like', '%'.$item.'%');
            $eleve = $eleve->orWhere('eleve.prenom', 'like', '%'.$item.'%');
        }
        
        $model = $eleve->limit(5)->get();

        echo json_encode($eleves);
        
    }

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
            select  InfoEleve.pays_mere as pays_mere, InfoEleve.pays_pere as pays_pere,
            InfoEleve.email as email, InfoEleve.ecole as ecole,
            InfoEleve.classe as classe, InfoEleve.telephone as telephone,
            InfoEleve.allergie as allergie, InfoEleve.groupe_sanguin as groupe_sanguin,
            InfoEleve.maladie_recurrente as maladie_recurrente, InfoEleve.probleme_particulier as probleme_particulier,
            InfoEleve.nom_medecin as nom_medecin, InfoEleve.telephone_medecin as telephone_medecin,
            InfoEleve.email_medecin as email_medecin, InfoEleve.autres as autres,
            InfoEleve.matricule as matricule_eleve, InfoEleve.nom as nom_eleve, InfoEleve.prenom as prenom_eleve,
            InfoEleve.sexe as sexe_eleve,
            InfoEleve.date_naissance as date_naissance_eleve, InfoEleve.lieu_naissance as lieu_naissance_eleve,
            InfoEleve.anciennete as anciennete_eleve, InfoEleve.photo as photo_eleve,
            InfoParcours.date_inscription as date_inscription_parcours, InfoParcours.classe as classe_parcours,
            InfoParcours.statut_annee_scolaire as statut_annee_scolaire,
            InfoParcours.annee_scolaire as annee_scolaire, InfoParcours.statut_apprenant as statut_apprenant
            from
            (
                select  dp.pays_mere as pays_mere, dp.pays_pere as pays_pere,
                        antecedent_scolaire.email as email, antecedent_scolaire.ecole as ecole,
                        antecedent_scolaire.classe as classe, antecedent_scolaire.telephone as telephone,
                        dossier_medical.allergie as allergie, dossier_medical.groupe_sanguin as groupe_sanguin,
                        dossier_medical.maladie_recurrente as maladie_recurrente, dossier_medical.probleme_particulier as probleme_particulier,
                        dossier_medical.nom_medecin as nom_medecin, dossier_medical.telephone_medecin as telephone_medecin,
                        dossier_medical.email_medecin as email_medecin, dossier_medical.autres as autres,
                        eleve.matricule as matricule, eleve.nom as nom, eleve.prenom as prenom, eleve.sexe as sexe,
                        eleve.date_naissance as date_naissance, eleve.lieu_naissance as lieu_naissance,
                        eleve.anciennete as anciennete, eleve.photo as photo, eleve.id as id
                from
                    (
                        select dossier_parental.id as id, pp.libelle as pays_pere, pm.libelle as pays_mere
                        from dossier_parental
                        left join pays as pp on pp.id = dossier_parental.pays_pere_id
                        left join pays as pm on pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        left join antecedent_scolaire on eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        left join dossier_medical on eleve.dossier_medical_id = dossier_medical.id
                        left join pays on pays.id = eleve.pays_id
                where dp.id = eleve.dossier_parental_id

            ) InfoEleve,
            (
                select  parcours.eleve_id as id, parcours.date_inscription as date_inscription, classe.libelle as classe_parcours,
                        annee_scolaire.debut_annee as annee_scolaire, annee_scolaire.statut as statut_annee_scolaire, statut_apprenant.libelle as statut_apprenant
                from parcours
                left join classe on classe.id = parcours.classe_id
                left join statut_apprenant on statut_apprenant.id = parcours.statut_apprenant_id
                left join annee_scolaire on annee_scolaire.id = parcours.classe_id
                #where annee_scolaire.statut = 1
            )  InfoParcours
            where InfoEleve.id = InfoParcours.id and InfoEleve.matricule=?
            order by InfoParcours.date_inscription
        ";
        $result = $this->query($req, array($matricule));
        return $this->toObject($result);
    }



    public function getEleveInscriptionInfo(){
        $req =
            "                
            select  InfoEleve.pays_mere as pays_mere, InfoEleve.pays_pere as pays_pere,
            InfoEleve.email as email, InfoEleve.ecole as ecole,
            InfoEleve.classe as classe, InfoEleve.telephone as telephone,
            InfoEleve.allergie as allergie, InfoEleve.groupe_sanguin as groupe_sanguin,
            InfoEleve.maladie_recurrente as maladie_recurrente, InfoEleve.probleme_particulier as probleme_particulier,
            InfoEleve.nom_medecin as nom_medecin, InfoEleve.telephone_medecin as telephone_medecin,
            InfoEleve.email_medecin as email_medecin, InfoEleve.autres as autres,
            InfoEleve.matricule as matricule_eleve, InfoEleve.nom as nom_eleve, InfoEleve.prenom as prenom_eleve,
            InfoEleve.sexe as sexe_eleve,
            InfoEleve.date_naissance as date_naissance_eleve, InfoEleve.lieu_naissance as lieu_naissance_eleve,
            InfoEleve.anciennete as anciennete_eleve, InfoEleve.photo as photo_eleve,
            InfoParcours.date_inscription as date_inscription_parcours, InfoParcours.classe_parcours as classe_parcours,
            InfoParcours.statut_annee_scolaire as statut_annee_scolaire,
            InfoParcours.annee_scolaire as annee_scolaire, InfoParcours.statut_apprenant as statut_apprenant,

            
            from
            (
                select  dp.pays_mere as pays_mere, dp.pays_pere as pays_pere,
                        antecedent_scolaire.email as email, antecedent_scolaire.ecole as ecole,
                        antecedent_scolaire.classe as classe, antecedent_scolaire.telephone as telephone,
                        dossier_medical.allergie as allergie, dossier_medical.groupe_sanguin as groupe_sanguin,
                        dossier_medical.maladie_recurrente as maladie_recurrente, dossier_medical.probleme_particulier as probleme_particulier,
                        dossier_medical.nom_medecin as nom_medecin, dossier_medical.telephone_medecin as telephone_medecin,
                        dossier_medical.email_medecin as email_medecin, dossier_medical.autres as autres,
                        eleve.matricule as matricule, eleve.nom as nom, eleve.prenom as prenom, eleve.sexe as sexe,
                        eleve.date_naissance as date_naissance, eleve.lieu_naissance as lieu_naissance,
                        eleve.anciennete as anciennete, eleve.photo as photo, eleve.id as id
                from
                    (
                        select dossier_parental.id as id, pp.libelle as pays_pere, pm.libelle as pays_mere                
                        from dossier_parental
                        left join pays as pp on pp.id = dossier_parental.pays_pere_id
                        left join pays as pm on pm.id = dossier_parental.pays_mere_id
                    ) dp,
                    eleve
                        left join antecedent_scolaire on eleve.antecedent_scolaire_id = antecedent_scolaire.id
                        left join dossier_medical on eleve.dossier_medical_id = dossier_medical.id
                        left join pays on pays.id = eleve.pays_id
                where dp.id = eleve.dossier_parental_id  and eleve.visibilite = 1

            ) InfoEleve,
            (
                select  parcours.eleve_id as id, parcours.eleve_id, parcours.date_inscription as date_inscription, classe.libelle as classe_parcours,
                        annee_scolaire.debut_annee as annee_scolaire, annee_scolaire.statut as statut_annee_scolaire, statut_apprenant.libelle as statut_apprenant
                from parcours
                left join classe on classe.id = parcours.classe_id
                left join statut_apprenant on statut_apprenant.id = parcours.statut_apprenant_id
                left join annee_scolaire on annee_scolaire.id = parcours.classe_id
                #where annee_scolaire.statut = 1
            )  InfoParcours
            where InfoEleve.id = InfoParcours.eleve_id
            order by InfoParcours.date_inscription

        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

    public function getEleveClass($classe_id){
        $req =
        "                select  InfoEleve.pays_mere as pays_mere, InfoEleve.pays_pere as pays_pere,
        InfoEleve.email as email, InfoEleve.ecole as ecole,
        InfoEleve.classe as classe, InfoEleve.telephone as telephone,
        InfoEleve.allergie as allergie, InfoEleve.groupe_sanguin as groupe_sanguin,
        InfoEleve.maladie_recurrente as maladie_recurrente, InfoEleve.probleme_particulier as probleme_particulier,
        InfoEleve.nom_medecin as nom_medecin, InfoEleve.telephone_medecin as telephone_medecin,
        InfoEleve.email_medecin as email_medecin, InfoEleve.autres as autres,
        InfoEleve.matricule as matricule_eleve, InfoEleve.nom as nom_eleve, InfoEleve.prenom as prenom_eleve,
        InfoEleve.sexe as sexe_eleve,
        InfoEleve.date_naissance as date_naissance_eleve, InfoEleve.lieu_naissance as lieu_naissance_eleve,
        InfoEleve.anciennete as anciennete_eleve, InfoEleve.photo as photo_eleve,
        InfoParcours.date_inscription as date_inscription_parcours, InfoParcours.classe_parcours as classe_parcours,
        InfoParcours.statut_annee_scolaire as statut_annee_scolaire,
        InfoParcours.annee_scolaire as annee_scolaire, InfoParcours.statut_apprenant as statut_apprenant
        from
        (
            select  dp.pays_mere as pays_mere, dp.pays_pere as pays_pere,
                    antecedent_scolaire.email as email, antecedent_scolaire.ecole as ecole,
                    antecedent_scolaire.classe as classe, antecedent_scolaire.telephone as telephone,
                    dossier_medical.allergie as allergie, dossier_medical.groupe_sanguin as groupe_sanguin,
                    dossier_medical.maladie_recurrente as maladie_recurrente, dossier_medical.probleme_particulier as probleme_particulier,
                    dossier_medical.nom_medecin as nom_medecin, dossier_medical.telephone_medecin as telephone_medecin,
                    dossier_medical.email_medecin as email_medecin, dossier_medical.autres as autres,
                    eleve.matricule as matricule, eleve.nom as nom, eleve.prenom as prenom, eleve.sexe as sexe,
                    eleve.date_naissance as date_naissance, eleve.lieu_naissance as lieu_naissance,
                    eleve.anciennete as anciennete, eleve.photo as photo, eleve.id as id
            from
                (
                    select dossier_parental.id as id, pp.libelle as pays_pere, pm.libelle as pays_mere
                    from dossier_parental
                    left join pays as pp on pp.id = dossier_parental.pays_pere_id
                    left join pays as pm on pm.id = dossier_parental.pays_mere_id
                ) dp,
                eleve
                    left join antecedent_scolaire on eleve.antecedent_scolaire_id = antecedent_scolaire.id
                    left join dossier_medical on eleve.dossier_medical_id = dossier_medical.id
                    left join pays on pays.id = eleve.pays_id
            where dp.id = eleve.dossier_parental_id

        ) InfoEleve,
        (
            select  parcours.eleve_id as id, parcours.eleve_id, parcours.date_inscription as date_inscription, classe.libelle as classe_parcours,
                    annee_scolaire.debut_annee as annee_scolaire, annee_scolaire.statut as statut_annee_scolaire, statut_apprenant.libelle as statut_apprenant
            from parcours
            left join classe on classe.id = parcours.classe_id
            left join statut_apprenant on statut_apprenant.id = parcours.statut_apprenant_id
            left join annee_scolaire on annee_scolaire.id = parcours.classe_id
            where parcours.classe_id="+ $classe_id +
        ")  InfoParcours
        where InfoEleve.id = InfoParcours.eleve_id
        order by InfoParcours.date_inscription

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
    
}