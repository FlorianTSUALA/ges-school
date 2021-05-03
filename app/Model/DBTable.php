<?php

namespace App\Model;

use App\Model\Cours;
use App\Model\Activite;
use App\Model\Composer;
use App\Model\SalleClasse;
use App\Model\VueBulletin;
use App\Model\PensionEleve;
use App\Model\TypeActivite;
use App\Model\PrixAbonnement;

use App\Model\AbonnementDetail;
use App\Model\AbonnementCantine;
use App\Model\InscriptionActivite;
use App\Model\AffectationClasseMatiere;
use App\Model\AffectationPersonnelSalleClasse;

class DBTable
{

    const ACTIVITE = 'activite';
    const TYPE_ACTIVITE = 'type_activite';
    const INSCRIPTION_ACTIVITE = 'inscription_activite';
    const ABONNEMENT_ACTIVITE = 'abonnement_activite';
    const ABONNEMENT_DETAIL = 'abonnement_detail';
    const ABONNEMENT_CANTINE = 'abonnement_cantine';
    const PERSONNEL_ACTIVITE = 'personnel_activite';
    const ABONNEMENT_CONSOMME = 'abonnement_consomme';
    const ABONNEMENT_RESTO = 'abonnement_resto';
    const ANNEE_SCOLAIRE = 'annee_scolaire';
    const ANTECEDENT_SCOLAIRE = 'antecedent_scolaire';
    const CLASSE = 'classe';
    const COMPOSER = 'composer';
    const COURS = 'cours';
    const CYCLE = 'cycle';
    const DEPENSE = 'depense';
    const DETTE = 'dette';
    const DISCIPLINE = 'discipline';
    const DOCUMENT = 'document';
    const DOMAINE = 'domaine';
    const DOSSIER_MEDICAL = 'dossier_medical';
    const DOSSIER_PARENTAL = 'dossier_parental';
    const CAISSE = 'caisse';
    const ELEVE = 'eleve';
    const EMPRUNT = 'emprunt';
    const ETAT_DOCUMENT = 'etat_document';
    const EXEMPLAIRE = 'exemplaire';
    const FACTURE = 'facture';
    const JOUR_OUVRABLE = 'jour_ouvrable';
    const MATIERE = 'matiere';
    const PARCOURS = 'parcours';
    const PAYS = 'pays';
    const PENSION_CLASSE = 'pension_classe';
    const PENSION_ELEVE = 'pension_eleve';
    const PENSION = 'pension';
    const PERIODE = 'periode';
    const PERSONNEL = 'personnel';
    const PLANNING_COURS = 'planning_cours';
    const PLANNING_RESTO = 'planning_resto';
    const REMBOURSEMENT = 'remboursement';
    const REPAS = 'repas';
    const RESERVATION = 'reservation';
    const RESTITUTION = 'restitution';
    const SALAIRE = 'salaire';
    const SALLE_CLASSE = 'salle_classe';
    const SESSION = 'session';
    const STATUT_APPRENANT = 'statut_apprenant';
    const TRANCHE_HORAIRE = 'tranche_horaire';
    const TRANCHE_SCOLAIRE = 'tranche_scolaire';
    const TYPE_PAIEMENT = 'type_paiement';
    const TYPE_PENSION = 'type_pension';
    const TYPE_PERSONNEL = 'type_personnel';
    const PRIX_ABONNEMENT = 'prix_abonnement';

    const AFFECTATION_CLASSE_MATIERE = 'affectation_classe_matiere';
    const AFFECTATION_PERSONNEL_SALLE_CLASSE = 'affectation_personnel_salle_classe';



    //MANAGE CUSTOM VIEW
    const VIEW_BULLETIN = 'bulletin';
    const VIEW_CANTINE_ABONNEMENT_INFO = 'cantine_abonnement_info';


