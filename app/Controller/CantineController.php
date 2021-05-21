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
use App\Repository\AnneeScolaireRepository;
use ClanCats\Hydrahon\Query\Expression as Ex;
use App\Controller\Admin\AppController;

class CantineController extends AppController
{

    private $cantine_repository;
    use TraitCRUDController;
    public function __construct()
    {
        parent::__construct();
        $this->cantine_repository = new CantineRepository;

        $this->vairant = DBTable::ABONNEMENT_CANTINE;
        $this->folder_view_index = 'cantine.abonnement_cantine';

        $this->loadModel($this->vairant);
        $this->base_route = 'abonnement_cantine';
        $this->class_name = 'abonnement_cantine';

        $this->title_page = 'Gestion du abonnement_cantine - Ges-School';
        $this->title_home = 'Gestion du abonnement_cantine';
        $this->create_title = "Ajout d'un abonnement_cantine";
        $this->view_title = "Information sur un abonnement_cantine";
        $this->update_title = "Mise à jour des informations du perosnnel";
        $this->delete_title = "Suppression du abonnement_cantine";
        $this->msg_delete = "Voulez-vous vraiment supprimer ce abonnement_cantine ";
        
    }

    public function accueil()
    {
        $welcome_msg = '';
        
        $exemple = [];
        $this->render('sections.cantine.accueil', compact('exemple'));
    }

    /*

        $eleves = DBTable::getModel('eleve')
                            ->select(
                                [
                                    new Ex("concat(eleve.nom,' ',eleve.prenom) as nom_complet"),
                                    'eleve.code' => 'id',
                                    'eleve.matricule' => 'matricule',
                                    'eleve.date_naissance' => 'date_naissance',
                                    'eleve.lieu_naissance' => 'lieu_naissance'
                                ]
                            )
                            ->where('visibilite', '=', 1)
                            ->get();





        public function getall()
        {
            $model = AbonnementCantine::table();
            $results = $model->select('
                    type_abonnement_cantine.libelle as type_abonnement_cantine_id,
                    pays.libelle as pays_id,
                    abonnement_cantine.code as code,
                    abonnement_cantine.nom,
                    abonnement_cantine.prenom,
                    abonnement_cantine.bibliographie')
                ->where('abonnement_cantine.visibilite', 1)

                ->join('type_abonnement_cantine', 'abonnement_cantine.type_abonnement_cantine_id', '=', 'type_abonnement_cantine.id')
                ->join('pays', 'abonnement_cantine.pays_id', '=', 'pays.id')
                ->get();        
            
            return $results;
        }
    */
        
        
    public function abonnement_cantine()
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

