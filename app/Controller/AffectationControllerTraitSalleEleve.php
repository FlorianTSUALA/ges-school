<?php

namespace App\Controller;

use App\Helpers\S;
use App\Model\Classe;
use Core\Model\Model;
use App\Model\DBTable;
use App\Model\Parcours;
use App\Helpers\Helpers;
use Config\Invariant\API;

use Core\Session\Request;
use App\Model\SalleClasse;
use function Core\Helper\dd;
use function Core\Helper\vd;

use App\Repository\ParcoursRepository;

trait AffectationControllerTraitSalleEleve
{

    /**
     * permet de savoir si une matiere est affectée à une classe pour une année scolaire donnée.
     *
     * @param int $annee_scolaire_id
     * @param int $salle_classe_id
     * @param int $classe_id
     * @return bool Returns 1 si affecté et 0 sinon
     */
    private function verifierExistenceSalleEleve($annee_scolaire_id, $salle_classe_id, $classe_id)
    {
        $result = Parcours::table()
                    ->select([ 'code' => 'id' ])
                    ->where('visibilite', '=', 1)
                    ->where('annee_scolaire_id', $annee_scolaire_id)
                    ->where('salle_classe_id', $salle_classe_id)
                    ->where('classe_id', $classe_id)
                    ->get();
        return ( is_array($result) && count($result)>0);
    }

