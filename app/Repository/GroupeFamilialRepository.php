<?php

namespace App\Repository;

use App\Model\GroupeFamilial;
use Core\Repository\BaseRepository;

class GroupeFamilialRepository extends BaseRepository{

    public function __construct(){
        $this->model = GroupeFamilial::table();
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