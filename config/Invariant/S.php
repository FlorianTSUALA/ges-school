<?php

namespace App\Helpers;

class S //Alias of Sessions
{
    const DATA_TRANSPORT = 'DATA_TRANSPORT';

    //Information de session utilise au processus de versement suite à la phase d'inscription
    const VERS_CODE_ELEVE = 'CODE_ELEVE'; 
    const VERS_CODE_CLASSE = 'CODE_CLASSE'; 
    const VERS_CODE_CANTINE = 'CODE_CANTINE';
    const VERS_CLASSE = 'CLASSE'; 
    const VERS_CODE_PARCOURS = 'CODE_PARCOURS'; 
    const VERS_MATRICULE = 'MATRICULE'; 
    const VERS_NOM = 'NOM';
    const VERS_PRENOM = 'PRENOM';
    const VERS_SEXE = 'SEXE';
    const VERS_LIEU_NAISSANCE = 'LIEU_NAISSANCE';
    const VERS_DATE_NAISSANCE = 'DATE_NAISSANCE';
    const VERS_AGE = 'AGE';
    const VERS_CODE_STATUT_APPRENANT = 'CODE_STATUT_APPRENANT';

    //Connexion de l'utilisateur
    const LAST_ACTIVITY = 'LAST_ACTIVITY';

    //Information de session de connexion d'un personnel 
    const PERS_CODE = 'CODE';
    const PERS_TYPE_PERSONNEL = 'TYPE_PERSONNEL';
    const PERS_PAYS = 'PAYS';
    const PERS_NOM = 'NOM';
    const PERS_PRENOM = 'PRENOM';
    const PERS_SEXE = 'SEXE';
    const PERS_PHOTO = 'PHOTO';
    const PERS_TELEPHONE = 'TELEPHONE';
    const PERS_EMAIL = 'EMAIL';
    const PERS_ADRESSE = 'ADRESSE';
    const PERS_LOGIN = 'LOGIN';
    const PERS_PASSWORD = 'PASSWORD';
    const PERS_DATE_PRISE_SERVICE = 'DATE_PRISE_SERVICE';
    const PERS_DATE_FIN_CARRIERE = 'DATE_FIN_CARRIERE';
    const PERS_BIBLIOGRAPHIE = 'BIBLIOGRAPHIE';
    const PERS_DATE_HEURE_CONNEXION = 'DATE_HEURE_CONNEXION';
    const PERS_IP = 'DATE_IP';

    //Facture versement


    const FAC_REF = "FAC_REF";
    const FAC_DATA = "FAC_PENSION";

    //Flash Message
    const FLASH_TAG = 'FLASH';
    const FLASH_TYPE = 'alert-type';
    const FLASH_MESSAGE = 'message';
    const FLASH_SUCCESS = 'success';
    const FLASH_ERROR = 'error';
    const FLASH_WARNING = 'warning';
    const FLASH_INFO = 'info';

    const ANNEE_SCOLAIRE = 'annee_scolaire'; //ANSC
    const ANNEE_SCOLA_ID = 'annee_scolaire_id'; //ANSC
    const ANSC_ID = 'id';
    const ANSC_LIBELLE = 'libelle'; 
    const ANSC_DEBUT_ANNEE = 'debut_annee';
    const ANSC_FIN_ANNEE = 'fin_annee';

}