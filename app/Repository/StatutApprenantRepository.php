<?php

namespace App\Repository;

use App\Model\Parcours;
use function Core\Helper\dd;

use function Core\Helper\vd;
use App\Model\StatutApprenant;
use Core\Repository\BaseRepository;
use ClanCats\Hydrahon\Query\Expression;

class StatutApprenantRepository extends BaseRepository{

    public function getStatutApprenantId($eleve_id, $classe_id, $annee_scolaire_id){

        $annee_scolaire_precedente_id = (new AnneeScolaireRepository)->get_annee_scolaire_precedente_id($annee_scolaire_id);
        
        if( !$annee_scolaire_precedente_id ) 
            return StatutApprenant::get_id(StatutApprenant::CODE_NOUVEAU);
        
        $parcours_exists = Parcours::table()
                                ->select(
                                [
                                    'parcours.id' => 'id',
                                ])
                                ->join('classe', 'classe.id', '=', 'parcours.classe_id')
                                ->join('eleve', 'eleve.id', '=', 'parcours.eleve_id')
                                ->join('annee_scolaire', 'annee_scolaire.id', '=', 'parcours.annee_scolaire_id')
                                ->join('statut_eleve', 'eleve.statut_eleve_id', '=', 'statut_eleve.id')
                                ->where('parcours.visibilite', 1)
                                ->where('parcours.annee_scolaire_id', $annee_scolaire_precedente_id)
                                ->where('parcours.eleve_id', $eleve_id)
                                ->where('parcours.classe_id', $classe_id)
                                ->where('parcours.visibilite', 1)
                                ->exists();
        
        return ($parcours_exists)? StatutApprenant::get_id(StatutApprenant::REDOUBLANT_CODE) : StatutApprenant::get_id(StatutApprenant::CODE_NOUVEAU);
    }

}