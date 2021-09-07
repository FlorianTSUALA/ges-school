<?php

namespace App\Repository;

use App\Helpers\S;
use App\Model\DBTable;

use App\Model\Periode;
use App\Model\Parcours;
use App\Helpers\Helpers;
use Core\Session\Request;
use function Core\Helper\dd;
use function Core\Helper\vd;
use Core\Repository\BaseRepository;
use App\Model\AffectationClasseMatiere;
use ClanCats\Hydrahon\Query\Expression;

class FactureRepository extends BaseRepository{
        
  public function get_paie_facture_total($personnel_id, $date = Null ){
      if($date == NULL)
        $date = Helpers::today();      
      $req =
      " SELECT  sum(facture.montant) as total 
        from facture
        where facture.visibilite = 1  and  facture.date_paiement = '$date' and facture.personnel_id = $personnel_id
       
      ";
        $result = (new self)->query($req);
        return (new self)->toObject($result);
  }
      
  public function get_paie_facture_activite($personnel_id, $date = Null ){

    if($date == NULL)
    $date = Helpers::today(); 
       $req =
       " SELECT sum(abonnement_detail.total) as total, activite.libelle 
       from abonnement_activite 
       INNER JOIN facture on facture.id = abonnement_activite.facture_id
       INNER JOIN abonnement_detail on abonnement_activite.id = abonnement_detail.abonnement_id
       INNER JOIN activite on activite.id = abonnement_activite.activite_id
       where facture.visibilite = 1  and abonnement_detail.type_abonnement = 'ACTIVITE' and facture.date_paiement = '$date' and facture.personnel_id = $personnel_id
       group by activite.libelle 
      ";

      $result = (new self)->query($req);
      return (new self)->toObject($result);
  }

  public function get_paie_facture_activite_total($personnel_id, $date = Null ){

    if($date == NULL)
    $date = Helpers::today(); 
       $req =
       " SELECT sum(abonnement_detail.total) as total 
       from abonnement_activite 
       INNER JOIN facture on facture.id = abonnement_activite.facture_id
       INNER JOIN abonnement_detail on abonnement_activite.id = abonnement_detail.abonnement_id 
       INNER JOIN activite on activite.id = abonnement_activite.activite_id
       where facture.visibilite = 1  and abonnement_detail.type_abonnement = 'ACTIVITE' and facture.date_paiement = '$date' and facture.personnel_id = $personnel_id
      
      ";

      $result = (new self)->query($req);
      return (new self)->toObject($result);
  }

  public function get_paie_facture_cantine($personnel_id, $date = Null ){
   
    if($date == NULL)
    $date = Helpers::today(); 
    $req =
      " SELECT sum(abonnement_detail.total) as total
        from abonnement_cantine
        INNER JOIN facture on facture.id = abonnement_cantine.facture_id
        INNER JOIN abonnement_detail on abonnement_cantine.id = abonnement_detail.abonnement_id
        where facture.visibilite = 1  and abonnement_detail.type_abonnement = 'CANTINE' 
        and  facture.date_paiement = '$date' 
        and facture.personnel_id = $personnel_id
        ";

        $result = (new self)->query($req);
        return (new self)->toObject($result);
  }

  public function get_paie_facture_scolarite($personnel_id, $date = Null ){

    if($date == NULL)
          $date = Helpers::today();   
    $req =
        " SELECT sum(pension_eleve.montant) as total
        from facture
        left join pension_eleve  on facture.id = pension_eleve.facture_id
        left join tranche_scolaire on tranche_scolaire.id = pension_eleve.tranche_scolaire_id
        left join type_pension on type_pension.id = pension_eleve.type_pension_id
        where  facture.visibilite = 1 and type_pension.code = 'SCOLARITE' and  facture.date_paiement = '$date' and facture.personnel_id = $personnel_id
        order by facture.date_paiement";


$result = (new self)->query($req);
        return (new self)->toObject($result);
 }

  public function get_paie_facture_inscription($personnel_id, $date = Null ){

    if($date == NULL)
          $date = Helpers::today(); 
    $req =
        " SELECT sum(pension_eleve.montant) as total
    
        from facture
        left join pension_eleve  on facture.id = pension_eleve.facture_id
        left join tranche_scolaire on tranche_scolaire.id = pension_eleve.tranche_scolaire_id
        left join type_pension on type_pension.id = pension_eleve.type_pension_id
        where  facture.visibilite = 1 and type_pension.code = 'INSCRIPTION' and  facture.date_paiement = '$date' and facture.personnel_id = $personnel_id
        order by facture.date_paiement";

      $result = (new self)->query($req);
      return (new self)->toObject($result);

   
  }

}