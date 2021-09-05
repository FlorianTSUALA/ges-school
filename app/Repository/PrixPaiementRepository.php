<?php

namespace App\Repository;

use App\Helpers\S;
use App\Model\DBTable;
use App\Model\Technique\E;
use App\Model\TypePension;
use function Core\Helper\dd;
use function Core\Helper\vd;
use App\Model\AbonnementCantine;
use App\Model\AbonnementActivite;
use Core\Repository\BaseRepository;

class PrixPaiementRepository extends BaseRepository{

    public function getPensionGroupByClasse($annee_scolaire_id = null){
        
        $classes =  DBTable::getModel(DBTable::CLASSE)->select([ 'id',  'code', 'libelle' ]) ->where('visibilite', '=', 1) ->get();
        $type_pensions = DBTable::getModel('type_pension')->select(['id', 'code', 'paiement_en_tranche', 'libelle'])->where('visibilite', '=', 1)->get();

        $pension_classe = [];       

        $this->annee_scolaire_id = $annee_scolaire_id;

        foreach($classes AS $classe){

            $data_pension_classe = [
                'classe_id' => $classe['code'],
                'classe' => $classe['libelle'],
            ];
                
            $pension_classe[$classe['code']]['classe_info'] = $data_pension_classe;

            foreach($type_pensions AS $type_pension){
                $pension_classe[$classe['code']]['type_pension'][$type_pension['code']]['type_pension_info'] = [
                    'type_pension_id' => $type_pension['code'],
                    'type_pension' => $type_pension['libelle'],
                    'paiement_en_tranche' => $type_pension['paiement_en_tranche'],
                ];
                $tranches_scolaires =  DBTable::getModel(DBTable::PENSION_CLASSE)->select(
                [   
                    'tranche_scolaire.libelle' => 'tranche_scolaire_libelle',
                    'tranche_scolaire.code' => 'tranche_scolaire_code',
                    'montant' => 'montant',
                    'pension_classe.code' => 'id',
                    'type_pension.paiement_en_tranche' => 'paiement_en_tranche',
                ])
                ->join('type_pension', 'type_pension.id', '=', 'pension_classe.type_pension_id')
                ->join('tranche_scolaire', 'tranche_scolaire.id', '=', 'pension_classe.tranche_scolaire_id')
                ->where('pension_classe.annee_scolaire_id', $annee_scolaire_id)
                ->where('pension_classe.type_pension_id',  '=', $type_pension['id'])
                ->where('classe_id', '=', $classe['id'])
                ->where(
                    function($q) 
                    {
                        $q->where(function($q) 
                        {
                            $q->where('tranche_scolaire.annee_scolaire_id', $this->annee_scolaire_id);
                            $q->orWhere('type_pension.paiement_en_tranche', E::NON);
                        });
                        $q->whereNotNull('pension_classe.montant');
                    }
                )
                ->where('pension_classe.visibilite', '=', 1)
                ->get();
                
                $pension_classe[$classe['code']]['type_pension'][$type_pension['code']]['tranche_info'] = $tranches_scolaires??[];
            }
        }
        return $pension_classe;
    }

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
        
        foreach($classes AS $classe){
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
            ->where('pension_classe.annee_scolaire_id', $annee_scolaire_id)
            ->where('pension_classe.visibilite', '=', 1)
            ->where('classe_id', '=', $classe['id'])
            ->get();

            $data_pension_classe['pension_scolaire'] = $pension_scolaire??[];
            array_push($pension_scolaires, $data_pension_classe);
        }
        return $pension_scolaires;
    }

    public function getPensionInscriptionClasseGroupByClasse($annee_scolaire_id = null){
        
        $classes =  DBTable::getModel(DBTable::CLASSE)->select(
        [   
            'id',
            'code',
            'libelle'
        ])
        ->where('visibilite', '=', 1)
        ->get();
        

        $pension_scolaires = [];            
        
        foreach($classes AS $classe){
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
            ->where('type_pension.code', TypePension::INSCRIPTION_CODE)
            ->where('pension_classe.annee_scolaire_id', $annee_scolaire_id)
            ->where('pension_classe.visibilite', '=', 1)
            ->where('classe_id', '=', $classe['id'])
            ->get();

            $data_pension_classe['pension_scolaire'] = $pension_scolaire??[];
            array_push($pension_scolaires, $data_pension_classe);
        }
        return $pension_scolaires;
    }

    public function getPrixMensuelCantine($annee_scolaire_id = null){
        $result = DBTable::getModel('prix_abonnement')
                                ->select('prix_abonnement.montant')
                                // ->where('prix_abonnement.annee_scolaire_id', $annee_scolaire_id)
                                ->where('visibilite', '=', 1)
                                ->where('periode', '=', E::PERIODE_MOIS)
                                ->where('type_abonnement', '=',  AbonnementCantine::TYPE_ABONNEMENT)
                                ->one()['montant'];
        return $result;
    }

    public function getPrixAbonnementActivite($annee_scolaire_id = null){
        $result = DBTable::getModel('prix_abonnement')
                    ->select(
                        [
                            'prix_abonnement.code' => 'id',
                            'prix_abonnement.montant' => 'montant',
                            'prix_abonnement.periode' => 'periode',
                            'prix_abonnement.description' => 'description'
                        ]
                    )
                    ->where('visibilite', 1)
                    // ->where('prix_abonnement.annee_scolaire_id', $annee_scolaire_id)
                    ->where('type_abonnement', AbonnementActivite::TYPE_ABONNEMENT)
                    ->get();
        return $result;
    }

}