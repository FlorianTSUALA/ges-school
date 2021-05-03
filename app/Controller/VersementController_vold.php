<?php

namespace App\Controller;

use Exception;
use App\Helpers\S;
use Core\Model\Model;
use App\Model\DBTable;
use App\Model\Facture;
use App\Model\Periode;
use App\Helpers\Helpers;
use Core\Session\Request;
use App\Model\PensionEleve;
use App\Helpers\DateHelpers;
use function Core\Helper\dd;
use function Core\Helper\vd;
use App\Model\AbonnementDetail;
use App\Model\AbonnementCantine;
use App\Model\AbonnementActivite;
use ClanCats\Hydrahon\Query\Expression as Ex;

class VersementController_old extends AppController
{
    
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
    public function index()
    {
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

        //Liste des prix associés aux offres de la cantine
        //$abonnement_cantine = DBTable::getModel('abonnement_cantine')->select(['code'=>'id', 'libelle' => 'libelle', 'montant'=>'montant'])->where('code', '=', 'MOIS')->where('visibilite', '=', 1)->one();
        // var_dump($abonnement_cantine); die();
        


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

        $this->render('sections.versement.versement_scolarite', compact(
            //'abonnement_cantine',
            //'class_name', 'base_route', 'title', 'create_title', 'view_title', 'update_title', 'delete_title', 'msg_delete',
            'activites',
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

    /*
    *  Enregistre les informations de  versement et retpurne le status d'enregistrement
    */
    public function save($code)
    {
        $eleve = DBTable::getModel('eleve')->select()->find($code, 'code');
        $eleve_id = $eleve['id'];
        $classe = DBTable::getModel('classe')->select()->find(Request::getSecParam('classe_id', ''), 'code');
        $classe_id = $classe['id'];

        $montant_paye = Request::getSecParam('montant_paye', 0);
        $nom_eleve = Request::getSecParam('nom_eleve', 0);
        $reduction = Request::getSecParam('reduction', 0);
        $date_facture = date('Y-m-d') ;
        // $motif =  Request::getSecParam('motif');
        // $reste =  Request::getSecParam('reste');
        // $autre =  Request::getSecParam('autre');
        // $reduction =  Request::getSecParam('reduction');
        $reference =  Request::getSecParam('reference', 0);
        $date_paiement =  Request::getSecParam('date_paiement');
        // $date_paiement =  date('Y-m-d H:i:s');

        $statut_apprenant_id = Model::getId(DBTable::STATUT_APPRENANT, Request::getSecParam('statut_apprenant_id', ''));
        $annee_scolaire_id = Model::getId(DBTable::ANNEE_SCOLAIRE, Request::getSecParam('annee_scolaire_id', ''));
        $type_paiement_id = Model::getId(DBTable::TYPE_PAIEMENT, Request::getSecParam('type_paiement_id', ''));
        
        //Facture
            $model_facture = DBTable::getModel(DBTable::FACTURE);
            $code_facture = Facture::generateCode();
            $data_facture = [
                'code' => $code_facture,
                'type_paiement_id' => $type_paiement_id,
                'libelle' => 'Facture versment',
                'reference' => $reference,
                'beneficiaire' => $nom_eleve,
                'gestionnaire' => 'Secretaire',
                'montant' => $montant_paye,
                'reduction' => $reduction,
                'date_facture' => $date_facture,
                'description' => '',
            ];
            $result_facture = $model_facture->insert($data_facture)->execute();
            $facure_id = Model::getId(DBTable::FACTURE, $code_facture);
        //Facture

        //AUTRES
            $autres = $_POST['autres'];
            $motif = $autres['type_pension'];
            $montant = $autres['montant'];
            $reduction = $autres['remise'];
            
    
            $model_pension_eleve = DBTable::getModel(DBTable::PENSION_ELEVE);

            $data_pension_eleve_autre = [
                'code' => PensionEleve::generateCode(),
                'facture_id' => $facure_id,
                'type_pension_id' => null,
                'pension_classe_id' => null,
                'tranche_scolaire_id' => null,
                'classe_id' => $classe_id,
                'eleve_id' => $eleve_id,
                'montant' => $montant,
                'reduction' => $reduction,
                'motif' => $motif,
                'quantite' => 1
            ];
            $result_pension_eleve = $model_pension_eleve->insert($data_pension_eleve_autre)->execute();
        //AUTRES

        //CANTINE
            $cantines = $_POST['cantines'];
           
            $items = $cantines['recapitulatif'];
            
            $hasDiscountinous = true;
            $i = 0;
            $j = 0;

            for($i = 0; $i<count($items); $i++){

                $prev_index_month = DateHelpers::strFrMonth2Index($items[$i]['value']);
                $current_index_month = $prev_index_month;
                
                if(($i+1) == count($items)){
                    $j = $i;
                }else{
                    for ($j = $i+1; $j<count($items); $j++) {
                        $current_index_month = DateHelpers::strFrMonth2Index($items[$j]['value']);
                        // echo '\n current '.$current_index_month;
                        // echo '\n prev '.$prev_index_month;
                        if($current_index_month != ($prev_index_month + 1)){
                            break;
                        }
                        $prev_index_month = $current_index_month;
                    }
                }
                echo '<br> $i = '. $i;
                echo '<br> $j = '. $j;
                $offset = $j - 1 - $i;
                $quantite = $offset + 1;
                echo '<br> $begin = '. $items[$i]['value'];
                echo '<br> $end = '.  DateHelpers::addFrMonth( $items[$i]['value'], $offset);
                

                $start_date = DateHelpers::getFirstDayOfMonthByStrFrMonth( $items[$i]['value'] );
                $end_date = DateHelpers::getLastDayOfMonthByStrFrMonth(  DateHelpers::addFrMonth( $items[$i]['value'], $offset) );

                echo '<br> $start_date = '. $start_date;
                echo '<br> $end_date = '. $end_date;

                $model_cantine = DBTable::getModel(DBTable::ABONNEMENT_CANTINE);
                $code_cantine = AbonnementCantine::generateCode();
                $data_abonnment_cantine = [
                    'code' => $code_cantine,
                    'eleve_id' => $eleve_id,
                    'montant_total' => $cantines['montant'] * $cantines['multiplicateur'] ,
                    'reduction' => $cantines['remise'],
                    'date_debut' => $start_date,
                    'date_fin' => $end_date,
                ];
                
                $result_abonnement_cantine = $model_cantine->insert($data_abonnment_cantine)->execute();
                $abonnement_cantine_id = Model::getId(DBTable::ABONNEMENT_CANTINE, $code_cantine);
      
                $mois = $items[$i]['value'];
                
                echo $quantite;
                echo '<br> $îi = '.$items[$i]['value'];
                echo '<br> $^j = '.$items[$j]['value'];
                
                $start_day =  DateHelpers::getFirstDayOfMonthByStrFrMonth($items[$i]['value']);
                $end_day = DateHelpers::getLastDayOfMonthByStrFrMonth( DateHelpers::addDays( $items[$i]['value'], $offset) );
                
                $abonnement_detail = DBTable::getModel(DBTable::ABONNEMENT_DETAIL);
                
                $data_abonnment_detail = [
                    'code' => AbonnementDetail::generateCode(),
                    'abonnement_id' => $abonnement_cantine_id,
                    'periode' =>  'MOIS',
                    'multiplicateur' => $quantite,
                    'total' =>  $cantines['montant'] * $quantite,
                    'prix_unitaire' =>  $cantines['montant'],
                    'date_debut' =>  $start_day,
                    'date_fin' =>  $end_day
                ];
                $result_abonnement_detail = $abonnement_detail->insert($data_abonnment_detail)->execute();

                
                $i = $j - 1;
                
                // for ($k = $i; $k<$j; $k++) {
                    
                //     $item = $items[$k];
                //     $mois = $item['value'];
                //     $start_day = DateHelpers::getFirstDayOfMonthByStrFrMonth($mois);
                //     $end_day = DateHelpers::getLastDayOfMonthByStrFrMonth($mois);
                
                //     $abonnement_detail = DBTable::getModel(DBTable::ABONNEMENT_DETAIL);
                //     $data_abonnment_detail = [
                //         'code' => AbonnementDetail::generateCode(),
                //         'abonnement_id' => $abonnement_cantine_id,
                //         'periode' =>  'MOIS',
                //         'multiplicateur' => $cantines['multiplicateur'],
                //         'total' =>  $cantines['montant'] * $cantines['multiplicateur'],
                //         'prix_unitaire' =>  $cantines['montant'],
                //         'date_debut' =>  $start_day,
                //         'date_fin' =>  $end_day
                //     ];
                //     $abonnement_detail->insert($data_abonnment_detail)->execute();

                // }
                // $i = $j;
                
            }


            die('hi');
        
        //CANTINE


        //ACTIVITE

            $activites = $_POST['activites'];
            
            $items = $activites['multiplicateur']??[];
            $reduction = $activites['remise'];

            foreach($activites as $activite){
                $nom_activite = $activite['value'];
                $code_activite = $activite['id'];
                $montant_activite = $activite['montant'];
                
                $i = 0;
                $j = 0;
                for($i = 0; $i<count($items); $i++){
    
                    $prev_index_month = DateHelpers::getIndexMonth($items[$i]['value']);
                    $current_index_month = $prev_index_month;
    
                    if(($i+1) == count($items)){
                        $j = $i;
                    }else{
                        for ($j = $i+1; $j<count($items); $j++) {
                            $current_index_month = DateHelpers::getIndexMonth($items[$j]['value']);
                            if($current_index_month != ($prev_index_month + 1)){
                                break;
                            }
                            $prev_index_month = $current_index_month;
                        }
                    }
    
                    $start_date = DateHelpers::getFirstDayOfMonthByStrFrMonth(DateHelpers::getIndexToEnStrMonth($current_index_month-($j-$i)));
                    $end_date = DateHelpers::getLastDayOfMonthByStrFrMonth(DateHelpers::getIndexToEnStrMonth($current_index_month));
    
                    $model_abonnement_activite = DBTable::getModel(DBTable::ABONNEMENT_ACTIVITE);
                    $code_abonnement_activite = AbonnementActivite::generateCode();
    
                    $data_abonnement_activite = [
                        'code' => $code_abonnement_activite,
                        'eleve_id' => $eleve_id,
                        'montant_total' => $montant_activite * $activites['recapitulatif'] ,
                        'reduction' => $activites['remise'],
                        'date_debut' => $start_date,
                        'date_fin' => $end_date,
                    ];
                    
                    $result_abonnement_cantine = $model_cantine->insert($data_abonnement_activite)->execute();
                    $abonnement_activite_id = Model::getId(DBTable::ABONNEMENT_CANTINE, $code_abonnement_activite);
                    

                    $item = $items[$i];
                    $mois = $item['value'];
                    $start_day = DateHelpers::getFirstDayOfMonthByStrFrMonth($mois);
                    for ($k = $i; $k<$j; $k++) {
                        $item = $items[$k];
                        $end_day = DateHelpers::getLastDayOfMonthByStrFrMonth($mois);
                    }
                
                    $abonnement_detail = DBTable::getModel(DBTable::ABONNEMENT_DETAIL);
                    $quantite = ((($j - $i  -1) > 0)? ($j - $i  -1) : 1);
                    $data_abonnment_detail = [
                        'code' => AbonnementDetail::generateCode(),
                        'abonnement_id' => $abonnement_activite_id,
                        'periode' =>  'MOIS',
                        'multiplicateur' => $quantite,
                        'total' =>  $montant_activite * $quantite,
                        'prix_unitaire' =>  $montant_activite,
                        'date_debut' =>  $start_date,
                        'date_fin' =>  $end_date
                    ];
                    $result_abonnement_detail = $abonnement_detail->insert($data_abonnment_detail)->execute();

                    
                    $i = $j;
                    
                }
            }
        
        //ACTIVITE

        
        //PENSION ELEVE
            $data_pension = $_POST['pension_classe'];

            $model_pension_eleve = DBTable::getModel(DBTable::PENSION_ELEVE);

            foreach ($data_pension as $item) {

                $motif = $data_pension['type_pension'];
                $montant = $data_pension['montant'];
                $reduction = $data_pension['remise'];
                $type_pension_id = $data_pension['type_pension_code'];
                $pension_classe_id = $data_pension['pension_classe_code'];
                $est_mensuel = $data_pension['est_mensuel'];
                $quantite = $data_pension['recapitulatif'];

                if($est_mensuel == 1){    
                    foreach($data_pension['multiplicateur'] as $tranche){
                        $tranche_scolaire_id = $tranche['id'];
                        $motif = 'Payement Periodique - '.$tranche['value'];

                        $data_pension_eleve_autre = [
                            'code' => PensionEleve::generateCode(),
                            'facture_id' => $facure_id,
                            'type_pension_id' => $type_pension_id,
                            'pension_classe_id' => $pension_classe_id,
                            'tranche_scolaire_id' => $tranche_scolaire_id,
                            'classe_id' => $classe_id,
                            'eleve_id' => $eleve_id,
                            'montant' => $montant,
                            'reduction' => $reduction,
                            'motif' => $motif,
                            'quantite' => 1
                        ];
                        $model_pension_eleve->insert($data_pension_eleve_autre)->execute();
                    }
                }else{
                    $motif = 'Payement Non periodique';
                    
                    $data_pension_eleve_autre = [
                        'code' => PensionEleve::generateCode(),
                        'facture_id' => $facure_id,
                        'type_pension_id' => $type_pension_id,
                        'pension_classe_id' => $pension_classe_id,
                        'tranche_scolaire_id' => null,
                        'classe_id' => $classe_id,
                        'eleve_id' => $eleve_id,
                        'montant' => $montant,
                        'reduction' => $reduction,
                        'motif' => $motif,
                        'quantite' => $quantite
                    ];
                    $result_pension_eleve = $model_pension_eleve->insert($data_pension_eleve_autre)->execute();

                }
            }
        //PENSION ELEVE
        
        vd($result_pension_eleve , $result_abonnement_detail , $result_abonnement_cantine , $result_facture);
        $result = $result_pension_eleve && $result_abonnement_detail && $result_abonnement_cantine && $result_facture ;

        if($result){
            $this->sendResponseAndExit(Helpers::toJSON($result, TRUE));
        }else{
            $this->sendResponseAndExit($result, FALSE, 400, 'DB Error');
        }
        

    }

    public function print(){
        
        // $periode
        // $date_debut
        // $date_fin
        // $prix_unitaire
        // $quantite
        // $total
        // , compact('date_facturation', 'eleve', 'classe', 'reference', 'remise', 'reste', 'solde_paye', 'sous_total', 'items'), 'facture_cantine'
        $this->renderPDF('reports.versement' );  

    }

}
