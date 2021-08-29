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
            select  facture.montant, facture.date_facture, facture.reduction, tranche_scolaire.libelle
            from facture
            left join pension_eleve  on facture.id = pension_eleve.facture_id
            left join tranche_scolaire on tranche_scolaire.id = pension_eleve.tranche_scolaire_id
            left join type_pension on type_pension.id = pension_eleve.type_pension_id
            where pension_eleve.eleve_id = $eleve_code and facture.annee_scolaire_id = $annee_scolaire_id
            and facture.visibilite = 1 and type_pension.code = 'SCOLARITE'
            order by tranche_scolaire.libelle
        ";
        $result = $this->query($req);
        return $this->toObject($result);
    }
    

}