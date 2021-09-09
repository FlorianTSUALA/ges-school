<?php

namespace App\Controller;
    
use App\Model\Cycle;
use App\Model\Eleve;
use App\Model\DBTable;
use App\Model\Parcours;
use Core\Session\Request;
use App\Model\StatutEleve;
use App\Helpers\TraitCRUDController;
use App\Controller\Admin\AppController;
use App\Repository\AnneeScolaireRepository;

class StatutEleveController extends AppController 
{
    use TraitCRUDController;

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('statut_eleve');

        $this->vairant = DBTable::STATUT_ELEVE;
        $this->folder_view_index = 'statut_eleve.index';

        $this->loadModel($this->vairant);
        $this->base_route = 'statut_eleve';
        $this->class_name = 'statut_eleve';

        $this->title_page = 'Gestion des statuts eleves - Ges-School';
        $this->title_home = 'Gestion des statuts eleves';
        $this->create_title = "Creation d'un statut eleve";
        $this->view_title = "Information d'un statut eleve";
        $this->update_title = "Mise à jour d'un statut eleve";
        $this->delete_title = "Suppression d'un statut eleve";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce statut eleve ";
    }
    
    public function actualiser_statut($annee_scolaire_id){

        $eleves = Eleve::table()->select(
                                            [
                                                'eleve.id' => 'id',
                                                'eleve.statut_eleve_id' => 'statut_eleve_id',
                                            ]
                                        )
                                ->where('eleve.visibilite', 1)
                                ->get();
        
        foreach ($eleves as $eleve) 
            $this->actualiser_statut_eleve($eleve, $annee_scolaire_id);
        
    } 
    
    /**
     * actualise le statut de l'élève (ancien, nouveau, démissionnaire, fin de cycle) au cours d'une année scolaire donnée
     *
     * @param [staut_eleve_id, eleve_id] $eleve
     * @param [type] $annee_scolaire_id
     * @return void
     */
    public function actualiser_statut_eleve($eleve, $annee_scolaire_id){

        $precedente_annee_scolaire_id = (new AnneeScolaireRepository)->get_annee_scolaire_precedente_id($annee_scolaire_id);

        if(is_null($eleve['statut_eleve_id'])){
            Eleve::table()->update()->set(['statut_eleve_id', StatutEleve::get_id(StatutEleve::NOUVEAU_CODE)])->where('eleve_id', '=', $eleve['id'])->where('visibilite', 1)->execute();
        }
        $statut_eleve_code = StatutEleve::table()->select('code')->where('eleve.statut_eleve_id', $eleve['statut_eleve_id'])->one()['code'];
        
        if((!$statut_eleve_code) || (!$precedente_annee_scolaire_id && $statut_eleve_code != StatutEleve::NOUVEAU_CODE))
        {
            Eleve::table()->update()->set(['statut_eleve_id', StatutEleve::get_id(StatutEleve::NOUVEAU_CODE)])->where('eleve_id', '=', $eleve['id'])->where('visibilite', 1)->execute();
            $eleve = Eleve::table()->select(
                                                [
                                                    'eleve.id' => 'id',
                                                    'eleve.statut_eleve_id' => 'statut_eleve_id',
                                                ]
                                            )
                                    ->where('eleve.visibilite', 1)
                                    ->where('eleve.id', $eleve['id'])
                                    ->one();
        }
      
        $parcours = Parcours::table()->select
                                            (
                                                [
                                                    'classe.libelle' => 'classe',           
                                                    'classe.id' => 'classe_id',           
                                                    'statut_eleve.id' => 'statut_eleve_id',
                                                    'statut_eleve.libelle' => 'statut_eleve',
                                                    'parcours.annee_scolaire_id' => 'annee_scolaire_id',
                                                    'annee_scolaire.libelle' => 'annee_scolaire',
                                                ]
                                            )
                                            ->where('parcours.visibilite', 1)
                                            ->where('parcours.eleve_id', $eleve['id'])
                                            ->where('parcours.annee_scolaire_id', $precedente_annee_scolaire_id)
                                            ->one();
        $parcours_exists = !!$parcours; 

        switch($statut_eleve_code){
            case StatutEleve::NOUVEAU_CODE:
                if($parcours_exists){
                    Eleve::table()->update()->set(['statut_eleve_id', StatutEleve::get_id(StatutEleve::ANCIEN_CODE)])->where('eleve_id', '=', $eleve['id'])->where('visibilite', 1)->execute();
                }
            break;
            
            case StatutEleve::ANCIEN_CODE:
                if(!$parcours_exists){
                    Eleve::table()->update()->set(['statut_eleve_id', StatutEleve::get_id(StatutEleve::DEMISSINAIRE_CODE)])->where('eleve_id', '=', $eleve['id'])->where('visibilite', 1)->execute();
                }else{
                    $fin_cycle = Cycle::table()->select()->where('classe_fin_cycle', $parcours['classe_id'])->where('visibilite', 1)->exists();
                    if($fin_cycle){
                        Eleve::table()->update()->set(['statut_eleve_id', StatutEleve::get_id(StatutEleve::FIN_CYCLE_CODE)])->where('eleve_id', '=', $eleve['id'])->where('visibilite', 1)->execute();
                    }
                }
            break;
            case StatutEleve::DEMISSINAIRE_CODE:
                //MISE A JOUR DU STATUT DURANT L'INSCRIPTION #STATUT_ELEVE#
            break;
            case StatutEleve::FIN_CYCLE_CODE:
                //AUCUN CHANGEMENT D'ETAT
            break;

        }
    
    } 

}