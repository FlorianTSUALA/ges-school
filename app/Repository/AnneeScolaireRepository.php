<?php

namespace App\Repository;

use DateTime;
use App\Model\DBTable;
use App\Model\AnneeScolaire;
use function Core\Helper\dd;
use function Core\Helper\vd;

use Core\Repository\BaseRepository;
use Core\helper\DateHelpers;


class AnneeScolaireRepository extends BaseRepository{
    
    public function getActive($tag = null){

        $annee_scolaire = DBTable::getModel(DBTable::ANNEE_SCOLAIRE)
        ->select(['id', 'code', 'libelle'])
        ->where('visibilite', '=', 1)
        ->where('statut', '=', 1)
        ->orderBy('date_creation', 'desc')
        ->first();
        
        switch($tag){
            case 'id': return $annee_scolaire['id'];
            case 'code': return $annee_scolaire['code'];
            case 'libelle': return $annee_scolaire['libelle'];
            default: return $annee_scolaire;
        }
    }
    
    public function getAnneeScolaire($value, $tag = 'id', $what_select = 'all'){
        $model =  DBTable::getModel(DBTable::ANNEE_SCOLAIRE)
        ->select(['id'=>'id', 'code'=>'code', 'libelle', 'debut_annee', 'fin_annee'])
        ->where('visibilite', '=', 1)
        ->where("$tag", '=', "$value")
        ->one();
        if(isset($model["$what_select"]))
            return $model["$what_select"];
        else
            return $model;
    }

    public function getAll(){

        $annee_scolaires = DBTable::getModel('annee_scolaire')
        ->select(['code'=>'id', 'libelle' => 'libelle'])
        ->where('visibilite', '=', 1)
        ->orderBy('date_creation', 'desc')
        ->get();
       
       return $annee_scolaires;
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

    /**
     * get_annee_scolaire_precedente_id
     *
     * @param int $annee_scolaire_id
     * @return 0 if not exist and number even not
     */
    public  function get_annee_scolaire_precedente_id($annee_scolaire_id){
        $date_debut_annee = $this->getAnneeScolaire($annee_scolaire_id, 'id', 'debut_annee');

        if(!$date_debut_annee) 
            return 0;
        
        $annee_courante = DateHelpers::getFullYear($date_debut_annee);
        $annee_precedente = $annee_courante - 1;
        $libelle_annee_scolaire_precedente = "{$annee_precedente}-{$annee_courante}";
        
        return intval($this->getAnneeScolaire($libelle_annee_scolaire_precedente, 'libelle', 'id'));
    }
    
}