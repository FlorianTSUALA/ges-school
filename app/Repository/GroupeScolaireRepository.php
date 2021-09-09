<?php

namespace App\Repository;

use App\Model\Exemplaire;
use Core\Repository\BaseRepository;

use function Core\Helper\dd;

class GroupeScolaireRepository extends BaseRepository{
    
    //regler cette requete
    public function getAllTrancheScolaires($annee_scolaire_id = null)
    {
        $req = "SELECT  GROUP_CONCAT(tr.libelle SEPARATOR ', ') AS description, 
                        tranche_scolaire.id,           
                        annee_scolaire.libelle AS annee_scolaire_id, 
                        type_tranche_scolaire.libelle AS type_tranche_scolaire_id, 
                        tranche_scolaire.date_limite_paiement AS date_limite_paiement, 
                        tranche_scolaire.code AS code, tranche_scolaire.libelle AS libelle
                FROM 
                tranche_scolaire 
                LEFT  JOIN  annee_scolaire ON annee_scolaire.id = tranche_scolaire.annee_scolaire_id
                LEFT  JOIN  type_tranche_scolaire ON type_tranche_scolaire.id = tranche_scolaire.type_tranche_scolaire_id
                LEFT JOIN (
                    SELECT mois.libelle AS libelle, tranche_scolaire_mois.tranche_scolaire_id AS id 
                    FROM tranche_scolaire_mois 
                    LEFT  JOIN  mois ON tranche_scolaire_mois.mois_id = mois.id    
                ) AS tr ON tr.id = tranche_scolaire.id
                WHERE 
                        tranche_scolaire.visibilite = 1  AND 
                        tranche_scolaire.annee_scolaire_id = $annee_scolaire_id
                GROUP  BY tranche_scolaire.id
        ";
        $result = $this->query($req);
        return $result;
    }
 
    //regler cette requete
    public function getTrancheScolaire($annee_scolaire_id = null, $code)
    {
        $req = " SELECT GROUP_CONCAT(tr.libelle SEPARATOR ', ') AS description, 
                        GROUP_CONCAT(tr.code SEPARATOR ', ') AS description_code,
                        tranche_scolaire.id,           
                        annee_scolaire.libelle AS annee_scolaire_id, 
                        type_tranche_scolaire.id AS type_tranche_scolaire_id,
                        type_tranche_scolaire.libelle AS type_tranche_scolaire_libelle, 
                        tranche_scolaire.date_limite_paiement AS date_limite_paiement, 
                        tranche_scolaire.code AS code, tranche_scolaire.libelle AS libelle
                FROM 
                 
                tranche_scolaire
                LEFT  JOIN  annee_scolaire ON annee_scolaire.id = tranche_scolaire.annee_scolaire_id
                LEFT  JOIN  type_tranche_scolaire ON type_tranche_scolaire.id = tranche_scolaire.type_tranche_scolaire_id 
                LEFT JOIN (
                    SELECT mois.libelle AS libelle, mois.code AS code, tranche_scolaire_mois.tranche_scolaire_id AS id 
                    FROM tranche_scolaire_mois LEFT  JOIN  mois ON tranche_scolaire_mois.mois_id = mois.id    
                ) as tr ON  tr.id = tranche_scolaire.id
                WHERE
                        tranche_scolaire.visibilite = 1  AND 
                        tranche_scolaire.annee_scolaire_id = $annee_scolaire_id AND 
                        tranche_scolaire.code = '$code'
                GROUP  BY tranche_scolaire.id
        ";
        $result = (array)$this->query($req)[0];
        return $result;
    }


}