        $this->render('sections.cantine.abonnement_cantine', compact('prix_abonnements', 'type_paiements', 'eleves', 'classes'));
    }

    public function save($code)
    {
        // dd($_POST['cantines']['data']);      
        $montant_paye = Request::getSecParam('montant_total', 0);
        $nom_eleve = Request::getSecParam('nom_eleve', '------/|\--/|\--/|\------');
        $reduction = Request::getSecParam('reduction', 0);
        $date_facture = date('Y-m-d') ;
        $reference =  Request::getSecParam('reference', 0);
        $type_paiement_id = Model::getId(DBTable::TYPE_PAIEMENT, Request::getSecParam('type_paiement_id', ''));
    
        //Facture
            $model_facture = DBTable::getModel(DBTable::FACTURE);
            $code_facture = Facture::generateCode();
            $data_facture = [
                'code' => $code_facture,
                'type_paiement_id' => $type_paiement_id,
                'libelle' => 'Facture versement',
                'reference' => $reference,
                'beneficiaire' => $nom_eleve,
                'gestionnaire' => 'Secretaire',
                'montant' => $montant_paye,
                'reduction' => $reduction,
                'date_facture' => $date_facture,
                'description' => '',
            ];
            $model_facture->insert($data_facture)->execute();
            $facure_id = Model::getId(DBTable::FACTURE, $code_facture);
        //Facture

        $model = DBTable::getModel(DBTable::ABONNEMENT_CANTINE);
        $code_cantine = AbonnementCantine::generateCode();

        $eleve_id = Model::getId(DBTable::ELEVE, Request::getSecParam('eleve_id', ''));
        $data_abonnment = [
            'code' => $code_cantine,
            'montant_total' => $montant_paye,
            'reduction' => $reduction,
            'eleve_id' => $eleve_id,
            'facture_id' => $facure_id,
            'date_paiement' => Request::getSecParam('date_paiement', ''),
            'date_debut' => Request::getSecParam('date_debut', ''),
            'date_fin' => Request::getSecParam('date_fin', ''),
        ];
        $model->insert($data_abonnment)->execute();

        $abonnement_detail = DBTable::getModel(DBTable::ABONNEMENT_DETAIL);
        $items = $_POST['cantines']['data'];
        $abonnement_cantine_id = Model::getId(DBTable::ABONNEMENT_CANTINE, $code_cantine);
        $dayCount  = 0; 
        $start_day = Request::getSecParam('date_debut', '');
        $end_day = Request::getSecParam('date_debut', '');
        foreach($items as $item){
            
            $dayCount = Periode::getDayCount($item['periode']) * $item['duree'] - 1; //On reduit un puisqu'on compte la date du jour
            $end_day = Helpers::addDays($start_day, $dayCount);
            $data_abonnment_detail = [
                'code' => AbonnementDetail::generateCode(),
                'abonnement_id' => $abonnement_cantine_id,
                'periode' =>  $item['periode'],
                'multiplicateur' =>  $item['duree'],
                'total' =>  $item['sous_total'],
                'prix_unitaire' =>  $item['prix_unitaire'],
                'date_debut' =>  $start_day,
                'date_fin' =>  $end_day
            ];
                    
            $start_day = Helpers::addDays($end_day, 1); // On recompte à partir du jour d'apres

            $abonnement_detail->insert($data_abonnment_detail)->execute();
        }
        
        if (isset($abonnement_cantine_id)) {
            $this->sendResponseAndExit(Helpers::toJSON('Abonnement enregistrée avec success', TRUE));
        } else {
            $this->sendResponseAndExit(Helpers::toJSON('Erreur d\'enregistement à la base de données !!!', TRUE), false, 400, 'BD error : data '. $code);
        }
    }

    public function liste_abonnee()
    {
        $classes = (new ClasseRepository())->getSalleClasseGroupByClasse();
        
        $annee_scolaire =  (new AnneeScolaireRepository())->getActive('id');

        $abonnements = DBTable::getModel(DBTable::ABONNEMENT_CANTINE)
        ->select(
            [
                'abonnement_cantine.code'=> 'id', 
                'abonnement_cantine.date_paiement'=> 'date_paiement', 
                'abonnement_cantine.date_debut'=> 'date_debut', 
                'abonnement_cantine.date_fin'=> 'date_fin', 
                'abonnement_cantine.montant_total'=> 'montant_total', 
                'classe.libelle'=> 'classe', 
                'classe.code'=> 'code_classe', 
                new Ex("concat(eleve.nom,' ',eleve.prenom) as nom_eleve"),
                'eleve.code' => 'eleve_id'
            ]
        )
        ->join('eleve', 'eleve.id', '=', 'abonnement_cantine.eleve_id')
        ->join('parcours', 'eleve.id', '=', 'parcours.eleve_id')
        ->join('classe', 'parcours.classe_id', '=', 'classe.id')
        ->join('pension_classe', 'pension_classe.classe_id', '=', 'parcours.classe_id')
        ->where('abonnement_cantine.visibilite', '=', 1)
        // ->where('parcours.annee_scolaire_id', '=', $annee_scolaire)
        ->get();


        $this->render('sections.cantine.abonnement_liste', compact( 'classes','abonnements'));
    }

    public function imprimer_facture(){
        
        $data = $_POST;
        
        $data['data_items'] = json_decode($data['data_items'], true);
        // dd($data);
        //Acces au données de la facture par session et dans les cookies()
        $_SESSION[$data['reference']] = $data;
        // setcookie($data['reference'], $data, TIME_COOKIE_LONG, URL::link('facture_cantine'));

        // dd($data);

        $this->renderPDF('reports.cantine', compact('data'), 'facture_cantine' );  

    }

    public function push_facture($reference){
        
        //Acces au données de la facture par session et dans les cookies()
        
        if($_SESSION[$reference]){
            $data = $_SESSION[$reference];
        }else{
            if($_COOKIE[$reference]){
                $data = $_COOKIE[$reference];
            }else{

            }
        }
        $this->renderPDF('reports.cantine', compact('data'), 'facture_cantine' );  

    }

    public function abonnement_info()
    {
        $filter_by = Request::getSecParam('filter_by');
        $code = Request::getSecParam('code');
        $start_date = Request::getSecParam('start_date');
        $end_date = Request::getSecParam('end_date');
        
       $result = true;
       $cantine_repository = new CantineRepository();
        $items = $cantine_repository->getInfoByClasseDate($start_date, $filter_by, $code);
        $data = HTMLHelper::genBodyTable($items, $this->class_name, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $this->{$this->vairant}->fillables));
        dd($data);
        if($result){
            
            $this->sendResponseAndExit($data);
        }else{
            $this->sendResponseAndExit($data, FALSE, 400, 'DB Error');
        }
    }

}
