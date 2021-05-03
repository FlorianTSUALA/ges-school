<?php

namespace App\Repository;

use App\Model\DBTable;
use App\Model\Parcours;
use ClanCats\Hydrahon\Query\Expression;
use Core\Repository\BaseRepository;

use function Core\Helper\dd;
use function Core\Helper\vd;

class ParcoursRepository extends BaseRepository{
    
    public function getAffectationEleveBySalleClasse($salle_classe_id, $annee_scolaire_id, $seulementEleveDejaAffecte = false){
        
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
        $salle_classes = [$salle_classe];

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
        foreach($salle_classes as $salle_classe){
            $arr_index[$salle_classe['salle_classe_id']] = $index;
            $affectation_salle_eleve[$index] = [];
            $affectation_salle_eleve[$index]['salle_classe_id'] = $salle_classe['salle_classe_id'];
            $affectation_salle_eleve[$index]['salle_classe_code'] = $salle_classe['salle_classe_code'];
            $affectation_salle_eleve[$index]['salle_classe'] = $salle_classe['salle_classe'];
            $affectation_salle_eleve[$index]['eleves'] = [];
            $index++;
        }

        if(empty($salle_classes) && !empty($eleve_affecte)){
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
        
        if($seulementEleveDejaAffecte)
            return $affectation_salle_eleve;

        $affectation_classe_eleve = [];
        $affectation_classe_eleve['classe_id'] = $classe['id'];
        $affectation_classe_eleve['classe_code'] = $classe['code'];
        $affectation_classe_eleve['classe'] = $classe['libelle'];
        
        $affectation_classe_eleve['eleve_non_affecte'] = $eleve_non_affecte;
        $affectation_classe_eleve['salle_classes'] = $salle_classes;
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
        
        $salle_classes =  DBTable::getModel(DBTable::SALLE_CLASSE)->select(
            [   
                'id' => 'salle_classe_id',
                'code' => 'salle_classe_code',
                'libelle' => 'salle_classe'
            ])
        ->where('visibilite', 1)
        ->where('classe_id', $classe_id)
        ->get();

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
        ->whereNotNull('parcours.salle_classe_id')
        ->where('parcours.classe_id', $classe_id)
        ->orderBy(['salle_classe.libelle', 'eleve.nom'])
        ->get();
        
        $affectation_salle_eleve = [];
        $index = 0;
        $arr_index = [];
        foreach($salle_classes as $salle_classe){
            $arr_index[$salle_classe['salle_classe_id']] = $index;
            $affectation_salle_eleve[$index] = [];
            $affectation_salle_eleve[$index]['salle_classe_id'] = $salle_classe['salle_classe_id'];
            $affectation_salle_eleve[$index]['salle_classe_code'] = $salle_classe['salle_classe_code'];
            $affectation_salle_eleve[$index]['salle_classe'] = $salle_classe['salle_classe'];
            $affectation_salle_eleve[$index]['eleves'] = [];
            $index++;
        }

        if(empty($salle_classes) && !empty($eleve_affecte)){
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
        
        $affectation_classe_eleve['eleve_non_affecte'] = $eleve_non_affecte;
        $affectation_classe_eleve['salle_classes'] = $salle_classes;
        $affectation_classe_eleve['eleve_affecte'] = $affectation_salle_eleve;

        return $affectation_classe_eleve;
    }
    
    public function getAffectationEleve($annee_scolaire_id){
        
        $classes =  DBTable::getModel(DBTable::CLASSE)->select('id')
        ->where('visibilite', '=', 1)
        ->orderBy('libelle')
        ->get();

        $index = 0;
        foreach($classes as $classe){
            $affectation_classe_eleve[$index++] = $this->getAffectationEleveByClasse($classe['id'], $annee_scolaire_id);    
        }

        return $affectation_classe_eleve;
    }

}