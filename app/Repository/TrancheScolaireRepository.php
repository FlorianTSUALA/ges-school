<?php

namespace App\Repository;

use App\Model\Exemplaire;
use Core\Repository\BaseRepository;

use function Core\Helper\dd;

class TrancheScolaireRepository extends BaseRepository{
    
    //regler cette requete
    public function getAllTrancheScolaires($annee_scolaire_id = null)
    {
        $req = "
            select
            group_concat(tr.libelle SEPARATOR ', ') as description, tranche_scolaire.id,           
            annee_scolaire.libelle as annee_scolaire_id, type_tranche_scolaire.libelle as type_tranche_scolaire_id, 
                tranche_scolaire.code as code, tranche_scolaire.libelle as libelle
            from 
            (
            select mois.libelle as libelle, tranche_scolaire_mois.tranche_scolaire_id as id 
                from tranche_scolaire_mois left join mois on tranche_scolaire_mois.mois_id = mois.id    
            ) tr, 
            tranche_scolaire
            left join annee_scolaire on annee_scolaire.id = tranche_scolaire.annee_scolaire_id
            left join type_tranche_scolaire on type_tranche_scolaire.id = tranche_scolaire.type_tranche_scolaire_id 
            where tr.id = tranche_scolaire.id and tranche_scolaire.visibilite = 1 and tranche_scolaire.annee_scolaire_id = $annee_scolaire_id
            group by tranche_scolaire.id
        ";
        $result = $this->query($req);
        return $result;
    }
    //regler cette requete
    public function getTrancheScolaire($annee_scolaire_id = null, $code)
    {
        $req = "
            select
            group_concat(tr.libelle SEPARATOR ', ') as description, group_concat(tr.code SEPARATOR ', ') as description_code,
            tranche_scolaire.id,           
            annee_scolaire.libelle as annee_scolaire_id, type_tranche_scolaire.id as type_tranche_scolaire_id,
            type_tranche_scolaire.libelle as type_tranche_scolaire_libelle, 
                tranche_scolaire.code as code, tranche_scolaire.libelle as libelle
            from 
            (
            select mois.libelle as libelle, mois.code as code, tranche_scolaire_mois.tranche_scolaire_id as id 
                from tranche_scolaire_mois left join mois on tranche_scolaire_mois.mois_id = mois.id    
            ) tr, 
            tranche_scolaire
            left join annee_scolaire on annee_scolaire.id = tranche_scolaire.annee_scolaire_id
            left join type_tranche_scolaire on type_tranche_scolaire.id = tranche_scolaire.type_tranche_scolaire_id 
            where tr.id = tranche_scolaire.id and tranche_scolaire.visibilite = 1 and tranche_scolaire.annee_scolaire_id = $annee_scolaire_id  and tranche_scolaire.code = '$code'
            group by tranche_scolaire.id
        ";
        $result = (array)$this->query($req)[0];
        return $result;
    }
}