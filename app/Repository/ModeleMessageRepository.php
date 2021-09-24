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

class ModeleMessageRepository extends BaseRepository{


    public function getEleveParcours($annee_scolaire_id, $eleve_code = NULL){

    }
    
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

    public function get_eleve_detail($value, $tag = 'code'){
       
    }

    public function checkIfInParcours($eleve_code, $annee_scolaire_id){
       
    }
    

    public function getElevesNonInscris($annee_scolaire_id, $classe_id='ALL'){

    }



    public function get_eleves_inscrits($annee_scolaire_id, $classe_id = 'ALL'){
        
    }

    public function getElevesSansParcours(){

    }
    
}