<?php

namespace App\Repository;

use App\Model\DBTable;
use App\Model\TypePension;
use function Core\Helper\dd;
use function Core\Helper\vd;
use Core\Repository\BaseRepository;

class PensionRepository extends BaseRepository{

    public function getPensionScolaireClasseGroupByClasse($annee_scolaire_id = null){
        
        $classes =  DBTable::getModel(DBTable::CLASSE)->select(
        [   
            'id',
            'code',
            'libelle'
        ])
        ->where('visibilite', '=', 1)
        ->get();
        

        $pension_scolaires = [];            
        
        foreach($classes as $classe){
            $data_pension_classe = [
                'classe_id' => $classe['code'],
                'classe' => $classe['libelle'],
            ];

            $pension_scolaire =  DBTable::getModel(DBTable::PENSION_CLASSE)->select(
            [   
                'tranche_scolaire.libelle' => 'tranche_scolaire_libelle',
                'montant' => 'montant',
                'pension_classe.code' => 'code',
                'tranche_scolaire.code' => 'tranche_scolaire_code'
            ])
            ->join('type_pension', 'type_pension.id', '=', 'pension_classe.type_pension_id')
            ->join('tranche_scolaire', 'tranche_scolaire.id', '=', 'pension_classe.tranche_scolaire_id')
            ->where('type_pension.code', TypePension::SCOLARITE_CODE)
            ->where('pension_classe.visibilite', '=', 1)
            ->where('classe_id', '=', $classe['id'])
            ->get();

            $data_pension_classe['pension_scolaire'] = $pension_scolaire??[];
            array_push($pension_scolaires, $data_pension_classe);
        }
        return $pension_scolaires;
    }


}