    public static function getModel($class_name){
        switch($class_name){
            case DBTable::ACTIVITE:
                return Activite::table();
            break;
            
            case DBTable::TYPE_ACTIVITE:
                return TypeActivite::table();
            break;
            case DBTable::AFFECTATION_CLASSE_MATIERE:
                return AffectationClasseMatiere::table();
            break;
            case DBTable::AFFECTATION_PERSONNEL_SALLE_CLASSE:
                return AffectationPersonnelSalleClasse::table();
            break;
            case DBTable::PERSONNEL_ACTIVITE:
                return PersonnelActivite::table();
            break;
            case DBTable::INSCRIPTION_ACTIVITE:
                return InscriptionActivite::table();
            break;
            case DBTable::ABONNEMENT_ACTIVITE:
                return AbonnementActivite::table();
            break;
            case DBTable::ABONNEMENT_CONSOMME:
                return AbonnementConsomme::table();
            break;
            case DBTable::ABONNEMENT_RESTO:
                return AbonnementResto::table();
            break;
            case DBTable::ABONNEMENT_DETAIL:
                return AbonnementDetail::table();
            break;
            case DBTable::ANNEE_SCOLAIRE:
                return AnneeScolaire::table();
            break;
            case DBTable::ANTECEDENT_SCOLAIRE:
                return AntecedentScolaire::table();
            break;
            case DBTable::CLASSE:
                return Classe::table();
            break;
            case DBTable::SALLE_CLASSE:
                return SalleClasse::table();
            break;
            case DBTable::CYCLE:
                return Cycle::table();
            case DBTable::DISCIPLINE:
                return Discipline::table();
            break;
            case DBTable::CAISSE:
                return Caisse::table();
            break;
            case DBTable::ELEVE:
                return Eleve::table();
            break;
            case DBTable::ETAT_DOCUMENT:
                return EtatDocument::table();
            break;
            case DBTable::EXEMPLAIRE:
                return Exemplaire::table();
            break;
            case DBTable::FACTURE:
                return Facture::table();
            break;
            case DBTable::JOUR_OUVRABLE:
                return JourOuvrable::table();
            break;
            case DBTable::MATIERE:
                return Matiere::table();
            break;
            case DBTable::PARCOURS:
                return Parcours::table();
            break;
            case DBTable::PAYS:
                return Pays::table();
            break;
            case DBTable::VIEW_BULLETIN:
                return VueBulletin::table();
            break;
            case DBTable::VIEW_CANTINE_ABONNEMENT_INFO:
                return VueAbonnementCantine::table();
            break;
            case DBTable::PERIODE:
                return Periode::table();
            break;
            case DBTable::PERSONNEL:
                return Personnel::table();
            break;
            case DBTable::PLANNING_COURS:
                return PlanningCours::table();
            break;
            case DBTable::PLANNING_RESTO:
                return PlanningResto::table();
            break;
            case DBTable::REMBOURSEMENT:
                return Remboursement::table();
            break;
            case DBTable::REPAS:
                return Repas::table();
            break;
            case DBTable::RESERVATION:
                return Reservation::table();
            break;
            case DBTable::RESTITUTION:
                return Restitution::table();
            break;
            case DBTable::SALAIRE:
                return Salaire::table();
            case DBTable::SESSION:
                return Session::table();
            case DBTable::STATUT_APPRENANT:
                return StatutApprenant::table();
            case DBTable::TRANCHE_HORAIRE:
                return TrancheHoraire::table();
            case DBTable::TRANCHE_SCOLAIRE:
                return TrancheScolaire::table();
            case DBTable::TYPE_PAIEMENT:
                return TypePaiement::table();
            case DBTable::TYPE_PENSION:
                return TypePension::table();
            case DBTable::TYPE_PERSONNEL:
                return TypePersonnel::table();
            case DBTable::DEPENSE:
                return Depense::table();
            case DBTable::DETTE:
                return Dette::table();
            case DBTable::DOMAINE:
                return Domaine::table();
            case DBTable::DOSSIER_MEDICAL:
                return DossierMedical::table();
            case DBTable::DOSSIER_PARENTAL:
                return DossierParental::table();
            case DBTable::PENSION_CLASSE:
                return PensionClasse::table();
            case DBTable::PENSION_ELEVE:
                return PensionEleve::table();
            case DBTable::COMPOSER:
                return Composer::table();
            case DBTable::COURS:
                return Cours::table();
            case DBTable::EMPRUNT:
                return Emprunt::table();
            case DBTable::DOCUMENT:
                return Document::table();
            case DBTable::ABONNEMENT_CANTINE:
                return AbonnementCantine::table();
            case DBTable::PRIX_ABONNEMENT:
                return PrixAbonnement::table();
            default:
                return $class_name::table();
        }
    }

}