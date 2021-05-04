<?php

namespace App\Repository;

use App\Model\DBTable;
use ClanCats\Hydrahon\Query\Expression;

use function Core\Helper\dd;
use function Core\Helper\vd;
use Core\Repository\BaseRepository;

class PersonnelRepository extends BaseRepository{
    
        
    public function getPersonnelGroupByTypePersonnel(){
        
        $type_personnels =  DBTable::getModel(DBTable::TYPE_PERSONNEL)->select(
        [   
            'id',
            'code',
            'libelle',
          
        ])
        ->where('visibilite', '=', 1)
        ->get();

        $results = [];            
        
        foreach($type_personnels as $type_personnel)    {
            $_data_type_personnel = [
                'type_personnel_id' => $type_personnel['code'],
                'type_personnel' => $type_personnel['libelle'],
            ];

            $tmp =  DBTable::getModel(DBTable::PERSONNEL)->select(
            [   
                'code' => 'personnel_id',
                'nom' => 'personnel_nom',
                'prenom' => 'personnel_prenom'
            ])
            ->where('visibilite', '=', 1)
            ->where('type_personnel_id', '=', $type_personnel['id'])
            ->get();

            $_data_type_personnel['personnels'] = $tmp??[];
           
            array_push($results, $_data_type_personnel);
            
        }
        
        return $results;
    }

    public function getInfoPersonnels($annee_scolaire_id, $type_personnel_id = false)
    {


        $model = DBTable::getModel(DBTable::PERSONNEL)
        ->select(
            [
                'personnel.code'=> 'id', 
                'personnel.telephone'=> 'telephone',
                // 'salle_classe.libelle'=> 'classe', 
                'type_personnel.libelle'=> 'fonction', 
                // 'salle_classe.code'=> 'salle_classe_id', 
                new Expression("concat(personnel.nom,' ',personnel.prenom) as nom_complet"),
                // 'type_personnel.code' => 'type_personnel_id',
                // 'type_personnel.libelle' => 'type_personnel',
                // 'pays.id' => 'pays_id', 
                // 'pays.libelle' => 'pays', 
                // 'personnel.sexe' => 'sexe', 
                // 'personnel.email' => 'email', 
                // 'personnel.adresse' => 'adresse', 
                // 'personnel.login' => 'login', 
                // 'personnel.date_prise_service' => 'date_prise_service', 
                // 'personnel.date_fin_carriere' => 'date_fin_carriere', 
                // 'personnel.bibliographie' => 'bibliographie', 
                // 'personnel.assurance' => 'assurance', 
                // 'personnel.fonction' => 'fonction', 
                // 'personnel.pieces_jointes' => 'pieces_jointes', 
                // 'personnel.photo' => 'photo' 
            ]
        )
        ->join('type_personnel', 'type_personnel.id', '=', 'personnel.type_personnel_id')
        ->join('salle_classe', 'salle_classe.id', '=', 'personnel.salle_classe_id')
        ->join('parcours', 'parcours.salle_classe_id', '=', 'salle_classe.id')
        ->join('pays', 'pays.id', '=', 'personnel.pays_id')
        ->where('personnel.visibilite', 1);
        
        if($type_personnel_id != false){
            $model = $model->where('personnel.type_personnel_id',  $type_personnel_id);
        }
        // ->where('parcours.visibilite', '=', 1)
        // ->where('parcours.annee_scolaire_id', '=', $annee_scolaire_id)
        $data = $model->get();
        // dd($data);
        return $data;
    }

