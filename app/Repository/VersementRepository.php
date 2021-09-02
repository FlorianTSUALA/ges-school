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
            select  pension_eleve.montant, facture.date_facture, pension_eleve.reduction, tranche_scolaire.libelle
            from facture
            left join pension_eleve  on facture.id = pension_eleve.facture_id
            left join tranche_scolaire on tranche_scolaire.id = pension_eleve.tranche_scolaire_id
            left join type_pension on type_pension.id = pension_eleve.type_pension_id
            where pension_eleve.eleve_id = $eleve_code and facture.annee_scolaire_id = $annee_scolaire_id
            and facture.visibilite = 1 and type_pension.code = 'SCOLARITE'
            order by facture.date_facture
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

 

    public function getInfoEleveCantine($eleve_id, $annee_scolaire_id){
        $req =
            "                
            SELECT abonnement_cantine.eleve_id, abonnement_detail.total, abonnement_detail.periode, abonnement_detail.multiplicateur, abonnement_detail.prix_unitaire, abonnement_detail.date_debut, abonnement_detail.date_fin
            from abonnement_cantine
            INNER JOIN facture on facture.id = abonnement_cantine.facture_id
            INNER JOIN abonnement_detail on abonnement_cantine.id = abonnement_detail.abonnement_id
            where facture.visibilite = 1  and abonnement_detail.type_abonnement = 'CANTINE' and abonnement_cantine.eleve_id = $eleve_id and facture.annee_scolaire_id = $annee_scolaire_id
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

    public function getInfoEleveactivite($eleve_id, $annee_scolaire_id){
        $req =
            "                
            SELECT abonnement_activite.eleve_id, abonnement_detail.total, abonnement_detail.periode, abonnement_detail.multiplicateur, abonnement_detail.prix_unitaire, abonnement_detail.date_debut, abonnement_detail.date_fin, activite.libelle 
            from abonnement_activite 
            INNER JOIN facture on facture.id = abonnement_activite.facture_id
            INNER JOIN abonnement_detail on abonnement_activite.id = abonnement_detail.abonnement_id
            INNER JOIN activite on activite.id = abonnement_activite.activite_id
            where facture.visibilite = 1  and abonnement_detail.type_abonnement = 'ACTIVITE' and abonnement_activite.eleve_id = $eleve_id and facture.annee_scolaire_id = $annee_scolaire_id
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }

    
}