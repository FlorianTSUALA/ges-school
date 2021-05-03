<?php

namespace App\Controller;

use App\Helpers\S;
use App\Model\Classe;
use App\Model\DBTable;
use App\Helpers\Helpers;
use App\Model\Personnel;
use Config\Invariant\API;

use Core\Session\Request;

use App\Model\SalleClasse;
use App\Model\AnneeScolaire;
use function Core\Helper\dd;
use function Core\Helper\vd;
use ClanCats\Hydrahon\Query\Expression;
use App\Model\AffectationPersonnelSalleClasse;

trait AffectationControllerTraitSalleEnseignant 
{
    

    //initialisation pour une année scolaire définies
    //To do
    public function initSalleEnseignant()
    {
        $salle_classes = (SalleClasse::table()->select(['id'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get());
        $annee_scolaires = (AnneeScolaire::table()->select(['id'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get());
        // $personnels = (Personnel::table()->select([ 'code' => 'id' , new Expression("concat(nom,' ',prenom) as value")])->where('visibilite', 1)->get());

        for ($i = 0; $i <count($annee_scolaires); $i++){
            $annee_scolaire = $annee_scolaires[$i]['id'];
            for ($j = 0; $j <count($salle_classes); $j++){
                $salle_classe = $salle_classes[$j]['id'];
                $data = ['annee_scolaire_id' => $annee_scolaire, 'salle_classe_id' => $salle_classe, 'code' =>  AffectationPersonnelSalleClasse::generateCode()];
                // vd($data); 
                AffectationPersonnelSalleClasse::table()->insert($data)->execute();
            }
        }
       
    }

    public function genererAffectationSalleEnseignant($annee_scolaire_code)
    {
        $annee_scolaire_id = AnneeScolaire::getId(DBTable::ANNEE_SCOLAIRE, $annee_scolaire_code);
        $this->_genererAffectationSalleEnseignant($annee_scolaire_id);
        echo true;
    }

    public function verifierExistenceAffectationSalleEnseignant($annee_scolaire_code)
    {
        $annee_scolaire_id = AnneeScolaire::getId(DBTable::ANNEE_SCOLAIRE, $annee_scolaire_code);
        echo $this->_verifierExistenceAffectationSalleEnseignant($annee_scolaire_id);
    }

    /**
     * permet de generer des entrees par défaut pour l'affectation d'un enseignant à 
     * une salle de classe pour une année scolaire donnée
     *
     * @param string $annee_scolaire_code
     * @return void
     */
    private function _genererAffectationSalleEnseignant($annee_scolaire_id)
    {
        $salle_classes = (SalleClasse::table()->select(['id'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get());
        for ($i = 0; $i <count($salle_classes); $i++){
            $salle_classe = $salle_classes[$i]['id'];
            $data = ['annee_scolaire_id' => $annee_scolaire_id, 'salle_classe_id' => $salle_classe, 'code' =>  AffectationPersonnelSalleClasse::generateCode()];
            AffectationPersonnelSalleClasse::table()->insert($data)->execute();
        }
    }

    /**
     * retourne true si il existe des affectations concernant l'affectation des enseignants à une salle de classe
     * pour une année scolaire donnné
     *
     * @param string $annee_scolaire_code
     * @return boolean
     */
    private function _verifierExistenceAffectationSalleEnseignant($annee_scolaire_id)
    {
        $result = AffectationPersonnelSalleClasse::table()->select([ 'code' => 'id' ])->where('visibilite', '=', 1)->where('annee_scolaire_id', $annee_scolaire_id)->get();
        return ( is_array($result) && count($result)>0);
    }

    /**
     * retourne true si il existe des affectations concernant l'affectation des enseignants à une salle de classe
     * pour une année scolaire donnné
     *
     * @param string $annee_scolaire_code
     * @return boolean
     */
    private function verifierExistenceEnseignantDejaAffecte($annee_scolaire_id, $personnel_id)
    {
        $result = AffectationPersonnelSalleClasse::table()->select([ 'code' => 'id' ])
                    ->where('visibilite', '=', 1)
                    ->where('annee_scolaire_id', $annee_scolaire_id)
                    ->where('personnel_id', $personnel_id)
                    ->get();
        return ( is_array($result) && count($result)>0);
    }

    public function affecterSalleEnseignant()
    {
        $route = 'affectation_salle_enseignant';
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        $affectationExist = $this->_verifierExistenceAffectationSalleEnseignant($annee_scolaire_id);
       
        if(!$affectationExist)
            $this->_genererAffectationSalleEnseignant($annee_scolaire_id);

            $salle_classes = Helpers::toJSON(SalleClasse::table()->select(['id'=>'id', 'libelle' => 'value'])->where('visibilite', '=', 1)->get());
        $classes = Helpers::toJSON(Classe::table()->select(['id'=>'id', 'libelle' => 'value'])->where('visibilite', '=', 1)->get());
        $personnels = Helpers::toJSON(Personnel::table()->select([ 'id' => 'id' , new Expression("concat(nom,' ',prenom) as value")])->where('visibilite', 1)->get());
        $affectation_personnel_salle_classes = Helpers::toJSON(AffectationPersonnelSalleClasse::table()
            ->select(
                [
                    'salle_classe_id' => 'salle_classe', 
                    'affectation_personnel_salle_classe.personnel_id' => 'personnel', 
                    'salle_classe.classe_id' => 'classe'
                ])
            ->join('salle_classe', 'salle_classe.id', '=', 'affectation_personnel_salle_classe.salle_classe_id')
            ->where('affectation_personnel_salle_classe.visibilite', '=', 1)
            ->where('annee_scolaire_id', $annee_scolaire_id)
            ->get());
        $this->render('sections.affectation.salle_enseignant.affectation', compact('route', 'classes', 'salle_classes', 'personnels', 'affectation_personnel_salle_classes'));
    }
     
    
        
    public function modifierAffectationSalleEnseignant()
    {
        $personnel_id = Request::getSecParam('personnel_id', NULL);
        $salle_classe_id = Request::getSecParam('salle_classe_id');
        
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        if( ($personnel_id != NULL) && $this->verifierExistenceEnseignantDejaAffecte($annee_scolaire_id, $personnel_id)){
            $data[API::TAG_REPORT] = false;
            $data[API::TAG_DATA] = 'Attention ce personnel est déja affecté à une salle de classe !!!';
        }else{
            AffectationPersonnelSalleClasse::table()
            ->update(['personnel_id' => $personnel_id])
            ->where('annee_scolaire_id', $annee_scolaire_id)
            ->where('salle_classe_id', $salle_classe_id)
            ->execute();

            $data[API::TAG_REPORT] = true;
            $data[API::TAG_DATA] = 'Affectation enregistrée avec success';
            
        }

        $this->sendResponseAndExit(Helpers::toJSON($data, TRUE));
        
    }
        
    public function listeAffectationSalleEnseignant()
    {
        $classe_id = Request::getSecParam('classe', NULL);

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $model = AffectationPersonnelSalleClasse::table()
            ->select(
                [
                    'salle_classe_id' => 'salle_classe', 
                    'affectation_personnel_salle_classe.personnel_id' => 'personnel', 
                    'salle_classe.classe_id' => 'classe'
                ])
            ->join('salle_classe', 'salle_classe.id', '=', 'affectation_personnel_salle_classe.salle_classe_id')
            ->where('affectation_personnel_salle_classe.visibilite', '=', 1);
        if(!is_null($classe_id))       
            $model = $model->where('salle_classe.classe_id', $classe_id);

        $data = $model->where('annee_scolaire_id', $annee_scolaire_id)->get();
            
        $this->sendResponseAndExit(Helpers::toJSON($data), true);

    }
        
        
}
    