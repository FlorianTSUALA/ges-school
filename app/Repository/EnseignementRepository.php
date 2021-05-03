<?php

namespace App\Repository;

use App\Model\DBTable;

use App\Model\Parcours;
use App\Helpers\Helpers;
use Core\Session\Request;
use function Core\Helper\dd;
use function Core\Helper\vd;
use Core\Repository\BaseRepository;
use App\Model\AffectationClasseMatiere;
use ClanCats\Hydrahon\Query\Expression;

class EnseignementRepository extends BaseRepository{
    
        
    public function getEleveOfSalleOfClasseAndMatiereOfClasse($annee_scolaire_id){
        
        $data_classes = [];

        $classes =  DBTable::getModel(DBTable::CLASSE)->select(
        [   
            'id',
            'code',
            'libelle'
        ])
        ->where('visibilite', '=', 1)
        ->get();

        foreach($classes as $classe){
            
            $data_salles_classes = [];
            $salle_classes =  DBTable::getModel(DBTable::SALLE_CLASSE)->select(
            [   
                'id' => 'salle_classe_id',
                'code' => 'salle_classe_code',
                'libelle' => 'salle_classe'
            ])
            ->where('visibilite', '=', 1)
            ->where('classe_id', '=', $classe['id'])
            ->get();

            foreach ($salle_classes as $salle_classe) {
                $tmp_salle_classe = [
                    'salle_classe_id' => $salle_classe['salle_classe_id'],
                    'salle_classe_code' => $salle_classe['salle_classe_code'],
                    'salle_classe' => $salle_classe['salle_classe'],
                    'eleves' => $this->getEleveOfSalle($salle_classe['salle_classe_id'], $annee_scolaire_id)
                ];
                $data_salles_classes[$salle_classe['salle_classe_code']] = $tmp_salle_classe;
            }

            $data_classe = [
                'classe_id' => $classe['id'],
                'classe_code' => $classe['code'],
                'classe' => $classe['libelle'],
                'salle_classes' => $data_salles_classes,
                'matieres' => $this->getMatiereOfClasse($classe['id'], $annee_scolaire_id)
            ];

            $data_classes[$classe['code']] = $data_classe;
            
        }
        
        return $data_classes;
    }
        
    public function getEleveOfSalleClasseAndMatiereOfClasseWithNotes($annee_scolaire_id){
        
        $data_classes = [];

        $classes =  DBTable::getModel(DBTable::CLASSE)->select(
        [   
            'id',
            'code',
            'libelle'
        ])
        ->where('visibilite', 1)
        ->get();

        foreach($classes as $classe){
            
            $data_salles_classes = [];
            $salle_classes =  DBTable::getModel(DBTable::SALLE_CLASSE)->select(
            [   
                'id' => 'salle_classe_id',
                'code' => 'salle_classe_code',
                'libelle' => 'salle_classe'
            ])
            ->where('visibilite', '=', 1)
            ->where('classe_id', '=', $classe['id'])
            ->get();

            foreach ($salle_classes as $salle_classe) {
                $tmp_salle_classe = [
                    'salle_classe_id' => $salle_classe['salle_classe_id'],
                    'salle_classe_code' => $salle_classe['salle_classe_code'],
                    'salle_classe' => $salle_classe['salle_classe'],
                    'eleves' => $this->getEleveOfSalle($salle_classe['salle_classe_id'], $annee_scolaire_id)
                ];
                $data_salles_classes[$salle_classe['salle_classe_code']] = $tmp_salle_classe;
            }

            $data_classe = [
                'classe_id' => $classe['id'],
                'classe_code' => $classe['code'],
                'classe' => $classe['libelle'],
                'salle_classes' => $data_salles_classes,
                'matieres' => $this->getMatiereOfClasse($classe['id'], $annee_scolaire_id)
            ];

            $data_classes[$classe['code']] = $data_classe;
            
        }
        
        return $data_classes;
    }

    public function getMatiereOfClasse($classe_id = null, $annee_scolaire_id)
    {
        $classe_id = Request::getSecParam('classe', NULL);

        $model = AffectationClasseMatiere::table()
            ->select(
                [
                    'matiere.libelle' => 'matiere', 
                    'affectation_classe_matiere.matiere_id' => 'matiere_id', 
                    'affectation_classe_matiere.coefficient' => 'coefficient' 
                ])
            ->join('matiere', 'matiere_id', '=', 'matiere.id')
            ->where('matiere.visibilite', 1)
            ->where('affectation_classe_matiere.visibilite', 1)
            ->where('affectation_classe_matiere.annee_scolaire_id', $annee_scolaire_id);
        
        if(!is_null($classe_id))
            $model->where('affectation_classe_matiere.classe_id', $classe_id);
        
        $data = $model->get();
        return $data;

    }
   
    public function getEleveOfSalle($salle_classe_id, $annee_scolaire_id)
    {

        $classe_id =  DBTable::getModel(DBTable::SALLE_CLASSE)
        ->select('classe_id')
        ->where('salle_classe.visibilite', 1)
        ->where('id', $salle_classe_id)
        ->one();
      
        $eleve_affecte = Parcours::table()
            ->select(
            [
                'salle_classe.id' => 'salle_classe_id', 
                'salle_classe.code' => 'salle_classe_code', 
                'salle_classe.libelle' => 'salle_classe',

                'classe.id' => 'classe_id',
                'classe.code' => 'classe_code',
                'classe.libelle' => 'classe',
                
                'statut_apprenant.id' => 'statut_apprenant_id',
                'statut_apprenant.code' => 'statut_apprenant_code',
                'statut_apprenant.libelle' => 'statut_apprenant',
                
                'eleve.id' => 'eleve_id',
                'eleve.code' => 'eleve_code',
                new Expression("concat(eleve.nom,' ',eleve.prenom) as nom_complet"),
            ])
        ->join('eleve', 'eleve.id', '=', 'parcours.eleve_id')
        ->join('classe', 'classe.id', '=', 'parcours.classe_id')
        ->join('salle_classe', 'salle_classe.id', '=', 'parcours.salle_classe_id')
        ->join('statut_apprenant', 'statut_apprenant.id', '=', 'parcours.statut_apprenant_id')
        ->where('parcours.visibilite', 1)
        ->where('parcours.annee_scolaire_id', $annee_scolaire_id)
        ->where('parcours.salle_classe_id', $salle_classe_id)
        ->where('parcours.classe_id', $classe_id)
        ->orderBy(['salle_classe.libelle', 'eleve.nom'])
        ->get();
        
        $affectation_salle_eleve = [];

        foreach($eleve_affecte as $eleve){
            $tmp = [];
            $tmp['eleve_id'] = $eleve['eleve_id'];
            $tmp['eleve_code'] = $eleve['eleve_code'];
            $tmp['nom_complet'] = $eleve['nom_complet'];
            $affectation_salle_eleve[$eleve['eleve_code']] = $tmp;
        }

        // $affectation_salle_classe_eleve = [];
        // $affectation_salle_classe_eleve['salle_classe_id'] = $salle_classe['salle_classe_id'];
        // $affectation_salle_classe_eleve['salle_classe_code'] = $salle_classe['salle_classe_code'];
        // $affectation_salle_classe_eleve['salle_classe'] = $salle_classe['salle_classe'];
        // $affectation_salle_classe_eleve['eleves'] = $affectation_salle_eleve;
        
        return $affectation_salle_eleve;
    }


}