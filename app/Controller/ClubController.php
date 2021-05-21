<?php

namespace App\Controller;

use App\Helpers\S;
use App\Model\Classe;
use Core\Model\Model;
use Core\Routing\URL;
use App\Model\DBTable;
use App\Model\Facture;
use App\Model\Periode;
use App\Helpers\Helpers;
use Core\Helper\DBHelper;
use Core\Session\Request;
use App\Helpers\HTMLHelper;
use function Core\Helper\dd;
use function Core\Helper\vd;
use Core\HTML\Form\FormModel;
use App\Model\AbonnementDetail;
use App\Model\AbonnementCantine;
use App\Helpers\TraitCRUDController;
use App\Repository\ClasseRepository;
use App\Repository\CantineRepository;
use App\Repository\EleveRepository;
use App\Repository\AnneeScolaireRepository;
use ClanCats\Hydrahon\Query\Expression as Ex;
use App\Controller\Admin\AppController;

class ClubController extends \App\Controller\Admin\AppController
{
    /**
     * Initialise les Models qu'on charge dans ce controller
     **/
    public function __construct()
    {
        parent::__construct();

        // $this->vairant = DBTable::versement;
        // $this->folder_view_index = 'versement.index';

        // $this->loadModel($this->vairant);
        $this->base_route = 'club';
        // $this->class_name = 'pension_eleve';

        $this->title_page = 'Gestion des versements - Ges-School';
        $this->title_home = 'Gestion des versements';
        $this->create_title = "Creation d'un versement";
        $this->view_title = "Information d'un versement";
        $this->update_title = "Mise à jour d'un versement";
        $this->delete_title = "Suppression d'un versement";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce versement ";

    }

    public function index()
    {
        $route = "club";
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

        $eleves = (new EleveRepository() )->getInfoPerso();

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
                    'pension_classe.est_mensuel' => 'est_mensuel',
                    'pension_classe.mensualite' => 'mensualite',
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
                   
        $prix_abonnement_activites = DBTable::getModel('prix_abonnement')
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
        $this->render('sections.club.abonnement_club', compact(
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
            'prix_abonnement_activites',
            'prix_abonnement_cantine'
        ));
    }

 
    public function accueil()
    {
        $exemple = [];
        $this->render('sections.club.accueil', compact('exemple'));
    }

    public function abonnement_club()
    {
        $this->app->setTitle('Abonnement Cantine- Ges-School');

        $prix_abonnements = DBTable::getModel('prix_abonnement')
                            ->select(
                                [
                                    'prix_abonnement.code' => 'id',
                                    'prix_abonnement.montant' => 'montant',
                                    'prix_abonnement.periode' => 'periode',
                                    'prix_abonnement.description' => 'description'
                                ]
                            )
                            ->where('visibilite', '=', 1)
                            ->where('type_abonnement', '=', 'CANTINE')
                            ->get();

                            
        
        $eleves = DBTable::getModel('eleve')
                    ->select(
                        [
                            new Ex("concat(eleve.nom,' ',eleve.prenom) as libelle"),
                            'eleve.code' => 'id',
                            'eleve.matricule' => 'matricule',
                            'eleve.date_naissance' => 'date_naissance',
                            'eleve.lieu_naissance' => 'lieu_naissance'
                        ]
                    )
                    ->where('visibilite', '=', 1)
                    ->get();


        $classes = DBTable::getModel('classe')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();
        $type_paiements = DBTable::getModel('type_paiement')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();

        //var_dump($prix_abonnements);

        $this->render('sections.club.abonnement_club', compact('prix_abonnements', 'type_paiements', 'eleves', 'classes'));
    }

