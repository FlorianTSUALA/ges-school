<?php

namespace App\Repository;

use App\Model\Eleve;
use App\Model\StatutEleve;
use App\Model\GroupeFamilial;
use Core\Repository\BaseRepository;

class GroupeFamilialRepository extends BaseRepository{

    public function __construct(){
        $this->model = GroupeFamilial::table();
    }

    public function get_all_groupe_familial_reduction($annee_scolaire_id = null){
        $req = "SELECT  GROUP_CONCAT( CONCAT(eleve.nom, ' ', eleve.prenom) SEPARATOR ', ') AS description, 
                        groupe_familial.id,           
                        groupe_familial.famille AS famille, 
                        groupe_familial.code AS code, 
                        -- groupe_familial.libelle AS libelle
                FROM    groupe_familial 
                LEFT  JOIN  eleve ON eleve.eleve_id = groupe_familial.id
                -- LEFT  JOIN  annee_scolaire ON annee_scolaire.id = groupe_familial.annee_scolaire_id
                -- LEFT  JOIN  type_groupe_familial ON type_groupe_familial.id = groupe_familial.type_groupe_familial_id
                -- LEFT JOIN (
                --     SELECT mois.libelle AS libelle, groupe_familial_mois.groupe_familial_id AS id 
                --     FROM groupe_familial_mois 
                --     LEFT  JOIN  mois ON groupe_familial_mois.mois_id = mois.id    
                -- ) AS tr ON tr.id = groupe_familial.id
                WHERE 
                        groupe_familial.visibilite = 1  AND 
                        eleve.statut_eleve_id not in ( " . StatutEleve::get_id(StatutEleve::DEMISSINAIRE_CODE) . ", ". StatutEleve::get_id(StatutEleve::FIN_CYCLE_CODE) .")
                GROUP  BY groupe_familial.id
            ";
        $result = $this->query($req);
        return $result;
    }

    public function get_one_groupe_familial_reduction(){

    }

    public function get_groupe_familial($groupe_familial_id, $annee_scolaire_id, $code){

        $groupe_familial_id = Eleve::table()->select('groupe_familial_id')->where('code', $code)->where('visibilite', 1)->one()['groupe_familial_id'];

        $results = $this->model->select(
                                            [
                                                'groupe_familial.code' => 'id',
                                                'groupe_familial.famille' => 'famille',
                                                'groupe_familial.reduction' => 'reduction',
                                                'eleve.nom' => 'nom',
                                                'eleve.prenom' => 'prenom',
                                                'eleve.code' => 'eleve_code',
                                            ]
                                        )
                                ->join('eleve', 'eleve.groupe_familial_id', '=', 'groupe_familial.id')
                                ->where('groupe_familial.visibilite', 1)
                                ->where('groupe_familial.id', $groupe_familial_id)
                                ->where('eleve.visibilite', 1)
                                ->get();
        return $results;
    }


    public function groupe_familial_exists($eleve_id){
        return Eleve::table()->select()->where('eleve.id', $eleve_id)->exists();
    }

    public function groupe_familial_by_eleve_id($eleve_id){
        return Eleve::table()->select('groupe_familial_id')->where('eleve.id', $eleve_id)->one()['groupe_familial_id'];
    }

    public function get_groupe_famille_info($eleve_id){
        $data = $this->model->select(
                                        [
                                            // 'groupe_famille.id' => 'id',
                                            'groupe_famille.code' => 'code',
                                            'groupe_famille.' => '',
                                            'groupe_famille.' => '',
                                            'groupe_famille.' => '',
                                        ]
                                    )
                            ->join('eleve', 'eleve.groupe_familial_id', '=', 'groupe_familial.id')
                            ->where('groupe_familial.visibilite', 1)
                            ->where('groupe_familial.visibilite', 1)
                            ->where('groupe_familial.visibilite', 1)
                            ->get();
        return $data;
    }
        
    public function add_eleve_to_groupe_famille($groupe_familial_id, $eleve_id){

    }
        
    public function remove_to_groupe_famille($eleve_id){

    }

    public function get_facture_reduction_of_groupe_familial($eleve_id, $annee_scolaire_id){

    }

    public function add_facture_reduction_of_groupe_familial($eleve_id, $annee_scolaire_id){

    }

}