<?php

namespace App\Repository;

use App\Model\Eleve;
use App\Model\DBTable;
use App\Model\Parcours;
use function Core\Helper\dd;

use function Core\Helper\vd;
use Core\Repository\BaseRepository;
use ClanCats\Hydrahon\Query\Expression;

class StatutApprenantRepository extends BaseRepository{

    public function getStatutApprenantId($eleve_code, $annee_scolaire_id){
        $eleve_id = Eleve::get_id($eleve_code);
        
        $eleve_affecte = Parcours::table()
                            ->select(
                            [
                                'classe.libelle' => 'classe',           
                                'classe.id' => 'classe_id',           
                                'statut_eleve.id' => 'statut_eleve_id',
                                'statut_eleve.libelle' => 'statut_eleve',
                                'parcours.annee_scolaire_id' => 'annee_scolaire_id',
                                'annee_scolaire.libelle' => 'annee_scolaire',
                            ])
                            ->join('classe', 'classe.id', '=', 'parcours.classe_id')
                            ->join('eleve', 'eleve.id', '=', 'parcours.eleve_id')
                            ->join('annee_scolaire', 'annee_scolaire.id', '=', 'parcours.annee_scolaire_id')
                            ->join('statut_eleve', 'eleve.statut_eleve_id', '=', 'statut_eleve.id')
                            ->where('parcours.visibilite', 1)
                            ->where('parcours.eleve_id', $annee_scolaire_id)
                            ->orderBy('parcours.annee_scolaire_id')
                            ->get();
        
            return $affectation_classe_eleve;



    }
}