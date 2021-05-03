<?php

namespace App\Model;

use DateTime;
use Core\Model\Model;
use App\Helpers\Helpers;
use Core\HTML\Form\FormModel;
use Core\HTML\Form\InputType;
use App\Helpers\HelpersBusinessLogic;
use Core\Model\HydrahonModel;

class VueBulletin extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;
    

    const CLASSE_ID = "classe_id";
    const MATIERE_ID = "matiere_id";
    const COURS_ID = "cours_id";
    const PERIODE_ID = "periode_id";
    const PERSONNEL_ID = "personnel_id";   
    const SEXE = "sexe";
    const ELEVE_ID = "eleve_id";
    const SALLE_CLASSE_ID = "salle_classe_id";
    const DATE_NAISSANCE = "date_naissance";
    const LIEU_NAISSANCE = "lieu_naissance";
    const PRENOM = "prenom";
    const NOM = "nom";
    const ANNEE_SCOLAIRE_ID = "annee_scolaire_id";
    const COMPOSER_ID = "composer_id";
    const DISCIPLINE_ID = "discipline_id";
   


    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
        
                new FormModel(false, self::CLASSE_ID, 'classe'),
                new FormModel(true, self::SALLE_CLASSE_ID, 'salle de classe'),
                new FormModel(false, self::MATIERE_ID, 'matiere'),
                new FormModel(false, self::COURS_ID, 'cours'),
                new FormModel(false, self::PERIODE_ID, 'periode'),
                new FormModel(false, self::PERSONNEL_ID, 'personnel'),
                new FormModel(false, self::SEXE),
                new FormModel(false, self::NOM, 'nom'),
                new FormModel(false, self::PRENOM, 'Prénom'),
                new FormModel(false, self::DATE_NAISSANCE, 'date de naissance',InputType::DATE ),
                new FormModel(false, self::LIEU_NAISSANCE, 'lieu de naissance', InputType::TEXT),
                new FormModel(false, self::ANNEE_SCOLAIRE_ID, 'année scolaire'),
                new FormModel(false, self::COMPOSER_ID, 'note'),
                new FormModel(false, self::DISCIPLINE_ID, 'discipline'),
                

            ];

    }

    public function getSalleDeClasseListeby(){
        $req =
        " select  
        InfoEleve.libelle_cours as libelle_cours, InfoEleve.nom_personnel as nom_personnel, InfoEleve.prenom_personnel as prenom_personnel, InfoEleve.note as note,
         InfoEleve.libelle_periode as libelle_periode,InfoEleve.periode_debut as periode_debut, InfoEleve.periode_fin, InfoEleve.nom_eleve as nom_eleve, InfoEleve.prenom_eleve as prenom_eleve,
         InfoEleve.sexe as sexe, InfoEleve.date_naissance, InfoEleve.lieu_naissance as lieu_naissance,InfoMatiere.libelle_matiere as libelle_matiere,
         InfoMatiere.libelle_discipline AS libelle_discipline, InfoMatiere.libelle_salle_classe AS libelle_salle_classe    
       from (
        select cours.salle_classe_id as id, cours.libelle as libelle_cours, personnel.nom AS nom_personnel, personnel.prenom AS prenom_personnel, composer.note AS note,
        periode.libelle as libelle_periode, periode.date_debut AS periode_debut, periode.date_fin  AS periode_fin, eleve.nom AS nom_eleve,
        eleve.prenom AS prenom_eleve, eleve.sexe AS sexe, eleve.date_naissance AS date_naissance, eleve.lieu_naissance
        from cours
        left join personnel on cours.personnel_id = personnel.id
        left join composer on composer.cours_id = cours.id
        LEFT JOIN periode on composer.periode_id = periode.id
        LEFT JOIN eleve on composer.eleve_id = eleve.id

       ) InfoEleve,
    
       (
        select  salle_classe.id as id, matiere.libelle AS libelle_matiere, discipline.libelle as libelle_discipline,
        salle_classe.libelle as libelle_salle_classe, annee_scolaire.libelle AS annee_encours
        from salle_classe
        left join affectation_classe_matiere on affectation_classe_matiere.classe_id = salle_classe.classe_id
        left join matiere on matiere.id = affectation_classe_matiere.matiere_id
        LEFT JOIN discipline on matiere.discipline_id = discipline.id
        LEFT JOIN parcours on parcours.salle_classe_id = salle_classe.id
        LEFT JOIN annee_scolaire on annee_scolaire.id = parcours.annee_scolaire_id
        
        )  InfoMatiere 
   
       where InfoEleve.id = InfoMatiere.id 
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

    public function getEleveInscriptionInfoById($matricule){
        $req =
        "
        select  
        InfoEleve.libelle_cours as libelle_cours, InfoEleve.nom_personnel as nom_personnel, InfoEleve.prenom_personnel as prenom_personnel, InfoEleve.note as note,
         InfoEleve.libelle_periode as libelle_periode,InfoEleve.periode_debut as periode_debut, InfoEleve.periode_fin, InfoEleve.nom_eleve as nom_eleve, InfoEleve.prenom_eleve as prenom_eleve,
         InfoEleve.sexe as sexe, InfoEleve.date_naissance, InfoEleve.lieu_naissance as lieu_naissance,InfoMatiere.libelle_matiere as libelle_matiere,
         InfoMatiere.libelle_discipline AS libelle_discipline, InfoMatiere.libelle_salle_classe AS libelle_salle_classe    
       from (
      select cours.salle_classe_id as id, cours.libelle as libelle_cours, personnel.nom AS nom_personnel, personnel.prenom AS prenom_personnel, composer.note AS note,
        periode.libelle as libelle_periode, periode.date_debut AS periode_debut, periode.date_fin  AS periode_fin, eleve.nom AS nom_eleve,
        eleve.prenom AS prenom_eleve, eleve.sexe AS sexe, eleve.date_naissance AS date_naissance, eleve.lieu_naissance
        from cours
        left join personnel on cours.personnel_id = personnel.id
        left join composer on composer.cours_id = cours.id
        LEFT JOIN periode on composer.periode_id = periode.id
        LEFT JOIN eleve on composer.eleve_id = eleve.id

       ) InfoEleve,
    
      (
        select  salle_classe.id as id, matiere.libelle AS libelle_matiere, discipline.libelle as libelle_discipline,
        salle_classe.libelle as libelle_salle_classe, annee_scolaire.libelle AS annee_encours
        from salle_classe
        left join affectation_classe_matiere on affectation_classe_matiere.classe_id = salle_classe.classe_id
        left join matiere on matiere.id = affectation_classe_matiere.matiere_id
        LEFT JOIN discipline on matiere.discipline_id = discipline.id
        LEFT JOIN parcours on parcours.salle_classe_id = salle_classe.id
        LEFT JOIN annee_scolaire on annee_scolaire.id = parcours.annee_scolaire_id
        
      )  InfoMatiere 
   
      where InfoEleve.id = InfoMatiere.id 
            
        ";
        $result = $this->query($req, array($matricule));
        return $this->toObject($result);
    }

    public function getEleveInscriptionInfo(){
        $req =
            "  select  
            InfoEleve.libelle_cours as libelle_cours, InfoEleve.nom_personnel as nom_personnel, InfoEleve.prenom_personnel as prenom_personnel, InfoEleve.note as note,
             InfoEleve.libelle_periode as libelle_periode,InfoEleve.periode_debut as periode_debut, InfoEleve.periode_fin, InfoEleve.nom_eleve as nom_eleve, InfoEleve.prenom_eleve as prenom_eleve,
             InfoEleve.sexe as sexe, InfoEleve.date_naissance, InfoEleve.lieu_naissance as lieu_naissance,InfoMatiere.libelle_matiere as libelle_matiere,
             InfoMatiere.libelle_discipline AS libelle_discipline, InfoMatiere.libelle_salle_classe AS libelle_salle_classe    
          from (
          select cours.salle_classe_id as id, cours.libelle as libelle_cours, personnel.nom AS nom_personnel, personnel.prenom AS prenom_personnel, composer.note AS note,
            periode.libelle as libelle_periode, periode.date_debut AS periode_debut, periode.date_fin  AS periode_fin, eleve.nom AS nom_eleve,
            eleve.prenom AS prenom_eleve, eleve.sexe AS sexe, eleve.date_naissance AS date_naissance, eleve.lieu_naissance
            from cours
            left join personnel on cours.personnel_id = personnel.id
            left join composer on composer.cours_id = cours.id
            LEFT JOIN periode on composer.periode_id = periode.id
            LEFT JOIN eleve on composer.eleve_id = eleve.id
 
          ) InfoEleve,
         
          (
            select  salle_classe.id as id, matiere.libelle AS libelle_matiere, discipline.libelle as libelle_discipline,
            salle_classe.libelle as libelle_salle_classe, annee_scolaire.libelle AS annee_encours
            from salle_classe
            left join affectation_classe_matiere on affectation_classe_matiere.classe_id = salle_classe.classe_id
            left join matiere on matiere.id = affectation_classe_matiere.matiere_id
            LEFT JOIN discipline on matiere.discipline_id = discipline.id
            LEFT JOIN parcours on parcours.salle_classe_id = salle_classe.id
            LEFT JOIN annee_scolaire on annee_scolaire.id = parcours.annee_scolaire_id
            
          )  InfoMatiere 
       
          where InfoEleve.id = InfoMatiere.id 
 
          ";
          $result = $this->query($req);
         return $this->toObject($result);
    }

    public function getEleveClass($salle_classe_id){
         $req =
         "    select  
         InfoEleve.libelle_cours as libelle_cours, InfoEleve.nom_personnel as nom_personnel, InfoEleve.prenom_personnel as prenom_personnel, InfoEleve.note as note,
         InfoEleve.libelle_periode as libelle_periode,InfoEleve.periode_debut as periode_debut, InfoEleve.periode_fin, InfoEleve.nom_eleve as nom_eleve, InfoEleve.prenom_eleve as prenom_eleve,
         InfoEleve.sexe as sexe, InfoEleve.date_naissance, InfoEleve.lieu_naissance as lieu_naissance,InfoMatiere.libelle_matiere as libelle_matiere,
         InfoMatiere.libelle_discipline AS libelle_discipline, InfoMatiere.libelle_salle_classe AS libelle_salle_classe    
         from (
         select cours.salle_classe_id as id, cours.libelle as libelle_cours, personnel.nom AS nom_personnel, personnel.prenom AS prenom_personnel, composer.note AS note,
         periode.libelle as libelle_periode, periode.date_debut AS periode_debut, periode.date_fin  AS periode_fin, eleve.nom AS nom_eleve,
         eleve.prenom AS prenom_eleve, eleve.sexe AS sexe, eleve.date_naissance AS date_naissance, eleve.lieu_naissance
         from cours
         left join personnel on cours.personnel_id = personnel.id
         left join composer on composer.cours_id = cours.id
         LEFT JOIN periode on composer.periode_id = periode.id
         LEFT JOIN eleve on composer.eleve_id = eleve.id

         ) InfoEleve,
    
         (
         select  salle_classe.id as id, matiere.libelle AS libelle_matiere, discipline.libelle as libelle_discipline,
         salle_classe.libelle as libelle_salle_classe, annee_scolaire.libelle AS annee_encours
         from salle_classe
         left join affectation_classe_matiere on affectation_classe_matiere.classe_id = salle_classe.classe_id
         left join matiere on matiere.id = affectation_classe_matiere.matiere_id
         LEFT JOIN discipline on matiere.discipline_id = discipline.id
         LEFT JOIN parcours on parcours.salle_classe_id = salle_classe.id
         LEFT JOIN annee_scolaire on annee_scolaire.id = parcours.annee_scolaire_id
         where salle_classe.id="+ $salle_classe_id+"
          )   InfoMatiere 
   
           where InfoEleve.id = InfoMatiere.id 

          ";
         $result = $this->query($req);
         return $this->toObject($result);
    }

    

    public function genAnneeScolaireID(){
        $annee_scolaire = DBTable::getModel('annee_scolaire');
        $debut_annee = (int)substr(date('Y'), 2, 2);
        //create new if not exists
        //TODO Creattion de triggers de renitialisation du statut des années scolaires inactivées
        $id_annee_scolaire = $annee_scolaire->select()->where(AnneeScolaire::STATUT, '=', 1)->last()[AnneeScolaire::ID];
        $en_cours = $annee_scolaire->select()->where(AnneeScolaire::STATUT, '=', 1)->last()[AnneeScolaire::DEBUT_ANNEE];
        $en_cours = (int)substr($en_cours, 2, 2);
        if($debut_annee > $en_cours){//Ajouter des conditins supplementaires
            // if($id_annee_scolaire = $annee_scolaire->select('id')->where(AnneeScolaire::DEBUT_ANNEE, '=', $debut_annee)->exists() ){
                $code_annee_scolaire = AnneeScolaire::generateCode();
                $debut_annee =  (new DateTime('NOW'))->format('Y-m-d H:i:s');
                $data = [
                    AnneeScolaire::CODE => $code_annee_scolaire,
                    AnneeScolaire::DEBUT_ANNEE => $debut_annee,
                    AnneeScolaire::FIN_ANNEE => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($debut_annee)) . " + 1 year")),
                    AnneeScolaire::STATUT => 1,
                ];
                $annee_scolaire->insert($data)->execute();
                $id_annee_scolaire = $annee_scolaire->select('id')->find('code', $code_annee_scolaire);
        }

        return $id_annee_scolaire;
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