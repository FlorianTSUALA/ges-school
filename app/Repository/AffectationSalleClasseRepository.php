<?php

namespace App\Repository;

use App\Model\DBTable;

use function Core\Helper\dd;
use function Core\Helper\vd;
use Core\Repository\BaseRepository;

class AffectationSalleClasseRepository extends BaseRepository{
    
        
    public function getEnseignantNonAffecte(){
        $enseignants = DBTable::getModel(DBTable::PERSONNEL)->select(['code' => 'id', 'nom' => 'value'])->where('visibilite', '=', 1)->get();
        
        //---Affectation


        //-------

        return $enseignants;
    }


       public function draft()
       {
        $domaines =  DBTable::getModel(DBTable::DOMAINE)->select(
            [   
                'id',
                'code',
                'libelle'
            ])
            ->where('visibilite', '=', 1)
            ->get();
    
            $documents = [];            
            
            foreach($domaines as $domaine){
                $data_domaine = [
                    'domaine_id' => $domaine['code'],
                    'domaine' => $domaine['libelle'],
                ];
    
                $_documents =  DBTable::getModel(DBTable::DOCUMENT)->select(
                [   
                    'code' => 'document_id',
                    'titre' => 'document'
                ])
                ->where('visibilite', '=', 1)
                ->where('domaine_id', '=', $domaine['id'])
                ->get();
    
                $data_domaine['documents'] = $_documents??[];
               
                array_push($documents, $data_domaine);
                
            }
            
            return $documents;
     
       }
}