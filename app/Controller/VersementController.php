<?php

namespace App\Controller;

use App\Helpers\S;
use Core\Routing\URL;
use App\Model\DBTable;
use App\Helpers\Helpers;
use Config\Invariant\API;
use Core\Session\Request;
use App\Model\TypePension;
use function Core\Helper\dd;
use function Core\Helper\vd;
use App\Model\AbonnementActivite;
use App\Repository\EleveRepository;
use App\Repository\AnneeScolaireRepository;
use ClanCats\Hydrahon\Query\Expression as Ex;

class VersementController extends \App\Controller\Admin\AppController
{
    use VersementControllerTraitInscription, VersementControllerTraitScolarite, VersementControllerTraitMultiple;

    public function __construct()
    {
        parent::__construct();

        // $this->vairant = DBTable::versement;
        // $this->folder_view_index = 'versement.index';

        // $this->loadModel($this->vairant);
        $this->base_route = 'versement';
        // $this->class_name = 'pension_eleve';

        $this->title_page = 'Gestion des versements - Ges-School';
        $this->title_home = 'Gestion des versements';
        $this->create_title = "Creation d'un versement";
        $this->view_title = "Information d'un versement";
        $this->update_title = "Mise à jour d'un versement";
        $this->delete_title = "Suppression d'un versement";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce versement ";
    }

    /*
    *  **   * Renvoie le formulaire de versement
    */
    public function v_modification($id_fact)
    {
      $route = "versement";
      $title = "Gestion des frais scolaires";
      $this->app->setTitle($this->title_page);
      // $fillables = $this->{$this->vairant}->fillables;
      // $class_name = $this->class_name;
      $base_route = $this->base_route;
      $create_title = $this->create_title;
      $view_title = $this->view_title;
      $update_title = $this->update_title;
      $delete_title = $this->delete_title;
      $msg_delete = $this->msg_delete;

      $eleves = (new EleveRepository() )->getEleve();

      $classes = DBTable::getModel('classe')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();

      //Liste des prix associés aux offres de la cantine
      //$abonnement_cantine = DBTable::getModel('abonnement_cantine')->select(['code'=>'id', 'libelle' => 'libelle', 'montant'=>'montant'])->where('code', '=', 'MOIS')->where('visibilite', '=', 1)->one();
      // var_dump($abonnement_cantine); die();
      $annee_scolaires =  (new AnneeScolaireRepository())->getAll();



      $statut_apprenants = DBTable::getModel('statut_apprenant')
                          ->select(['code'=>'id', 'libelle' => 'libelle'])
                          ->where('visibilite', '=', 1)
                          ->orderBy('date_creation', 'desc')
                          ->get();

      $pension_classe = DBTable::getModel('pension_classe')
          ->select(
              [
                  'classe.code' => 'classe',
                  'type_pension.code' => 'type_pension',
                  'pension_classe.code' => 'id',
                  'pension_classe.montant' => 'montant',
                //   'pension_classe.est_mensuel' => 'est_mensuel',
                //   'pension_classe.mensualite' => 'mensualite',
                  'pension_classe.libelle' => 'libelle'
              ]
          )
          ->join('classe', 'classe.id', '=', 'pension_classe.classe_id')
          ->join('type_pension', 'type_pension.id', '=', 'pension_classe.type_pension_id')
          ->where('pension_classe.visibilite', '=', 1)
          ->get();

      $pension_classe = json_encode($pension_classe);

      $salle_classes = DBTable::getModel('salle_classe')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();
      $type_paiements = DBTable::getModel('type_paiement')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();

      $type_pensions = DBTable::getModel('type_pension')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();
      $activites = DBTable::getModel('activite')->select(['code'=>'id', 'libelle' => 'libelle', 'montant' => 'montant'])->where('visibilite', '=', 1)->get();

      $prix_abonnement_cantine = DBTable::getModel('prix_abonnement')
                          ->select('prix_abonnement.montant')
                          ->where('visibilite', '=', 1)
                          ->where('periode', '=', 'MOIS')
                          ->where('type_abonnement', '=', 'CANTINE')
                          //->where('type_abonnement_id', '=', 0)
                          ->one()['montant'];

      $prix_abonnement_activite = DBTable::getModel('prix_abonnement')
                          ->select(
                              [
                                  'prix_abonnement.code' => 'id',
                                  'prix_abonnement.montant' => 'montant',
                                  'prix_abonnement.periode' => 'periode',
                                  'prix_abonnement.description' => 'description'
                              ]
                          )
                          ->where('visibilite', '=', 1)
                          ->where('type_abonnement', '=', 'ACTIVITE')
                          //->where('type_abonnement_id', '=', 0)
                          ->get();

      // Tranche de l'annee scolaire en cours
      $tranche_scolaires = DBTable::getModel('tranche_scolaire')
      ->select(['code'=>'id', 'libelle' => 'libelle'])
      // ->join()
      ->where('visibilite', '=', 1)
      // ->where('statut', '=', 1)
      ->get();
      $data_inscriptpion = null;
      if(isset($_SESSION[S::DATA_TRANSPORT])){
          $data_inscriptpion = $_SESSION[S::DATA_TRANSPORT];
          $_SESSION[S::DATA_TRANSPORT] = null;
      }
      $this->render('sections.versement.versement_scolarite_edit', compact(
          //'abonnement_cantine',
          //'class_name', 'base_route', 'title', 'create_title', 'view_title', 'update_title', 'delete_title', 'msg_delete',
          'route',
          'activites',
          'data_inscriptpion',
          'title',
          'classes',
          'statut_apprenants',
          'annee_scolaires',
          'eleves',
          'pension_classe',
          'salle_classes',
          'type_pensions',
          'type_paiements',
          'tranche_scolaires',
          'prix_abonnement_activite',
          'prix_abonnement_cantine',
          'id_fact'
      ));
    }

