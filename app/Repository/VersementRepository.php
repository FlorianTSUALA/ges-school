<?php

namespace App\Repository;

use App\Model\DBTable;
use ClanCats\Hydrahon\Query\Expression;

use function Core\Helper\dd;
use function Core\Helper\vd;
use Core\Repository\BaseRepository;

class VersementRepository extends BaseRepository{
    
      
    public function getInfoEleveScolarite($eleve_code, $annee_scolaire_id){
        $req =
            "                
            SELECT  pension_eleve.montant, facture.date_facture, pension_eleve.reduction, tranche_scolaire.libelle
            FROM facture
            LEFT  JOIN  pension_eleve  ON facture.id = pension_eleve.facture_id
            LEFT  JOIN  tranche_scolaire ON tranche_scolaire.id = pension_eleve.tranche_scolaire_id
            LEFT  JOIN  type_pension ON type_pension.id = pension_eleve.type_pension_id
            WHERE pension_eleve.eleve_id = $eleve_code  AND facture.annee_scolaire_id = $annee_scolaire_id
             AND facture.visibilite = 1  AND type_pension.code = 'SCOLARITE'
            ORDER BY facture.date_facture
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

 

    public function getInfoEleveCantine($eleve_id, $annee_scolaire_id){
        $req =
            "                
            SELECT abonnement_cantine.eleve_id, abonnement_detail.total, abonnement_detail.periode, abonnement_detail.multiplicateur, abonnement_detail.prix_unitaire, abonnement_detail.date_debut, abonnement_detail.date_fin
            FROM abonnement_cantine
            INNER JOIN  facture ON facture.id = abonnement_cantine.facture_id
            INNER JOIN  abonnement_detail ON abonnement_cantine.id = abonnement_detail.abonnement_id
            WHERE facture.visibilite = 1   AND abonnement_detail.type_abonnement = 'CANTINE'  AND abonnement_cantine.eleve_id = $eleve_id  AND facture.annee_scolaire_id = $annee_scolaire_id
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

    public function getInfoEleveactivite($eleve_id, $annee_scolaire_id){
        $req =
            "                
            SELECT abonnement_activite.eleve_id, abonnement_detail.total, abonnement_detail.periode, abonnement_detail.multiplicateur, abonnement_detail.prix_unitaire, abonnement_detail.date_debut, abonnement_detail.date_fin, activite.libelle 
            FROM abonnement_activite 
            INNER JOIN  facture ON facture.id = abonnement_activite.facture_id
            INNER JOIN  abonnement_detail ON abonnement_activite.id = abonnement_detail.abonnement_id
            INNER JOIN  activite ON activite.id = abonnement_activite.activite_id
            WHERE facture.visibilite = 1   AND abonnement_detail.type_abonnement = 'ACTIVITE'  AND abonnement_activite.eleve_id = $eleve_id  AND facture.annee_scolaire_id = $annee_scolaire_id
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

    
}