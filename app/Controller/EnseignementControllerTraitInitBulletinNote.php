<?php

namespace App\Controller;

use App\Helpers\S;
use App\Model\Composer;
use App\Model\SalleClasse;
use function Core\Helper\dd;
use App\Repository\ParcoursRepository;
use App\Model\AffectationClasseMatiere;
use App\Model\AffectationPersonnelSalleClasse;

trait EnseignementControllerTraitInitBulletinNote
{

      /**
     * retourne true si il existe des affectations concernant l'affectation des enseignants à une salle de classe
     * pour une année scolaire donnné
     *
     * @param string $annee_scolaire_code
     * @return boolean
     */
    public function verifierExistenceBulletinSallePeriode($annee_scolaire_id, $salle_classe_id, $periode_id)
    {
        $result = Composer::table()
                        ->select([ 'code' => 'id' ])
                        ->where('visibilite', 1)
                        ->where('periode_id', $periode_id)
                        ->where('annee_scolaire_id', $annee_scolaire_id)
                        ->where('salle_classe_id', $salle_classe_id)
                        ->get();
        return ( is_array($result) && count($result)>0);
    }

    //initialisation pour une année scolaire définies
    //To do
    public function initBulletinSallePeriode($annee_scolaire_id, $salle_classe_id, $periode_id )
    {
        $classe_id = SalleClasse::table()->select('classe_id')->where('visibilite', 1)->where('salle_classe_id', $salle_classe_id)->one();
        
        $personnel_id = AffectationPersonnelSalleClasse::table()
                                ->select('personnel_id')
                                ->where('annee_scolaire_id', $annee_scolaire_id)
                                ->where('salle_classe_id', $salle_classe_id)
                                ->where('visibilite', 1)
                                ->one();
        
        $matieres = AffectationClasseMatiere::table()
                                ->select('matiere_id')
                                ->where('annee_scolaire_id', $annee_scolaire_id)
                                ->where('classe_id', $classe_id)
                                ->where('visibilite', 1)
                                ->get();

        $eleves = ( new ParcoursRepository() )->getAffectationEleveBySalleClasse($salle_classe_id, $annee_scolaire_id);
 
        for ($i = 0; $i < count($matieres); $i++){
            $matiere_id = $matieres[$i];
            for ($j = 0; $j <count($eleves); $j++){
                $eleve_id = $eleves[$j]['eleve_id'];
                $data = [
                    'annee_scolaire_id' => $annee_scolaire_id, 
                    'salle_classe_id' => $salle_classe_id, 
                    'classe_id' => $classe_id, 
                    'periode_id' => $periode_id, 
                    'code' =>  Composer::generateCode(),
                    'personnel_id' => $personnel_id,
                    'matiere_id' => $matiere_id,
                    'eleve_id' => $eleve_id,
                    'note' => null,
                ];
                Composer::table()->insert($data)->execute();
            }
        }
       
    }

    public function genererBulletinSalle($annee_scolaire_code)
    {
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
    }

}