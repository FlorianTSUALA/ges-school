<?php

namespace App\Repository;

use App\Model\DBTable;
use App\Model\EnumModel;
use App\Model\EnumStatutDocument;
use App\Model\Exemplaire;
use App\Model\EtatDocument;
use Core\Repository\BaseRepository;

use function Core\Helper\dd;

class DocumentRepository extends BaseRepository{
    
        
    public function getDocument(){
        
        $documents =  DBTable::getModel(DBTable::DOCUMENT)->select(
        [   
            'code' => 'document_id',
            'titre' => 'document',
        ])
        ->where('visibilite', '=', 1)
        ->get();
        
        return $documents;
    }
        
    public function getExemplaire($disponible = false){
        
        $table = Exemplaire::table();
        $request = $table->select('
            document.titre as document, 
            document.code as document_id, 
            etat_document.code as etat_document_id, 
            etat_document.libelle as etat_document, 
            exemplaire.code as exemplaire_id, 
            exemplaire.code_enregistrement as code_enregistrement, 
            exemplaire.date_acquisition as date_acquisition
            ')->where('exemplaire.visibilite','=', 1);

        if($disponible)
            $request = $request->where('exemplaire.statut','=', EnumModel::STATUT_DOCUMENT_DISPONIBLE );

        $results = $request
            ->join('document', 'exemplaire.document_id', '=', 'document.id')
            ->join('etat_document', 'exemplaire.etat_document_id', '=', 'etat_document.id')
            ->get();
        return $results;
    }
        
    public function getEtatDocument(){
        $results = EtatDocument::table()->select('
                etat_document.code as etat_document_id, 
                etat_document.libelle as etat_document 
                ')
                ->where('etat_document.visibilite', 1)
                ->get();
    
        return $results;
    }
        
    public function getDocumentGroupByDomaine(){
        
        $domaines =  DBTable::getModel(DBTable::DOMAINE)->select(
        [   
            'id',
            'code',
            'libelle'
        ])
        ->where('visibilite', '=', 1)
        ->get();

        $documents = [];            
        
        foreach($domaines as $domaine){
            $data_domaine = [
                'domaine_id' => $domaine['code'],
                'domaine' => $domaine['libelle'],
            ];

            $_documents =  DBTable::getModel(DBTable::DOCUMENT)->select(
            [   
                'code' => 'document_id',
                'titre' => 'document'
            ])
            ->where('visibilite', '=', 1)
            ->where('domaine_id', '=', $domaine['id'])
            ->get();

            $data_domaine['documents'] = $_documents??[];
           
            array_push($documents, $data_domaine);
            
        }
        
        return $documents;
    }


}