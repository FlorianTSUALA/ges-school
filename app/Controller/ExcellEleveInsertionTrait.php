<?php

namespace App\Controller;

use App\Model\Pays;
use Core\Session\Request;
use App\Model\SalleClasse;
use App\Model\DossierMedical;
use App\Model\DossierParental;
use App\Model\AntecedentScolaire;
use App\Repository\EleveRepository;
use App\Repository\AnneeScolaireRepository;


trait ExcellEleveInsertionTrait  {

   function insert_antecedent_scolaire($ecole, $classe, $telephone, $email){
         $code_antecedent_scolaire = AntecedentScolaire::generateCode();
         $data_antecedent_scolaire = [
             'code' => $code_antecedent_scolaire,
             'email' => $email,
             'telephone' => $telephone,
             'classe' => $classe,
             'ecole' => $ecole,
         ];
         $result_antecedent_scolaire = AntecedentScolaire::table()->insert($data_antecedent_scolaire)->execute();
   
         $id_antecedent_scolaire = AntecedentScolaire::get_id($code_antecedent_scolaire);
         return $id_antecedent_scolaire;
   }
   
   function insert_dossier_medical($autres, $probleme_particulier, $email_medecin, $telephone_medecin, $nom_medecin, $maladie_recurrente, $allergie, $groupe_sanguin){
      $code_dossier_medical = DossierMedical::generateCode();
      $data_dossier_medical = [
          'code' => $code_dossier_medical,
          'autres' => $autres,
          'probleme_particulier' => $probleme_particulier,
          'email_medecin' => $email_medecin,
          'telephone_medecin' => $telephone_medecin,
          'nom_medecin' => $nom_medecin,
          'maladie_recurrente' => $maladie_recurrente,
          'allergie' => $allergie,
          'groupe_sanguin' => $groupe_sanguin,
      ];
      $result_dossier_medical = DossierMedical::table()->insert($data_dossier_medical)->execute();

      $id_dossier_medical = DossierMedical::get_id($code_dossier_medical);
      return $id_dossier_medical;
   }

   function insert_eleve(){
      $code_eleve = Eleve::generateCode();

      
      $matricule =  (new EleveRepository())->getMatricule() ;

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
          'photo' => $photo_name,
          Eleve::PAYS_ID => Pays::get_id(Request::getSecParam('pays_eleve', ''), Pays::LIBELLE),
          'anciennete' => (Request::getSecParam('anciennete_eleve', '') === '')? 0 : Request::getSecParam('anciennete_eleve', ''),
          Eleve::DOSSIER_PARENTAL_ID => $id_dossier_parental,
          Eleve::GROUPE_FAMILIAL_ID => null,
          Eleve::DOSSIER_MEDICAL_ID => $id_dossier_medical,
          Eleve::ANTECEDENT_SCOLAIRE_ID => $id_antecedent_scolaire,
      ];

      $result_eleve = Eleve::table()->insert($data_eleve)->execute();

      $id_eleve = Eleve::get_id($code_eleve);
      return $id_eleve;
   }

   function insert_dossier_parental($pays_mere, $pays_pere){
      
      $id_pays_mere = (Pays::table()->select('id')->where(Pays::LIBELLE, $pays_mere) == false)? null : Pays::table()->select('id')->where(Pays::LIBELLE, $pays_mere)['id'] ;
      $id_pays_pere = (Pays::table()->select('id')->where(Pays::LIBELLE, $pays_pere) == false)? null : Pays::table()->select('id')->where(Pays::LIBELLE, $pays_pere)['id'] ;
      //DOSSIER PARENTAL
      $code_dossier_parental = DossierParental::generateCode();
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
      $result_dossier_parental = DossierParental::table()->insert($data_dossier_parental)->execute();

      $id_dossier_parental = DossierParental::get_id($code_dossier_parental);

      return $id_dossier_parental;
  
   }

   function insert_parcours(){
           
      $id_salle_classe = SalleClasse::get_id(Request::getSecParam('salle_classe_eleve', ''), SalleClasse::LIBELLE);
      $id_salle_classe = ($id_salle_classe == false) ? null : $id_salle_classe;
  
      $id_annee_scolaire = ( new AnneeScolaireRepository() )->getActive()['id'] ;
      $code_annee_scolaire = ( new AnneeScolaireRepository() )->getActive()['code'] ;
      //PARCOURS ELEVE
      $code_parcours = Parcours::generateCode();
      $data_parcours = [
          'code' => $code_parcours,
          Parcours::ANNEE_SCOLAIRE_ID => $id_annee_scolaire,
          'date_inscription' => (new DateTime('NOW'))->format('Y-m-d H:i:s'),
          Parcours::ELEVE_ID => $id_eleve,
          Parcours::STATUT_APPRENANT_ID => StatutApprenant::get_id(Request::getSecParam('statut_eleve', ''), StatutApprenant::LIBELLE),
          Parcours::CLASSE_ID => Classe::get_id(Request::getSecParam('classe_eleve', ''), Classe::LIBELLE),
          Parcours::SALLE_CLASSE_ID => $id_salle_classe,
      ];

      $result_parcours = Parcours::table()->insert($data_parcours)->execute();

      $id_parcours = Parcours::get_id($code_parcours);

      return $parcours_id;
   }


}


