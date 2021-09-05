<?php

namespace App\Controller;

use App\Helpers\S;
use App\Model\DBTable;
use App\Helpers\Helpers;
use Config\Invariant\API;
use Core\Session\Request;
use App\Model\Technique\E;
use App\Model\PensionClasse;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;

use function Core\Helper\dd;

class PensionClasseController extends AppController
{
    use TraitCRUDController;
    
    public function __construct()
    {
        parent::__construct();

        $this->vairant = DBTable::PENSION_CLASSE;
        $this->folder_view_index = 'pension_classe.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'pension_classe';
        $this->class_name = 'pension_classe';

        $this->title_page = 'Gestion des pension des classes - Ges-School';
        $this->title_home = 'Gestion des pension des classes';
        $this->create_title = "Creation d'une pension de la classe";
        $this->view_title = "Information d'une pension de la classe";
        $this->update_title = "Mise à jour d'une pension de la classe";
        $this->delete_title = "Suppression d'une pension de la classe";
        $this->msg_delete = "Voulez-vous vraiment supprimer la pension de la classe ";
    }
        
    public function index()
    {
        $route = 'pension_classe';
        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
     
        $this->checkAndResolveInexistence($annee_scolaire_id);
        
        $classes =  Helpers::toJSON(DBTable::getModel(DBTable::CLASSE)->select([ 'id',  'code', 'libelle' => 'value']) ->where('visibilite', '=', 1) ->get());
        $types_pensions = Helpers::toJSON(DBTable::getModel('type_pension')->select(['id', 'code', 'paiement_en_tranche', 'libelle' => 'value'])->where('visibilite', '=', 1)->get());
        $tranches_scolaires = Helpers::toJSON(DBTable::getModel('tranche_scolaire')->select(['id', 'libelle' => 'value'])->where('visibilite', '=', 1)->get());
        // $tranches_scolaires =  Helpers::toJSON((new TrancheScolaireRepository() )->getTrancheScolairesJQGRID($annee_scolaire_id));

        $prix_pensions_classes = PensionClasse::table()->select(
            [
                'type_pension.id' => 'type_pension',
                'classe.id' => 'classe',
                'tranche_scolaire.id' => 'tranche_scolaire',
                'pension_classe.montant' => 'montant'
            ])
            ->where('pension_classe.visibilite', 1)
            ->where('pension_classe.annee_scolaire_id', $annee_scolaire_id)
            ->where('tranche_scolaire.annee_scolaire_id', $annee_scolaire_id)
            ->join('type_pension', 'pension_classe.type_pension_id', '=', 'type_pension.id')
            ->join('tranche_scolaire', 'pension_classe.tranche_scolaire_id', '=', 'tranche_scolaire.id')
            ->join('classe', 'pension_classe.classe_id', '=', 'classe.id')
            ->get();
 
        $prix_pensions_classes = Helpers::toJSON($prix_pensions_classes);
        $this->render('sections.pension_classe.index', compact('route', 'classes', 'types_pensions', 'prix_pensions_classes', 'tranches_scolaires'));
    }

