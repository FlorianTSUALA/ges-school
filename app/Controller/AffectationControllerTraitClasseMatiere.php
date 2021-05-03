<?php

namespace App\Controller;

use App\Helpers\S;
use App\Model\Classe;
use App\Model\DBTable;
use App\Helpers\Helpers;
use App\Model\matiere;
use Config\Invariant\API;

use Core\Session\Request;
use App\Model\AffectationClasseMatiere;

trait AffectationControllerTraitClasseMatiere
{
  
    
    /**
     * permet de savoir si une matiere est affectée à une classe pour une année scolaire donnée.
     *
     * @param int $annee_scolaire_id
     * @param int $matiere_id
     * @param int $classe_id
     * @return bool Returns 1 si affecté et 0 sinon
     */
    private function verifierExistenceClasseMatiere($annee_scolaire_id, $matiere_id, $classe_id)
    {
        $result = AffectationClasseMatiere::table()->select([ 'code' => 'id' ])
                    ->where('visibilite', '=', 1)
                    ->where('annee_scolaire_id', $annee_scolaire_id)
                    ->where('matiere_id', $matiere_id)
                    ->where('classe_id', $classe_id)
                    ->get();
        return ( is_array($result) && count($result)>0);
    }

    public function affecterClasseMatiere()
    {
        $route = 'affectation_classe_matiere';

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        
        //@TODO Reconduction si non existante à partir de l'affectation de l'année précedente

        $matieres = Helpers::toJSON(Matiere::table()->select(['id'=>'id', 'libelle' => 'value'])->where('visibilite', 1)->get());
        $classes = Helpers::toJSON(Classe::table()->select(['id'=>'id', 'libelle' => 'value'])->where('visibilite', 1)->get());
        $affectation_classe_matiere = Helpers::toJSON(AffectationClasseMatiere::table()
            ->select(
                [
                    'classe_id' => 'classe', 
                    'affectation_classe_matiere.matiere_id' => 'matiere', 
                    'affectation_classe_matiere.coefficient' => 'coefficient' 
                ])
            ->where('affectation_classe_matiere.visibilite', '=', 1)
            ->where('annee_scolaire_id', $annee_scolaire_id)
            ->get());
        $this->render('sections.affectation.classe_matiere.affectation', compact('route', 'classes', 'matieres', 'affectation_classe_matiere'));
        
    }

    public function listeAffectationClasseMatiere()
    {
        $classe_id = Request::getSecParam('classe', NULL);

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $model = AffectationClasseMatiere::table()
            ->select(
                [
                    'affectation_classe_matiere.classe_id' => 'classe', 
                    'affectation_classe_matiere.matiere_id' => 'matiere', 
                    'affectation_classe_matiere.coefficient' => 'coefficient' 
                ])
            ->where('affectation_classe_matiere.visibilite', 1)
            ->where('affectation_classe_matiere.annee_scolaire_id', $annee_scolaire_id);
        
        if(!is_null($classe_id))
            $model->where('affectation_classe_matiere.classe_id', $classe_id);
        
        $data = $model->get();
        $this->sendResponseAndExit(Helpers::toJSON($data), true);

    }

    public function modifierAffectationClasseMatiere()
    {
        $matiere_id = Request::getSecParam('matiere_id', NULL);
        $classe_id = Request::getSecParam('classe_id', NULL);
        $coefficient = Request::getSecParam('coefficient', 1);
        
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        if( ($matiere_id != NULL) && $this->verifierExistenceClasseMatiere($annee_scolaire_id, $matiere_id, $classe_id)){
            AffectationClasseMatiere::table()
            ->update([
                'coefficient' => $coefficient
                ])
            ->where('annee_scolaire_id', $annee_scolaire_id)
            ->where('classe_id', $classe_id)
            ->where('matiere_id', $matiere_id)
            ->execute();

            $data[API::TAG_REPORT] = true;
            $data[API::TAG_DATA] = 'Affectation enregistrée avec success';
        }else{
            
            $data[API::TAG_REPORT] = false;
            $data[API::TAG_DATA] = 'Impossible de réaliser cette opération; Verifier les champs selectionnées !!!';
            
        }

        $this->sendResponseAndExit(Helpers::toJSON($data, TRUE));
        
    }
    
    public function enregistrerAffectationClasseMatiere(){
        $matiere_id = Request::getSecParam('matiere_id', NULL);
        $classe_id = Request::getSecParam('classe_id', NULL);
        $coefficient = Request::getSecParam('coefficient', 0);
        
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        if(is_null($classe_id) || is_null($matiere_id)){
            
            $data[API::TAG_REPORT] = false;
            $data[API::TAG_DATA] = 'Classe ou matiere non selectionnée !!!';
            
        }else{
            if( ($matiere_id != NULL) && $this->verifierExistenceClasseMatiere($annee_scolaire_id, $matiere_id, $classe_id)){
                $data[API::TAG_REPORT] = false;
                $data[API::TAG_DATA] = 'Cette affectation existe déja !!!';
            }else{
                AffectationClasseMatiere::table()
                ->insert([
                    'matiere_id' => $matiere_id,
                    'annee_scolaire_id' => $annee_scolaire_id,
                    'classe_id' => $classe_id,
                    'coefficient' => $coefficient
                ])->execute();

                $data[API::TAG_REPORT] = true;
                $data[API::TAG_DATA] = 'Affectation enregistrée avec success';
                
            }
        }

        $this->sendResponseAndExit(Helpers::toJSON($data, TRUE));
    }
    
    public function supprimerAffectationClasseMatiere(){
        $matiere_id = Request::getSecParam('matiere_id', NULL);
        $classe_id = Request::getSecParam('classe_id', NULL);
        
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        if( ($matiere_id != NULL) && $this->verifierExistenceClasseMatiere($annee_scolaire_id, $matiere_id, $classe_id)){
            AffectationClasseMatiere::table()
            ->update([
                'visibilite' => 0
                ])
            ->where('annee_scolaire_id', $annee_scolaire_id)
            ->where('classe_id', $classe_id)
            ->where('matiere_id', $matiere_id)
            ->execute();

            $data[API::TAG_REPORT] = true;
            $data[API::TAG_DATA] = 'Suppression effectuée avec succes !!!';
            
        }else{
            $data[API::TAG_REPORT] = false;
            $data[API::TAG_DATA] = 'Affectation introuvable !!!';
        }

        $this->sendResponseAndExit(Helpers::toJSON($data, TRUE));
    }
        
}
    