    public function list_all()
    {
        $eleves = (new EleveRepository() )->getEleve();
        $results[API::TAG_DATA] = $eleves;
        $results[API::TAG_STATUS] = API::TAG_SUCCESS;
        $results[API::TAG_DATATABLE_DR] = API::TAG_DATATABLE_VALUE_DR;
        $results[API::TAG_DATATABLE_RT] = count($eleves);
        $results[API::TAG_DATATABLE_RF] = count($eleves);
        $results[API::TAG_DATA] = $eleves;
        echo Helpers::toJSON($results) ;
    }

    public function imprimer_facture(){

        $data = $_POST;

        //encodage des tables qui seront transferer dans une variable de session avec pour clé la reference de la facture du versement
        $data['pension_classe'] = json_decode($data['pension_classe'], true);
        $data['cantines'] = json_decode($data['cantines'], true);
        $data['autres'] = json_decode($data['autres'], true);
        $data['activites'] = json_decode($data['activites'], true);

        //Acces au données de la facture par session et dans les cookies()
        $_SESSION[$data['reference']] = $data;
        // setcookie($data['reference'], $data, TIME_COOKIE_LONG, URL::link('facture_cantine'));

        $this->renderPDF('reports.versement', compact('data'), 'facture_versement' );

    }

    
    public function impriner_facture_activite(){

        $data = $_POST;

        //encodage des tables qui seront transferer dans une variable de session avec pour clé la reference de la facture du versement
        $data['pension_classe'] = json_decode($data['pension_classe'], true);
        $data['cantines'] = json_decode($data['cantines'], true);
        $data['autres'] = json_decode($data['autres'], true);
        $data['activites'] = json_decode($data['activites'], true);

        //Acces au données de la facture par session et dans les cookies()
        $_SESSION[$data['reference']] = $data;
        // setcookie($data['reference'], $data, TIME_COOKIE_LONG, URL::link('facture_cantine'));

        $this->renderPDF('reports.versement', compact('data'), 'facture_versement' );

    }

    public function impriner_facture_cantine(){

        $data = $_POST;

        //encodage des tables qui seront transferer dans une variable de session avec pour clé la reference de la facture du versement
        $data['pension_classe'] = json_decode($data['pension_classe'], true);
        $data['cantines'] = json_decode($data['cantines'], true);
        $data['autres'] = json_decode($data['autres'], true);
        $data['activites'] = json_decode($data['activites'], true);

        //Acces au données de la facture par session et dans les cookies()
        $_SESSION[$data['reference']] = $data;
        // setcookie($data['reference'], $data, TIME_COOKIE_LONG, URL::link('facture_cantine'));

        $this->renderPDF('reports.versement', compact('data'), 'facture_versement' );

    }

    public function liste_abonnee()
    {
        $route = 'versement_liste';
        $menu_actif = 'liste_abonnee';

        $factures = DBTable::getModel('facture')
                  ->select()
                  ->where('visibilite', '=', 1)
                  ->orderBy('id', 'DESC')
                  ->get();

        $this->render('sections.versement.liste.versement_liste', compact('route', 'menu_actif', 'factures'));
    }

    public function liste_retard()
    {
        $route = 'versement_retard';

        $factures = DBTable::getModel('facture')
                  ->select()
                  ->where('visibilite', '=', 1)
                  ->orderBy('id', 'DESC')
                  ->get();

        $this->render('sections.versement.liste.versement_retard', compact('route', 'factures'));
    }

    public function liste_abonnee_test()
    {
        $route = 'versement_liste';


        $this->render('sections.versement.liste.versement_liste', compact('route'), 'default_empty');
    }


    public function suppression($id_fact)
    {
      $factures = DBTable::getModel('facture')
                ->update(['visibilite' => 0])
                ->where('id', '=', $id_fact)
                ->execute();

      $_SESSION['message']='<div class="col-md-10 alert alert-success" style="margin: auto; text-align: center;" role="alert">
                              Versement supprimé avec succès !
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>';
      //return redirect()->back()->with('success', 'Versement effectué avec succès');
      return header('location:'.URL::base().'versement/list');

    }

}
