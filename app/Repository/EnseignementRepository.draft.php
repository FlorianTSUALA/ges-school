<?php

namespace App\Repository;

use App\Helpers\S;
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
    
        
    public function getEleveOfSalleOfClasseAndMatiereOfClasse(){
        
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
                    'eleves' => $this->getEleveOfSalle($salle_classe['salle_classe_id'])
                ];
                $data_salles_classes[$salle_classe['salle_classe_code']] = $tmp_salle_classe;
            }

            $data_classe = [
                'classe_id' => $classe['id'],
                'classe_code' => $classe['code'],
                'classe' => $classe['libelle'],
                'salle_classes' => $data_salles_classes,
                'matieres' => $this->getMatiereOfClasse($classe['id'])
            ];

            $data_classes[$classe['code']] = $data_classe;
            
        }
        
        return $data_classes;
    }


    public function getMatiereOfClasse($classe_id = null)
    {
        $classe_id = Request::getSecParam('classe', NULL);

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $model = AffectationClasseMatiere::table()
            ->select(
                [
                    'matiere.libelle' => 'matiere', 
                    'matiere.matiere_id' => 'matiere_id', 
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
   
    public function getEleveOfSalle($classe_id)
    {

    }

    public function getSalleClasseGroupByClasse(){
        
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
           
            array_push($data_classes, $data_salle);
            
        }
        return $data_classes;
    }

    
    public function getAffectationEleveBySalleClasse($salle_classe_id, $annee_scolaire_id){
        
        $salle_classe =  DBTable::getModel(DBTable::SALLE_CLASSE)->select(
            [   
                'id' => 'salle_classe_id',
                'code' => 'salle_classe_code',
                'libelle' => 'salle_classe',
                'classe_id'
            ])
        ->where('visibilite', 1)
        ->where('id', $salle_classe_id)
        ->one();

        $classe =  DBTable::getModel(DBTable::CLASSE)->select(
            [   
                'id',
                'code',
                'libelle'
            ])
        ->where('visibilite', 1)
        ->where('id', $salle_classe['classe_id'])
        ->one();
        
        $classe_id = $classe['id'];
        $data_classes = [$salle_classe];

        $eleve_non_affecte = Parcours::table()
            ->select(
            [
                // 'salle_classe.id' => 'salle_classe_id', 
                // 'salle_classe.code' => 'salle_classe_code', 
                // 'salle_classe.libelle' => 'salle_classe',

                // 'classe.id' => 'classe_id',
                // 'classe.code' => 'classe_code',
                // 'classe.libelle' => 'classe',
                
                // 'statut_apprenant.id' => 'statut_apprenant_id',
                // 'statut_apprenant.code' => 'statut_apprenant_code',
                // 'statut_apprenant.libelle' => 'statut_apprenant',
                
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
        ->whereNull('parcours.salle_classe_id')
        ->where('parcours.classe_id', $classe_id)
        ->orderBy('eleve.nom')
        ->get();


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
        $index = 0;
        $arr_index = [];
        foreach($data_classes as $salle_classe){
            $arr_index[$salle_classe['salle_classe_id']] = $index;
            $affectation_salle_eleve[$index] = [];
            $affectation_salle_eleve[$index]['salle_classe_id'] = $salle_classe['salle_classe_id'];
            $affectation_salle_eleve[$index]['salle_classe_code'] = $salle_classe['salle_classe_code'];
            $affectation_salle_eleve[$index]['salle_classe'] = $salle_classe['salle_classe'];
            $affectation_salle_eleve[$index]['eleves'] = [];
            $index++;
        }

        if(empty($data_classes) && !empty($eleve_affecte)){
            // Alors on a des eleves qui ont été mal affectée
            //Faut changer leurs statut et le cas échéants leur retirer de 
            //affectation à une salle de classe.</> ou au deux. 

            //Le meilleur cas demander à l'administrateur de ressoudre ces problemes

            //Prévoir un mécanisme pour implementer 

            //  Call                2           Action
            //  Action ---> Action Request ---> Action perform ---> Action Resolved


        }

       

        foreach($eleve_affecte as $eleve){
            $tmp = [];
            $tmp['eleve_id'] = $eleve['eleve_id'];
            $tmp['eleve_code'] = $eleve['eleve_code'];
            $tmp['nom_complet'] = $eleve['nom_complet'];
            if(isset($arr_index[$eleve['salle_classe_id']]))
                array_push($affectation_salle_eleve[$arr_index[$eleve['salle_classe_id']]]['eleves'] , $tmp);
            else{
                // previos explained situation
                // EN CLAIRE VERIFIER POUR CHAQUE ELEVE 
                //LA CORRESPONDANCE ENTRE LA CLASSE ET LA SALLE DE CLASSE
                //IMPLEMENTER UN MECANISME DE LA BD QUI REALISE CE CONTROLE
                //TRIGGER VERIFIER CORRESPONDANCE SALLE_CLASSE--CLASSE 
            }
        }
        $affectation_classe_eleve = [];
        $affectation_classe_eleve['classe_id'] = $classe['id'];
        $affectation_classe_eleve['classe_code'] = $classe['code'];
        $affectation_classe_eleve['classe'] = $classe['libelle'];
        
        $affectation_classe_eleve['eleve_non_affecte'] = $eleve_non_affecte;
        $affectation_classe_eleve['data_classes'] = $data_classes;
        $affectation_classe_eleve['eleve_affecte'] = $affectation_salle_eleve;
        
        return [$affectation_classe_eleve];
    }
    
    public function getAffectationEleveByClasse($classe_id, $annee_scolaire_id){
        
        $classe =  DBTable::getModel(DBTable::CLASSE)->select(
            [   
                'id',
                'code',
                'libelle'
            ])
        ->where('visibilite', 1)
        ->where('id', $classe_id)
        ->one();
        
        $data_classes =  DBTable::getModel(DBTable::SALLE_CLASSE)->select(
            [   
                'id' => 'salle_classe_id',
                'code' => 'salle_classe_code',
                'libelle' => 'salle_classe'
            ])
        ->where('visibilite', 1)
        ->where('classe_id', $classe_id)
        ->get();

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
        ->whereNotNull('parcours.salle_classe_id')
        ->where('parcours.classe_id', $classe_id)
        ->orderBy(['salle_classe.libelle', 'eleve.nom'])
        ->get();
        
        $affectation_salle_eleve = [];
        $index = 0;
        $arr_index = [];
        foreach($data_classes as $salle_classe){
            $arr_index[$salle_classe['salle_classe_id']] = $index;
            $affectation_salle_eleve[$index] = [];
            $affectation_salle_eleve[$index]['salle_classe_id'] = $salle_classe['salle_classe_id'];
            $affectation_salle_eleve[$index]['salle_classe_code'] = $salle_classe['salle_classe_code'];
            $affectation_salle_eleve[$index]['salle_classe'] = $salle_classe['salle_classe'];
            $affectation_salle_eleve[$index]['eleves'] = [];
            $index++;
        }

        if(empty($data_classes) && !empty($eleve_affecte)){
            // Alors on a des eleves qui ont été mal affectée
            //Faut changer leurs statut et le cas échéants leur retirer de 
            //affectation à une salle de classe.</> ou au deux. 

            //Le meilleur cas demander à l'administrateur de ressoudre ces problemes

            //Prévoir un mécanisme pour implementer 

            //  Call                2           Action
            //  Action ---> Action Request ---> Action perform ---> Action Resolved


        }

       

        foreach($eleve_affecte as $eleve){
            $tmp = [];
            $tmp['eleve_id'] = $eleve['eleve_id'];
            $tmp['eleve_code'] = $eleve['eleve_code'];
            $tmp['nom_complet'] = $eleve['nom_complet'];
            if(isset($arr_index[$eleve['salle_classe_id']]))
                array_push($affectation_salle_eleve[$arr_index[$eleve['salle_classe_id']]]['eleves'] , $tmp);
            else{
                // previos explained situation
                // EN CLAIRE VERIFIER POUR CHAQUE ELEVE 
                //LA CORRESPONDANCE ENTRE LA CLASSE ET LA SALLE DE CLASSE
                //IMPLEMENTER UN MECANISME DE LA BD QUI REALISE CE CONTROLE
                //TRIGGER VERIFIER CORRESPONDANCE SALLE_CLASSE--CLASSE 
            }
        }

        $affectation_classe_eleve['classe_id'] = $classe['id'];
        $affectation_classe_eleve['classe_code'] = $classe['code'];
        $affectation_classe_eleve['classe'] = $classe['libelle'];
        
        $affectation_classe_eleve['data_classes'] = $data_classes;
        $affectation_classe_eleve['eleve_affecte'] = $affectation_salle_eleve;

        return $affectation_classe_eleve;
    }

}