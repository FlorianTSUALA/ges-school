<?php

namespace App\Repository;

use App\Model\Exemplaire;
use Core\Repository\BaseRepository;

use function Core\Helper\dd;

class ExemplaireRepository extends BaseRepository{
    
    public function getAll()
    {
        return Exemplaire::table()->select('
                document.titre as document_id, 
                document.code as external_target,
                etat_document.libelle as etat_document_id, 
                etat_document.code as external_target1,
                exemplaire.code as code, 
                exemplaire.code_enregistrement as code_enregistrement, 
                exemplaire.date_acquisition as date_acquisition,
                exemplaire.statut as statut
                ')
        ->where('exemplaire.visibilite','=', 1)
        ->join('document', 'exemplaire.document_id', '=', 'document.id')
        ->join('etat_document', 'exemplaire.etat_document_id', '=', 'etat_document.id')
        ->get();
    }

    public function getAllEmprunt()
    {
        $req =
        "
        select  (@row_number := @row_number + 1) as num,
                emprunt.date_emprunt,
                emprunt.date_expiration,
                emprunt.code as id,
                etat_document.libelle as etat_document,
                document.titre,
                exemplaire.code_enregistrement,
                  salle.classe,
                salle.eleve,
                emprunt.eleve_id
        from (SELECT @row_number:=0) AS t, emprunt
        left join etat_document on etat_document.id = emprunt.etat_document_id
        left join exemplaire on exemplaire.id = emprunt.exemplaire_id
        left join document on document.id = exemplaire.document_id
        left join   (   SELECT  parcours.eleve_id AS eleve_id,
                                concat(eleve.nom, ' ', eleve.prenom) AS eleve,
                                salle_classe.libelle AS classe
                        FROM parcours
                        LEFT JOIN salle_classe ON salle_classe.id = parcours.salle_classe_id
                        LEFT JOIN eleve ON eleve.id = parcours.eleve_id
                    ) salle ON salle.eleve_id = emprunt.eleve_id;
        ";

     
        $result = $this->query($req);
        return $this->toObject($result);
    }
}