<?php

namespace App\Repository;

use App\Model\DBTable;
use ClanCats\Hydrahon\Query\Expression;

use function Core\Helper\dd;
use function Core\Helper\vd;
use Core\Repository\BaseRepository;

class VersementRepository extends BaseRepository{
    
      
    public function get_eleve_versement_detail_scolarite($eleve_id, $annee_scolaire_id){
        $req =
            "                
            select  pension_eleve.montant, facture.date_paiement, pension_eleve.reduction, tranche_scolaire.libelle
            from facture
            left join pension_eleve  on facture.id = pension_eleve.facture_id
            left join tranche_scolaire on tranche_scolaire.id = pension_eleve.tranche_scolaire_id
            left join type_pension on type_pension.id = pension_eleve.type_pension_id
            where pension_eleve.eleve_id = $eleve_id and facture.annee_scolaire_id = $annee_scolaire_id
            and facture.visibilite = 1 and type_pension.code = 'SCOLARITE'
            order by facture.date_paiement
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

 

    public function get_eleve_versement_detail_cantine($eleve_id, $annee_scolaire_id){
        $req =
            "                
            SELECT abonnement_cantine.eleve_id, abonnement_detail.total, abonnement_detail.periode, abonnement_detail.multiplicateur, abonnement_detail.prix_unitaire, abonnement_detail.date_debut, abonnement_detail.date_fin, facture.date_paiement
            from abonnement_cantine
            INNER JOIN facture on facture.id = abonnement_cantine.facture_id
            INNER JOIN abonnement_detail on abonnement_cantine.id = abonnement_detail.abonnement_id
            where facture.visibilite = 1  and abonnement_detail.type_abonnement = 'CANTINE' and abonnement_cantine.eleve_id = $eleve_id and facture.annee_scolaire_id = $annee_scolaire_id
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

    public function get_eleve_versement_detail_activite($eleve_id, $annee_scolaire_id){
        $req =
            "                
            SELECT abonnement_activite.eleve_id, abonnement_detail.total, abonnement_detail.periode, abonnement_detail.multiplicateur, abonnement_detail.prix_unitaire, abonnement_detail.date_debut, abonnement_detail.date_fin, activite.libelle, facture.date_paiement
            from abonnement_activite 
            INNER JOIN facture on facture.id = abonnement_activite.facture_id
            INNER JOIN abonnement_detail on abonnement_activite.id = abonnement_detail.abonnement_id
            INNER JOIN activite on activite.id = abonnement_activite.activite_id
            where facture.visibilite = 1  and abonnement_detail.type_abonnement = 'ACTIVITE' and abonnement_activite.eleve_id = $eleve_id and facture.annee_scolaire_id = $annee_scolaire_id
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

    public  function get_retard_paie_scolarite($mois_encours = NULL,  $jour_delai = 5)
    {
          $tab_eleve_id = array();
          $mois_encours = NULL;
          if(isset($mois_encours)){
            $mois_encours = strtolower($mois_encours) ;
            $mois_encours = ucfirst($mois_encours) ;  
          }    
          $eleve_retard = 'NULL';
          $tab_eleve_ids = DBTable::getModel('eleve')
        ->select(['id'=>'eleve_id',])
        ->get();

        foreach ($tab_eleve_ids as $tab_eleve_id1)
        array_push($tab_eleve_id, $tab_eleve_id1['eleve_id']);
        
        $tab_eleve_retard = array();
        if(!isset($mois_encours)) { 
          $mois_encours = self::mois_en_lettre(date("m")) ;   
          }

        
        foreach($tab_eleve_id as $eleve_id ){
        
        
        $tranche_id_mois = DBTable::getModel('tranche_scolaire')
        ->select(['pension_eleve.tranche_scolaire_id'=>'tranche_scolaire_id',
                'tranche_scolaire.libelle'=>'mois' ])
        ->join('pension_eleve', 'tranche_scolaire.id', '=', 'pension_eleve.tranche_scolaire_id')
        ->join('type_pension', 'type_pension.id', '=', 'pension_eleve.type_pension_id')
        ->where('type_pension.libelle','=','Scolarité') 
        ->where('pension_eleve.visibilite', '=', 1)
        ->where('tranche_scolaire_id', '<>', 'NULL')
        ->where('pension_eleve.eleve_id', '=', $eleve_id)
        ->get(); 

        //dd($tranche_id_mois);
      //$tableau_valeur = array()

      $payer_retard = "true"; 
      $jour_int = (int) date("d");

      if ($jour_int >= $jour_delai) {

        foreach($tranche_id_mois as $tranche_id_moi){ 
      // $mois_deb=substr($pentions_facture_cant['date_debut'],5,2);
      
      
          if ($tranche_id_moi['mois'] == $mois_encours ){
              $payer_retard = "false"; 
              break ; }
     }
 
      if($payer_retard == "true") {

        $eleve_retards = DBTable::getModel('eleve')
        ->select([new Expression("concat( eleve.nom,' ',eleve.prenom) as nom_complet"),
                                'salle_classe.libelle' => 'salle_classe',])
          ->join('parcours', 'parcours.eleve_id', '=', 'eleve.id')
          ->join('salle_classe', 'salle_classe.id', '=', 'parcours.salle_classe_id')
          ->where('eleve.visibilite', '=', 1)
          ->where('salle_classe.libelle', '<>', 'NULL')
          ->where('eleve.id', '=', $eleve_id)
          ->get(); 

          foreach ($eleve_retards as $eleve_retard)
            array_push($tab_eleve_retard, $eleve_retard);     
        }
   
        }
       }
   
       return $tab_eleve_retard ;

    }
    public static function mois_en_lettre($mois)
    {
      if ($mois=='01') {
        return 'Janvier';
      }
      elseif ($mois=='02') {
        return 'Février';
      }
      elseif ($mois=='03') {
        return 'Mars';
      }
      elseif ($mois=='04') {
        return 'Avril';
      }
      elseif ($mois=='05') {
        return 'Mai';
      }
      elseif ($mois=='06') {
        return 'Juin';
      }
      elseif ($mois=='07') {
        return 'Juillet';
      }
      elseif ($mois=='08') {
        return 'Août';
      }
      elseif ($mois=='09') {
        return 'Septembre';
      }
      elseif ($mois=='10') {
        return 'Octobre';
      }
      elseif ($mois=='11') {
        return 'Novembre';
      }
      elseif ($mois=='12') {
        return 'Décembre';
      }
      else {
        return '';
      }
    }
    
}