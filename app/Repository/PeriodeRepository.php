<?php

namespace App\Repository;

use App\Helpers\S;
use App\Model\DBTable;

use App\Model\Periode;
use App\Model\Parcours;
use App\Helpers\Helpers;
use Core\Session\Request;
use function Core\Helper\dd;
use function Core\Helper\vd;
use Core\Repository\BaseRepository;
use App\Model\AffectationClasseMatiere;
use ClanCats\Hydrahon\Query\Expression;

class PeriodeRepository extends BaseRepository{
        
    public function getPeriodeOfSession($annee_scolaire_id){
        
        $data_periodes = [];
        $sessions =  DBTable::getModel(DBTable::SESSION)->select(
        [   
            'id' => 'session_id',
            'code' => 'session_code',
            'libelle' => 'session'
        ])
        ->where('visibilite', '=', 1)
        ->where('annee_scolaire_id', '=', $annee_scolaire_id)
        ->get();

        foreach($sessions as $item){
            $tmp = $item;
            $tmp_periodes =  DBTable::getModel(DBTable::PERIODE)->select(
            [   
                'id' => 'periode_id',
                'code' => 'periode_code',
                'libelle' => 'periode'
            ])
            ->where('visibilite', '=', 1)
            // ->where('annee_scolaire_id', '=', $annee_scolaire_id)
            ->where('session_id', '=', $item['session_id'])
            ->get();

            $periodes = [];
            foreach($tmp_periodes as $periode){
                $periodes[$periode['periode_code']] = $periode;
            }
            
            $tmp['periodes'] = $periodes;

            $data_periodes[$tmp['session_code']] = $tmp;

        }

        return $data_periodes;
    }
    
    public function getPeriodes($annee_scolaire_id)       
    {
        $data = Periode::table()
                ->select([
                    'periode.id'=> 'periode_id', 
                    'periode.code'=> 'periode_code', 
                    'periode.libelle' => 'periode'
                    ])
                ->join('session', 'periode.session_id', '=', 'session.id')
                ->where('session.annee_scolaire_id', $annee_scolaire_id)
                ->where('periode.visibilite', 1)
                ->get();
        return $data;
    }

}