<?php

namespace App\Repository;

use App\Model\DBTable;
use App\Model\Facture;

use function Core\Helper\dd;
use App\Model\AbonnementCantine;

use Core\Repository\BaseRepository;
use ClanCats\Hydrahon\Query\Sql\Func as F;

class CantineRepository extends BaseRepository{
    


    public function getInfoByClasseDate($date = null, $filter_by = 'ALL', $code = null){

        $annee_scolaire_id = (new AnneeScolaireRepository())->getActive('id');

        $facture = Facture::table();
        $info_abonnement = $facture->select('facture.id')
            ->join(DBTable::ABONNEMENT_CANTINE, 'abonnement_cantine.facture_id', '=', 'facture.id')
            ->join(DBTable::ELEVE, 'eleve.id', '=', 'abonnement_cantine.eleve_id')
            ->join(DBTable::ABONNEMENT_DETAIL, 'abonnement_detail.abonnement_id', '=', 'abonnement_cantine.id')
            ->join(DBTable::PARCOURS, 'parcours.eleve_id', '=', 'eleve.id')
            ->where(new F('date', 'abonnement_cantine.date_debut'), '<=', $date)
            ->where(new F('date', 'abonnement_cantine.date_fin'), '>=', $date);
            
        switch ($filter_by){
            case 'CLASSE': $info_abonnement = $info_abonnement->where('parcours.classe_id', '=', $code); break;
            case 'SALLE_CLASSE': $info_abonnement = $info_abonnement->where('parcours.salle_classe_id', '=', $code); break;
            default: ;
        }

        $info_abonnement = $info_abonnement->where('parcours.annee_scolaire_id', '=', $annee_scolaire_id)
        ->where('facture.visibilite', '=', 1)
        ->get();
        return $info_abonnement;
       
    }

    public function getInfoByClasse_Date(string $salle_classe_id = null, $day, $criteria='salle_classe'){

        $abonnement = AbonnementCantine::table();

        if(!$salle_classe_id){
            $abonnement = $abonnement->select(['nom', 'prenom', 'salle_classe.libelle'=>'classe'])
            ->join('eleve', 'eleve.id','=','abonnement_cantine.eleve_id')
            ->join('parcours','parcours.eleve_id','=','eleve.id')
            ->join('salle_classe','parccours.salle_classe_id','=','salle_classe.id')
            ->where($day)
            -> BETWEEN ('abonnement_cantine.date_debut'  AND 'abonnement_cantine.date_fin');

        }
       else {
        $abonnement = $abonnement->select(['nom', 'prenom', 'salle_classe.libelle'=>'classe'])
        ->join('eleve', 'eleve.id','=','abonnement_cantine.eleve_id')
        ->join('parcours','parcours.eleve_id','=','eleve.id')
        ->join('salle_classe','parccours.salle_classe_id','=','salle_classe.id')
        ->where($day)
        -> BETWEEN ('abonnement_cantine.date_debut'  AND 'abonnement_cantine.date_fin')
        ->where('salle_class.id','=','$salle_classe_id');
       
       }
       dd($abonnement);
       
    }

          
    public function getInfoByPeriod( $start_date, $end_date){

    }

 
    public function getInfoBySalleClassePeriod( $start_date, $end_date){

    }

        
    public function getInfo(string $classe_id){
       
    }

       
    

}