    public function getInfoPersonnels_old($annee_scolaire_id)
    {
        $data = DBTable::getModel(DBTable::PERSONNEL)
        ->select(
            [
                'personnel.code'=> 'id', 
                'personnel.telephone'=> 'telephone',
                'salle_classe.libelle'=> 'classe', 
                'type_personnel.libelle'=> 'fonction', 
                'salle_classe.code'=> 'salle_classe_id', 
                new Expression("concat(personnel.nom,' ',personnel.prenom) as nom_complet"),
                'type_personnel.code' => 'type_personnel_id',
                'type_personnel.libelle' => 'type_personnel',
                'pays.id' => 'pays_id', 
                'pays.libelle' => 'pays', 
                'personnel.sexe' => 'sexe', 
                'personnel.email' => 'email', 
                'personnel.adresse' => 'adresse', 
                'personnel.login' => 'login', 
                'personnel.date_prise_service' => 'date_prise_service', 
                'personnel.date_fin_carriere' => 'date_fin_carriere', 
                'personnel.bibliographie' => 'bibliographie', 
                'personnel.assurance' => 'assurance', 
                'personnel.fonction' => 'fonction', 
                'personnel.pieces_jointes' => 'pieces_jointes', 
                'personnel.photo' => 'photo' 
            ]
        )
        ->join('type_personnel', 'type_personnel.id', '=', 'personnel.type_personnel_id')
        ->join('salle_classe', 'salle_classe.id', '=', 'personnel.salle_classe_id')
        ->join('parcours', 'parcours.salle_classe_id', '=', 'salle_classe.id')
        ->join('pays', 'pays.id', '=', 'personnel.pays_id')
        // ->where('parcours.visibilite', '=', 1)
        ->where('parcours.annee_scolaire_id', '=', $annee_scolaire_id)
        ->get();
        dd($data);
        return $data;
    }

    public function getInfoPersonnel($annee_scolaire_id, $code)
    {
        
        $data =DBTable::getModel(DBTable::PERSONNEL)
        ->select(
            [
                'personnel.code'=> 'id', 
                'personnel.telephone'=> 'telephone',
                'personnel.nom'=> 'nom',
                'personnel.prenom'=> 'prenom',
                'type_personnel.libelle'=> 'fonction', 
                new Expression("concat(personnel.nom,' ',personnel.prenom) as nom_complet"),
                'type_personnel.code' => 'type_personnel_id',
                'type_personnel.libelle' => 'type_personnel',
                'pays.id' => 'pays_id', 
                'pays.libelle' => 'pays', 
                'personnel.sexe' => 'sexe', 
                'personnel.email' => 'email', 
                'personnel.adresse' => 'adresse', 
                'personnel.login' => 'login', 
                'personnel.date_prise_service' => 'date_prise_service', 
                'personnel.date_fin_carriere' => 'date_fin_carriere', 
                'personnel.bibliographie' => 'bibliographie', 
                'personnel.assurance' => 'assurance', 
                'personnel.fonction' => 'fonction', 
                'personnel.pieces_jointes' => 'pieces_jointes', 
                'personnel.photo' => 'photo',
            ]
        )
        ->join('type_personnel', 'type_personnel.id', '=', 'personnel.type_personnel_id')
        ->join('pays', 'pays.id', '=', 'personnel.pays_id')
        ->where('personnel.visibilite', '=', 1)
        ->where('personnel.code', '=', $code)
        ->one()??[];
        
        $personnel_id = $data['id'];
        $affectation = DBTable::getModel(DBTable::AFFECTATION_PERSONNEL_SALLE_CLASSE)
        ->select(
            [
                // 'affectation_personnel_salle_classe.annee_scolaire_id' => 'annee_scolaire_id', 
                // 'affectation_personnel_salle_classe.libelle' => 'annee_scolaire', 
                'salle_classe.libelle' => 'salle_classe', 
                'salle_classe.code' => 'salle_classe_id', 
            ]
        )
        ->join('salle_classe', 'salle_classe.id', '=', 'affectation_personnel_salle_classe.salle_classe_id')
        // ->join('annee_scolaire', 'annee_scolaire.id', '=', 'affectation_personnel_salle_classe.annee_scolaire_id')
        ->where('affectation_personnel_salle_classe.annee_scolaire_id', '=', $annee_scolaire_id)
        ->where('affectation_personnel_salle_classe.personnel_id', '=', $personnel_id)
        ->get();
        $affectation = ($affectation == []) ? null : $affectation;
        $data['salle_classe'] = $affectation ??"Non affecté";
        $data['salle_classe_id'] = $affectation ??null;
        
        return $data;
    }

    

}