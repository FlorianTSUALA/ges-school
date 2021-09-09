<?php

use App\Model\AnneeScolaire;
use App\Model\DBTable;
use ClanCats\Hydrahon\Query\Expression as Ex;


/********************************************************************

GROUP_CONCAT(DISTINCT country
        ORDER BY country)    GROUP_CONCAT(DISTINCT country
        ORDER BY country)

********************************************************************/
// ->where('annee_scolaire_id', '=', $annee_scolaire_id)                    

$eleves = DBTable::getModel('eleve')
            ->select(
                [
                    new Ex("concat(eleve.nom,' ',eleve.prenom) as libelle"),
                    'eleve.code' => 'id',
                    'eleve.matricule' => 'matricule',
                    'eleve.date_naissance' => 'date_naissance',
                    'eleve.lieu_naissance' => 'lieu_naissance'
                ]
            )
            ->where('visibilite', '=', 1)
            ->get();


$classes = DBTable::getModel('classe')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();
$type_paiements = DBTable::getModel('type_paiement')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();


$annee_scolaires = AnneeScolaire::table(DBTable::ANNEE_SCOLAIRE)
->select([ 
    AnneeScolaire::CODE => 'id', 
    AnneeScolaire::LIBELLE => 'value'
    ])
->where('visibilite', 1)
->orderBy('date_creation', 'desc')
->get();
