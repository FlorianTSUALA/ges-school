<?php

namespace App\Repository;

use App\Model\Cycle;
use App\Model\Eleve;
use App\Model\Parcours;
use App\Model\StatutEleve;
use function Core\Helper\dd;
use function Core\Helper\vd;
use Core\Repository\BaseRepository;

class StatutEleveRepository extends BaseRepository{
    
    public function actualiser_statut($annee_scolaire_id){

        $eleves = Eleve::table()->select(
                                            [
                                                'eleve.id' => 'id',
                                                'eleve.statut_eleve_id' => 'statut_eleve_id',
                                            ]
                                        )
                                ->where('eleve.visibilite', 1)
                                ->get();
        
        foreach ($eleves as $eleve) 
            $this->actualiser_statut_eleve($eleve, $annee_scolaire_id);
        
        
    } 
    
    /**
     * actualise le statut de l'élève (ancien, nouveau, démissionnaire, fin de cycle) au cours d'une année scolaire donnée
     *
     * @param [staut_eleve_id, eleve_id] $eleve
     * @param [type] $annee_scolaire_id
     * @return void
     */
    public function actualiser_statut_eleve($eleve, $annee_scolaire_id){

        $precedente_annee_scolaire_id = (new AnneeScolaireRepository)->get_annee_scolaire_precedente_id($annee_scolaire_id);

        if(is_null($eleve['statut_eleve_id'])){
            Eleve::table()->update()->set('statut_eleve_id', StatutEleve::get_id(StatutEleve::CODE_NOUVEAU))->where('id', '=', $eleve['id'])->where('visibilite', 1)->execute();
       
            $eleve = Eleve::table()->select(
                                            [
                                                'eleve.id' => 'id',
                                                'eleve.statut_eleve_id' => 'statut_eleve_id',
                                            ]
                                        )
                                ->where('eleve.visibilite', 1)
                                ->where('id', '=', $eleve['id'])
                                ->one();
        }
        $statut_eleve_code = StatutEleve::table()->select('code')->where('statut_eleve.id', $eleve['statut_eleve_id'])->one()['code'];
        
        if((!$statut_eleve_code) || (!$precedente_annee_scolaire_id && $statut_eleve_code != StatutEleve::CODE_NOUVEAU))
        {
            Eleve::table()->update()->set('statut_eleve_id', StatutEleve::get_id(StatutEleve::CODE_NOUVEAU))->where('id', '=', $eleve['id'])->where('visibilite', 1)->execute();
            $eleve = Eleve::table()->select(
                                                [
                                                    'eleve.id' => 'id',
                                                    'eleve.statut_eleve_id' => 'statut_eleve_id',
                                                ]
                                            )
                                    ->where('eleve.visibilite', 1)
                                    ->where('eleve.id', $eleve['id'])
                                    ->one();
        }
      
        $parcours = Parcours::table()->select
                                            (
                                                [
                                                    'classe.libelle' => 'classe',           
                                                    'classe.id' => 'classe_id',           
                                                    // 'statut_eleve.id' => 'statut_eleve_id',
                                                    // 'statut_eleve.libelle' => 'statut_eleve',
                                                    // 'parcours.annee_scolaire_id' => 'annee_scolaire_id',
                                                    // 'annee_scolaire.libelle' => 'annee_scolaire',
                                                ]
                                            )
                                            ->join('classe', 'classe.id', '=', 'parcours.classe_id')
                                            // ->join('annee_scolaire', 'annee_scolaire.id', '=', 'parcours.annee_scolaire_id')
                                            // ->join('statut_eleve', 'statut_eleve.id', '=', 'eleve.statut_eleve_id')
                                            ->where('parcours.visibilite', 1)
                                            ->where('parcours.eleve_id', $eleve['id'])
                                            ->where('parcours.annee_scolaire_id', $precedente_annee_scolaire_id)
                                            ->one();
        $parcours_exists = !!$parcours; 

        switch($statut_eleve_code){
            case StatutEleve::CODE_NOUVEAU:
                if($parcours_exists){
                    Eleve::table()->update()->set('statut_eleve_id', StatutEleve::get_id(StatutEleve::CODE_ANCIEN))->where('id', '=', $eleve['id'])->where('visibilite', 1)->execute();
                }
            break;
            
            case StatutEleve::CODE_ANCIEN:
                if(!$parcours_exists){
                    Eleve::table()->update()->set('statut_eleve_id', StatutEleve::get_id(StatutEleve::CODE_DEMISSINAIRE))->where('id', '=', $eleve['id'])->where('visibilite', 1)->execute();
                }else{
                    $fin_cycle = Cycle::table()->select()->where('classe_fin_cycle', $parcours['classe_id'])->where('visibilite', 1)->exists();
                    if($fin_cycle){
                        Eleve::table()->update()->set('statut_eleve_id', StatutEleve::get_id(StatutEleve::CODE_FIN_CYCLE))->where('id', '=', $eleve['id'])->where('visibilite', 1)->execute();
                    }
                }
            break;
            case StatutEleve::CODE_DEMISSINAIRE:
                //MISE A JOUR DU STATUT DURANT L'INSCRIPTION #STATUT_ELEVE#
            break;
            case StatutEleve::CODE_FIN_CYCLE:
                //AUCUN CHANGEMENT D'ETAT
            break;

        }
    
    } 

}