    public function affecterSalleEleve()
    {
        $route = 'affectation_salle_eleve';

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        // $classe_id = Request::getSecParam('classe');
        
        $salle_classes = (SalleClasse::table()->select(['id'=>'id', 'libelle' => 'value'])->where('visibilite', 1)->get());
        $classes = Helpers::toJSON(Classe::table()->select(['id'=>'id', 'libelle' => 'value'])->where('visibilite', 1)->get());
        $affectation_salle_eleve = (
            Parcours::table()
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
                    'eleve.nom' => 'eleve_nom',
                    'eleve.prenom' => 'eleve_prenom'
                ])
            ->join('eleve', 'eleve.id', '=', 'parcours.eleve_id')
            ->join('classe', 'classe.id', '=', 'parcours.classe_id')
            ->join('salle_classe', 'salle_classe.id', '=', 'parcours.salle_classe_id')
            ->join('statut_apprenant', 'statut_apprenant.id', '=', 'parcours.statut_apprenant_id')
            ->where('parcours.visibilite', 1)
            ->where('parcours.annee_scolaire_id', $annee_scolaire_id)
            ->whereNotNull('parcours.classe_id')
            // ->where('classe_id', $classe_id)
            ->orderBy('eleve.nom')
            ->get());
        Helpers::groupBy($affectation_salle_eleve, 'classe');
        $this->render('sections.affectation.salle_eleve.affectation', compact('route', 'classes', 'salle_classes', 'affectation_salle_eleve'));
    }

    //-- NEVER USED
    public function listeAffectationSalleEleve()
    {
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

       $affectation_salle_eleve = 
            Parcours::table()
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
                    'eleve.nom' => 'eleve_nom',
                    'eleve.prenom' => 'eleve_prenom'
                ])
            ->join('eleve', 'eleve.id', '=', 'parcours.eleve_id')
            ->join('classe', 'classe.id', '=', 'parcours.classe_id')
            ->join('salle_classe', 'salle_classe.id', '=', 'parcours.salle_classe_id')
            ->join('statut_apprenant', 'statut_apprenant.id', '=', 'parcours.statut_apprenant_id')
            ->where('parcours.visibilite', 1)
            ->where('parcours.annee_scolaire_id', $annee_scolaire_id)
            ->whereNotNull('parcours.classe_id')
            ->where('parcours.salle_classe_id', $salle_classe_id)
            ->get();
        $this->sendResponseAndExit(Helpers::toJSON($affectation_salle_eleve), true);

    }

    public function modifierAffectationSalleEleve()
    {
        $salle_classe_id = Request::getSecParam('salle_classe_id', NULL);
        $classe_id = Request::getSecParam('classe_id', NULL);
        
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        if( ($salle_classe_id != NULL) && $this->verifierExistenceSalleEleve($annee_scolaire_id, $salle_classe_id, $classe_id)){
            Parcours::table()
            ->update([
                'salle_classe_id' => $salle_classe_id
                ])
            ->where('annee_scolaire_id', $annee_scolaire_id)
            ->where('classe_id', $classe_id)
            ->where('salle_classe_id', $salle_classe_id)
            ->execute();

            $data[API::TAG_REPORT] = true;
            $data[API::TAG_DATA] = 'Affectation enregistrée avec success';
        }else{
            
            $data[API::TAG_REPORT] = false;
            $data[API::TAG_DATA] = 'Impossible de réaliser cette opération; Verifier les champs selectionnées !!!';
            
        }

        $this->sendResponseAndExit(Helpers::toJSON($data, TRUE));
        
    }
    
    public function enregistrerAffectationSalleEleve(){
        $salle_classe_id = Request::getSecParam('salle_classe_id', NULL);
        $classe_id = Request::getSecParam('classe_id', NULL);
        
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        if(is_null($classe_id)){
            $data[API::TAG_REPORT] = false;
            $data[API::TAG_DATA] = 'Classe ou matiere non selectionnée !!!';
        }else{
            if( ($salle_classe_id != NULL) && $this->verifierExistenceSalleEleve($annee_scolaire_id, $salle_classe_id, $classe_id)){
                $data[API::TAG_REPORT] = false;
                $data[API::TAG_DATA] = 'Cette affectation existe déja !!!';
            }else{
                Parcours::table()
                ->update()
                ->set('salle_classe_id', $salle_classe_id)
                ->where('visibilite', 1)
                ->where('annee_scolaire_id', $annee_scolaire_id)
                ->where('classe_id', $classe_id)
                ->execute();

                $data[API::TAG_REPORT] = true;
                $data[API::TAG_DATA] = 'Affectation enregistrée avec success';
            }
        }

        $this->sendResponseAndExit(Helpers::toJSON($data, TRUE));
    }
    
    public function supprimerAffectationSalleEleve(){
        $salle_classe_id = Request::getSecParam('salle_classe_id', NULL);
        $classe_id = Request::getSecParam('classe_id', NULL);
        
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        if( ($salle_classe_id != NULL) && $this->verifierExistenceSalleEleve($annee_scolaire_id, $salle_classe_id, $classe_id)){
            Parcours::table()
            ->update([
                'salle_classe_id' => null
                ])
            ->where('annee_scolaire_id', $annee_scolaire_id)
            ->where('classe_id', $classe_id)
            ->where('salle_classe_id', $salle_classe_id)
            ->execute();

            $data[API::TAG_REPORT] = true;
            $data[API::TAG_DATA] = 'Affectation supprimée avec succes !!!';
            
        }else{
            $data[API::TAG_REPORT] = false;
            $data[API::TAG_DATA] = 'Affectation introuvable !!!';
        }

        $this->sendResponseAndExit(Helpers::toJSON($data, TRUE));
    }
     
    public function apiSaveAffectationEleveBySalleClasse(){
        
        $salle_classe_code = Request::getSecParam('salle_classe_id', NULL);
        $salle_classe_id = Model::getId(DBTable::SALLE_CLASSE, $salle_classe_code);
        
        $affectations = $_POST['affectations'];
        $desaffectations = $_POST['desaffectations'];
        
        // vd($affectations);
        // dd($desaffectations);

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        for ($i = 0; $i<count($affectations??[]); $i++){
            $eleve_id = Model::getId(DBTable::ELEVE, $affectations[$i]);
            Parcours::table()
            ->update()
            ->set('salle_classe_id', $salle_classe_id)
            ->where('annee_scolaire_id', $annee_scolaire_id)
            ->where('eleve_id', $eleve_id)
            ->execute();
        }

        for ($i = 0; $i<count($desaffectations??[]); $i++){
            $eleve_id = Model::getId(DBTable::ELEVE, $desaffectations[$i]);
            Parcours::table()
            ->update()
            ->set(['salle_classe_id' => null])
            ->where('annee_scolaire_id', $annee_scolaire_id)
            ->where('eleve_id', $eleve_id)
            ->execute();
        }
        
        $data = ( new ParcoursRepository() )->getAffectationEleveBySalleClasse($salle_classe_id, $annee_scolaire_id);

        $this->sendResponseAndExit( Helpers::toJSON($data), true);    
    
    }
     
    public function apiInfoAffectationEleveBySalleClasse(){
        
        $salle_classe_code = Request::getSecParam('salle_classe_id', NULL);
        $salle_classe_id = Model::getId(DBTable::SALLE_CLASSE, $salle_classe_code);
        
        
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $data = (new ParcoursRepository() )->getAffectationEleveBySalleClasse($salle_classe_id, $annee_scolaire_id);

        $this->sendResponseAndExit(Helpers::toJSON($data), true);    
    
    }
         
    public function apiInfoAffectationEleve(){
        $classe_id = Request::getSecParam('classe_id', NULL);

        // $code = ($code == 0)? null : $code;
        // $classe_id = (is_null($classe_id))? $code : $classe_id;
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        if(is_null($classe_id))
            $data = (new ParcoursRepository() )->getAffectationEleve($annee_scolaire_id);
        else
            $data = [(new ParcoursRepository() )->getAffectationEleveByClasse($classe_id, $annee_scolaire_id)];

        $this->sendResponseAndExit(Helpers::toJSON($data), true);    

    }

}
    