    public function save(){
        echo "BABY BY ME";
        print_r($_POST['activites']['activites']);
        // $montant_paye = Request::getSecParam('montant_total', 0);
        // $nom_eleve = Request::getSecParam('nom_eleve', '------/|\--/|\--/|\------');
        $reduction = Request::getSecParam('reduction', 0);
        echo $reduction;
        // $date_facture = date('Y-m-d');
        // $reference = Request::getSecParam('reference', 0);
        // $type_paiement_id = Model::getId(DBTable::TYPE_PAIEMENT, Request::getSecParam('type_paiement_id', ''));

        // // Facture
        // $model_facture = DBTable::getModel(DBTable::FACTURE);
        // $code_facture = Facture::generateCode();
        // $data_facture = [
        //     'code': => $code_facture,
        //     'type_paiement_id' => $type_paiement_id,
        //     'libelle' => 'Facture versement',
        //     'reference' => $reference,
        //     'beneficiare' => $nom_eleve,
        //     'gestionnaire' => 'Secretaire',
        //     'montant' => $montant_paye,
        //     'reduction' => $reduction,
        //     'date_facture' => $date_facture,
        //     'description' => '',
        // ];
        // $model_facture->insert($data_facture)->execute();
        // $facture_id = Model::getId(DBTable::FACTURE, $code_facture);
        // // Facture

        $model = DBTable::getModel(DBTable::ABONNEMENT_ACTIVITE);
        // $code_activite = AbonnementActivite::generateCode();
        // $eleve_id = Model::getId(DBTable::ELEVE, Request::getSecParam('eleve_id', ''));
        // $data_abonnement = [
        //     'code' => $code_activite,
        //     'montant_total' => $montant_paye,
        //     'reduction' => $reduction,
        //     'eleve_id' => $eleve_id,
        //     'facture_id' => $facture_id,
        //     'date_paiement' => Request::getSecParam('date_paiement', '');
        //     'date_debut' => Request::getSecParam('date_fin', '');
        // ];

        $eleve_id = Model::getId(DBTable::ELEVE, Request::getSecParam('eleve_id', ''));
        $data_abonnement = [
            'code' => "ACTI_1599816321",
            'montant_total' => " 500",
            'reduction' => "11",
            'eleve_id' => 1,
            'facture_id' => 3,
            'date_paiement' => "2000-08-15 00:00:00",
            'date_debut' =>"2000-08-15 00:00:00",
        ];

        $model->insert($data_abonnement)->execute();

        // $abonnement_detail = DBTable::getModel(DBTable:: ABONNEMENT_DETAIL);
        // $items = $_POST['activite']['data'];
        // $abonnement_activite_id = Model::getId(DBTable::ABONNEMENT_CANTINE, $code_cantine);
        // $dayCount = 0;

        // $start_day = Request::getSecParam('date_debut', '');
        // $end_day = Request::getSecParam('date_debut', '');

        // foreach ($items as $item) {
        //     # code...
        //     $dayCount = Periode::getDayCount($item['periode']) * $item['duree'] - 1;
        //     $end_day = Helpers::addDays($start_day, $dayCount);

        //     $data_abonnement_detail = [
        //         'code' => AbonnementDetail::generateCode(),
        //         'abonnement_id' => $item['periode'],
        //         'periode' => $item['periode'],
        //         'multiplicateur' => $item['duree'],
        //         'total' => $item['sous_total'],
        //         'prix_unitaire' => $item['prix_unitaire'],
        //         'date_debut' => $start_day,
        //         'date_fin' => $end_day
        //     ];

        //     $start_day = Helpers::addDays($end_day, 1);

        //     $abonnement_detail->insert($data_abonnement_detail)->execute();

        // }

        // if(isset($abonnement_activite_id)){
        //     $this->sendRespondAndExit(Helper::toJSON('Abonnement enregistré avec succès'));
        // }else{
        //     $this->sendResponseAndExit(Helpers::toJSON('Erreur d\'enregistrement'))
        // }

    }

    public function liste_abonnee_activite(){
        $classes = (new ClasseRepository())->getSalleClasseGroupByClasse();
        
        $annee_scolaire =  (new AnneeScolaireRepository())->getActive('id');

        $abonnements = DBTable::getModel(DBTable::ABONNEMENT_ACTIVITE)
        ->select(
            [
                'abonnement_activite.code'=> 'id', 
                'abonnement_activite.date_paiement'=> 'date_paiement', 
                'abonnement_activite.date_debut'=> 'date_debut', 
                'abonnement_activite.date_fin'=> 'date_fin', 
                'abonnement_activite.montant_total'=> 'montant_total', 
                'classe.libelle'=> 'classe', 
                'classe.code'=> 'code_classe', 
                new Ex("concat(eleve.nom,' ',eleve.prenom) as nom_eleve"),
                'eleve.code' => 'eleve_id'
            ]
        )
        ->join('eleve', 'eleve.id', '=', 'abonnement_activite.eleve_id')
        ->join('parcours', 'eleve.id', '=', 'parcours.eleve_id')
        ->join('classe', 'parcours.classe_id', '=', 'classe.id')
        ->join('pension_classe', 'pension_classe.classe_id', '=', 'parcours.classe_id')
        ->where('abonnement_activite.visibilite', '=', 1)
        // ->where('parcours.annee_scolaire_id', '=', $annee_scolaire)
        ->get();


        $this->render('sections.club.abonnement_club-list', compact( 'classes','abonnements'));
        // $this->render('sections.club.abonnement_club-list',[]);
    }

}