    /**
     * pour une année scolaire donnné
     *
     * @param string $annee_scolaire_code
     * @return boolean
     */
    private function checkAndResolveInexistence($annee_scolaire_id)
    {
        //verification incomplete, doit se faire pour toutes les salles de classe
        //Il peut survenir que l'on cree ou modifie une salle de classe
        $types_pensions = (DBTable::getModel('type_pension')->select(['id', 'paiement_en_tranche'])->where('visibilite', '=', 1)->get());
        $classes = (DBTable::getModel('classe')->select(['id'])->where('visibilite', '=', 1)->get());
        $tranches_scolaires = (DBTable::getModel('tranche_scolaire')->select(['id'])->where('annee_scolaire_id', '=', $annee_scolaire_id)->where('visibilite', '=', 1)->get());

        foreach ($types_pensions as $type_pension)
        {
            $model = PensionClasse::table();
            $is_exists = true;

            if($type_pension['paiement_en_tranche'] == E::OUI){
                foreach ($tranches_scolaires as $tranche_scolaire){
                    foreach ($classes as $classe){
                        $is_exists = $model->select()
                            ->where('classe_id', '=', $classe['id'])
                            ->where('tranche_scolaire_id', $tranche_scolaire['id'])
                            ->where('type_pension_id', $type_pension['id'])
                            ->where('annee_scolaire_id', $annee_scolaire_id)
                            // ->where('visibilite', '=', 1)
                            ->exists();
                        
                        if(!$is_exists){
                            $data = [
                                    'annee_scolaire_id' => $annee_scolaire_id, 
                                    'classe_id' => $classe['id'], 
                                    'tranche_scolaire_id' => $tranche_scolaire['id'], 
                                    'type_pension_id' => $type_pension['id'], 
                                    'code' =>  PensionClasse::generateCode()
                            ];
                            PensionClasse::table()->insert($data)->execute();
                        }
                    }
                }
            }else{
                foreach ($classes as $classe){
                    $is_exists = $model->select()
                        ->where('classe_id', '=', $classe['id'])
                        ->where('type_pension_id', $type_pension['id'])
                        ->where('annee_scolaire_id', $annee_scolaire_id)
                        ->whereNull('tranche_scolaire_id')
                        ->exists();
                    
                    if(!$is_exists){
                        $data = 
                        [
                            'annee_scolaire_id' => $annee_scolaire_id, 
                            'classe_id' => $classe['id'], 
                            'type_pension_id' => $type_pension['id'], 
                            'code' =>  PensionClasse::generateCode()
                        ];
                        PensionClasse::table()->insert($data)->execute();
                    }
                }

            }

        }
    }
        
    public function modifier()
    {
        
        $tranche_scolaire_id  = Request::getSecParam('tranche_scolaire_id', NULL);
        $type_pension_id  = Request::getSecParam('type_pension_id', NULL);
        $classe_id  = Request::getSecParam('classe_id', NULL);
        $montant  = Request::getSecParam('montant', NULL);

        $montant = ($montant === NULL) ? 0 : $montant;

        $data = [
            'tranche_scolaire_id'  => $tranche_scolaire_id, 
            'type_pension_id'  => $type_pension_id, 
            'classe_id'  => $classe_id, 
            'montant'  => $montant, 
        ];

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        {
            $model = PensionClasse::table()
            ->update($data)
            ->where('type_pension_id', $type_pension_id)
            ->where('classe_id', $classe_id)
            ->where('annee_scolaire_id', $annee_scolaire_id);

            if(!is_null($tranche_scolaire_id))
                $model = $model->where('tranche_scolaire_id', $tranche_scolaire_id);

            $model->execute();

            $data[API::TAG_REPORT] = true;
            $data[API::TAG_DATA] = 'Enregistrée avec success';
            
        }

        $this->sendResponseAndExit(Helpers::toJSON($data, TRUE));
        
    }
        
    public function liste()
    {
        $classe_id = Request::getSecParam('classe', NULL);
        $type_pension_id = Request::getSecParam('type_pension', NULL);

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante

        $model = PensionClasse::table()->select(
            [
                'pension_classe.type_pension_id' => 'type_pension',
                'pension_classe.classe_id' => 'classe',
                'pension_classe.tranche_scolaire_id' => 'tranche_scolaire',
                'pension_classe.montant' => 'montant'
            ])
            ->join('type_pension', 'pension_classe.type_pension_id', '=', 'type_pension.id')
            ->join('tranche_scolaire', 'pension_classe.tranche_scolaire_id', '=', 'tranche_scolaire.id')
            ->where('pension_classe.visibilite', 1)
           ->where(
                function($q) 
                {
                    $q->where(function($q) 
                    {
                        $q->where('tranche_scolaire.annee_scolaire_id', $this->session->get(S::ANNEE_SCOLAIRE));
                        $q->orWhere('type_pension.paiement_en_tranche', E::NON);
                    });
                }
            )
            ->where('pension_classe.annee_scolaire_id', $annee_scolaire_id);
        
        if(!is_null($classe_id))       
            $model = $model->where('pension_classe.classe_id', $classe_id);

        if(!is_null($type_pension_id))       
            $model = $model->where('pension_classe.type_pension_id', $type_pension_id);

        $data = ($model->get());
        $this->sendResponseAndExit(Helpers::toJSON($data), true);
    }

}
