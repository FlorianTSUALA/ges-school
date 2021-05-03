<?php

namespace App\Repository;

use App\Model\Classe;
use App\Model\DBTable;
use App\Model\Parcours;

use function Core\Helper\dd;
use function Core\Helper\vd;
use Core\Repository\BaseRepository;

class SalleClasseRepository extends BaseRepository{
    
    public function getSalleClasseGroupByClasse(){
        
        $salle_classes = [];

        $classes =  DBTable::getModel(DBTable::CLASSE)->select(
        [   
            'id',
            'code',
            'libelle'
        ])
        ->where('visibilite', '=', 1)
        ->get();

        foreach($classes as $classe){
            $data_salle = [
                'classe_id' => $classe['code'],
                'classe' => $classe['libelle'],
            ];

            $salles =  DBTable::getModel(DBTable::SALLE_CLASSE)->select(
            [   
                'code' => 'salle_classe_id',
                'libelle' => 'salle_classe'
            ])
            ->where('visibilite', '=', 1)
            ->where('classe_id', '=', $classe['id'])
            ->get();

            $data_salle['salles'] = $salles;
           
            array_push($salle_classes, $data_salle);
            
        }
        
        return $salle_classes;
    }
 
    public function getSalles($annee_scolaire_id = null)
    {
        $model =  DBTable::getModel(DBTable::SALLE_CLASSE);
        $model = $model->select(
                [   
                    'salle_classe.code' => 'salle_classe_id', 
                    'salle_classe.code' => 'salle_classe_code', 
                    'salle_classe.libelle' => 'salle_classe', 
                ])
                ->where('salle_classe.visibilite', '=', 1)
                ->get();
        return $model;
    }


}