<?php

namespace App\Controller;

use DateTime;
use App\Helpers\S;
use App\Model\Eleve;
use App\Model\Classe;
use Core\Model\Model;
use App\Model\DBTable;
use App\Model\Facture;
use App\Model\Parcours;
use App\Helpers\Helpers;
use App\Model\Personnel;
use Core\Session\Request;
use App\Model\StatutEleve;
use App\Model\Technique\E;
use App\Model\TypePension;
use App\Model\PensionEleve;
use function Core\Helper\dd;
use function Core\Helper\vd;
use App\Model\GroupeFamilial;
use App\Model\AbonnementDetail;
use App\Model\AbonnementCantine;
use App\Model\AbonnementActivite;
use App\Model\GroupeReductionFamiliale;
use App\Repository\EleveRepository;
use App\Model\ReductionFamiliale;
use App\Repository\ParcoursRepository;
use App\Repository\PrixPaiementRepository;
use App\Repository\GroupeFamilialRepository;
use App\Repository\StatutApprenantRepository;

trait VersementControllerTraitMultiple
{

    public function index_multiple()
    {
        $route = "versement_multiple";
        $title = "Gestion des frais scolaires";
        $this->app->setTitle($this->title_page);
        $base_route = $this->base_route;
        $create_title = $this->create_title;
        $view_title = $this->view_title;
        $update_title = $this->update_title;
        $delete_title = $this->delete_title;
        $msg_delete = $this->msg_delete;

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        
        $eleves = (new EleveRepository() )->getEleve();

        //Liste des prix associés aux offres de la cantine

        $type_paiements = DBTable::getModel('type_paiement')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();

        $mois = DBTable::getModel('mois')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();
        $type_pensions = DBTable::getModel('type_pension')->select(['code'=>'id', 'paiement_en_tranche', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();
        $activites = DBTable::getModel('activite')->select(['code'=>'id', 'libelle' => 'libelle', 'montant' => 'montant'])->where('visibilite', '=', 1)->get();
        $classes = DBTable::getModel('classe')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();

        $pension_classe = (new PrixPaiementRepository())->getPensionGroupByClasse($annee_scolaire_id);
        $prix_scolarite_tranche_classe = (new PrixPaiementRepository())->getPensionScolaireClasseGroupByClasse($annee_scolaire_id);
        $prix_inscription_tranche_classe = (new PrixPaiementRepository())->getPensionInscriptionClasseGroupByClasse($annee_scolaire_id);
        $prix_abonnement_cantine = (new PrixPaiementRepository())->getPrixMensuelCantine($annee_scolaire_id);
        $prix_abonnement_activite = (new PrixPaiementRepository())->getPrixAbonnementActivite($annee_scolaire_id);;

        // Tranche de l'annee scolaire en cours
        $tranche_scolaires = DBTable::getModel('tranche_scolaire')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();

        $data_inscriptpion = null;
        if(isset($_SESSION[S::DATA_TRANSPORT])){
            $data_inscriptpion = $_SESSION[S::DATA_TRANSPORT];
            // $_SESSION[S::DATA_TRANSPORT] = null;
        }

        $this->render('sections.versement.multiple.ajout.versement_multiple', compact(
            'route',
            'title',

            'data_inscriptpion',

            'activites',
            'eleves',
            'classes',
            'mois',
            'tranche_scolaires',

            'type_pensions',
            'type_paiements',

            'pension_classe',
            
            'prix_scolarite_tranche_classe',
            'prix_inscription_tranche_classe',
            'prix_abonnement_cantine',
            'prix_abonnement_activite'
        ));
    }

    /*
    *  Enregistre les informations de  versement et retpurne le status d'enregistrement
    */
    public function save_multiple($code)
    {
        $debug = false;
        $ids_pension_eleve = [];
        $ids_pension_abonnement_detail = [];
        $ids_pension_cantine = [];
        $ids_pension_activite = [];

        $eleve = DBTable::getModel('eleve')->select()->find($code, 'code');
        $eleve_id = $eleve['id'];
        $nom_eleve =  $eleve['nom'] ." ".$eleve['prenom'];

        $classe_id = DBTable::getModel('classe')->select()->find(Request::getSecParam('classe_id', ''), 'code')['id'];

        $montant_paye = Request::getSecParam('montant_paye', 0);

        $reduction = Request::getSecParam('reduction', 0);
        $date_facture = date('Y-m-d') ;

        $reference =  Request::getSecParam('reference', 0);
        $date_paiement =  Request::getSecParam('date_paiement');

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE);

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
                'personnel_id' => Personnel::get_id($this->session->get(S::PERS_CODE)),
                'eleve_id' => Eleve::get_id($code),
                'annee_scolaire_id' => ($this->session->get(S::ANNEE_SCOLAIRE)),
                'gestionnaire' => $this->session->get(S::PERS_NOM) . " " . $this->session->get(S::PERS_PRENOM),
                'montant' => $montant_paye,
                'reduction' => $reduction,
                'date_facture' => $date_facture,
                'date_paiement' => $date_paiement,
                'description' => '',
            ];
            $model_facture->insert($data_facture)->execute();
            $facure_id = Model::getId(DBTable::FACTURE, $code_facture);
        //Facture
        
        if($debug)   vd('ok Facture');

        //PENSION ELEVE
                $data_pension = $_POST['pension_classe'];
                $data_pension = is_array($data_pension)? $data_pension : [];

                if($debug) vd( $data_pension );
                
                foreach ($data_pension??[] as $item) {
                    $type_pension_code = $item['type_pension_code'];
                    $type_pension = $item['type_pension'];
                    $montant = $item['montant'];
                    $paiement_en_tranche = $item['paiement_en_tranche'];
                    $reduction = $item['reduction'];


                  
                    
                    $type_pension_id = Model::getId(DBTable::TYPE_PENSION, $type_pension_code);
                    // vd($item);

                    if($paiement_en_tranche == E::OUI ){
                        // $tranche = $item['tranche'];

                        if(isset($item['tranche']) && is_array($item['tranche'])) //sinon aucune donnée n'a été renseigner pour le payement de la scolatité
                            foreach($item['tranche']??[] as $key => $tranche){
                                {

                                    $pension_classe_code = $tranche['pension_classe_code'];
                                    $tranche_scolaire_code = $tranche['tranche_scolaire_code'];
                
                                    $tranche_scolaire_id = Model::getId(DBTable::TRANCHE_SCOLAIRE, $tranche_scolaire_code);
                                    $pension_classe_id = Model::getId(DBTable::PENSION_CLASSE, $pension_classe_code);

                                    $model_pension_eleve = DBTable::getModel(DBTable::PENSION_ELEVE);

                                    $type_pension = 'Payement Periodique - '.$tranche['value'];
                                    $code_pension_eleve = PensionEleve::generateCode();

                                    $data_pension_eleve = [
                                        'code' => $code_pension_eleve,
                                        'facture_id' => $facure_id,
                                        'type_pension_id' => $type_pension_id,
                                        'pension_classe_id' => $pension_classe_id,
                                        'tranche_scolaire_id' => $tranche_scolaire_id,
                                        'classe_id' => $classe_id,
                                        'eleve_id' => $eleve_id,
                                        'montant' => $montant,
                                        'reduction' => $reduction,
                                        'motif' => $type_pension,
                                        'quantite' => 1
                                    ];

                                    $model_pension_eleve->insert($data_pension_eleve)->execute();
                                    $pension_eleve_id = Model::getId(DBTable::PENSION_ELEVE, $code_pension_eleve);
                                    array_push($ids_pension_eleve, $pension_eleve_id);
                                }
                            }
                    }else{

                        if(isset($item['multiplicateur']) && ($item['multiplicateur'] != "0") && !empty($item['montant_net']))
                        {
                            $pension_classe_code = $item['pension_classe_code'];
                            $pension_classe_id = Model::getId(DBTable::PENSION_CLASSE, $pension_classe_code);

                            $model_pension_eleve = DBTable::getModel(DBTable::PENSION_ELEVE);
                            $type_pension = 'Payement Non periodique';
                            $code_pension_eleve = PensionEleve::generateCode();

                            $data_pension_eleve_autre = [
                                'code' => $code_pension_eleve,
                                'facture_id' => $facure_id,
                                'type_pension_id' => $type_pension_id,
                                'pension_classe_id' => $pension_classe_id,
                                'tranche_scolaire_id' => null,
                                'classe_id' => $classe_id,
                                'eleve_id' => $eleve_id,
                                'montant' => $montant,
                                'reduction' => $reduction,
                                'motif' => $type_pension,
                                'quantite' => 1
                            ];

                            $model_pension_eleve->insert($data_pension_eleve_autre)->execute();
                            $pension_eleve_id = Model::getId(DBTable::PENSION_ELEVE, $code_pension_eleve);
                            array_push($ids_pension_eleve, $pension_eleve_id);
                        }

                        if($type_pension_code == TypePension::INSCRIPTION_CODE){
                            //  ##region INSCRIPTION PARCOURS 

                                $model_parcours = Parcours::table();
                                $code_parcours = Parcours::generateCode();
                                $data_parcours = [
                                    'code' => $code_parcours,
                                    Parcours::ANNEE_SCOLAIRE_ID => $this->session->get(S::ANNEE_SCOLAIRE),
                                    'date_inscription' => (new DateTime('NOW'))->format('Y-m-d H:i:s'),
                                    Parcours::ELEVE_ID => $eleve_id,
                                    Parcours::CLASSE_ID => $classe_id,
                                    Parcours::STATUT_APPRENANT_ID => (new StatutApprenantRepository())->getStatutApprenantId($eleve_id, $classe_id, $annee_scolaire_id),
                                ];
                                $model_parcours->insert($data_parcours)->execute();

                                //MISE A JOUR DU #STATUT_ELEVE#
                                // vd('#STATUT_ELEVE#');
                                // vd(StatutEleve::get_id(StatutEleve::CODE_NOUVEAU));
                                // vd(StatutEleve::get_id(StatutEleve::CODE_ANCIEN));
                                // vd($eleve);
                                // vd(is_null($eleve['statut_eleve_id']));

                                if(is_null($eleve['statut_eleve_id'])){
                                    // vd('#STATUT_ELEVE1#');
                                    Eleve::table()->update()->set('statut_eleve_id', StatutEleve::get_id(StatutEleve::CODE_NOUVEAU))->where('id', '=', $eleve['id'])->where('visibilite', 1)->execute();
                                    // vd('#STATUT_ELEVE2#');
                                }else{
                                    $statut_eleve_code = StatutEleve::table()->select('code')->where('statut_eleve.id', $eleve['statut_eleve_id'])->one()['code'];
                                    if($statut_eleve_code == StatutEleve::CODE_DEMISSINAIRE){
                                        Eleve::table()->update()->set('statut_eleve_id', StatutEleve::get_id(StatutEleve::CODE_ANCIEN))->where('id', '=', $eleve['id'])->where('visibilite', 1)->execute();
                                    }else{
                                        Eleve::table()->update()->set('statut_eleve_id', StatutEleve::get_id(StatutEleve::CODE_NOUVEAU))->where('id', '=', $eleve['id'])->where('visibilite', 1)->execute();
                                    }
                                }
                                // vd('#STATUT_ELEVE#');
                                
                            //  ##endregion INSCRIPTION PARCOURS 

                        }

                    }
                }
            if($debug)  vd('ok Pension eleve');

        //PENSION ELEVE

        //ACTIVITE

            $activites = $_POST['activites']??[];

            $items = $activites['multiplicateur']??[];
            $reduction = $activites['reduction']??[];

            $k = 0;
            $liste_activite = $activites['liste']??[];
            if(  !empty($liste_activite) && !empty($items))
                foreach($liste_activite as $activite){
                    $nom_activite = $activite['value'];
                    $code_activite = $activite['id'];
                    $montant_activite = $activite['montant'];
                    $activite_id =   Model::getId(DBTable::ACTIVITE, $code_activite);

                    $i = 0;
                    $j = 0;

                    if($debug)  $z = 0;
                    $items = is_array($items)? $items : [];
                    for ($i = 0; $i<count($items); $i++) {

                        $prev_index_month = Helpers::strFrMonth2Index($items[$i]['value']);
                        $current_index_month = $prev_index_month;

                        $isLast = ($i+1) == count($items);

                        if (!$isLast)
                            for ($j = $i+1; $j<count($items); $j++) {
                                $current_index_month = Helpers::strFrMonth2Index($items[$j]['value']);
                                $x = ($prev_index_month + 1);
                                $y = ($current_index_month + 0);

                                if ($y != $x) break;

                                $prev_index_month = $current_index_month;
                            }
                        else
                            $j = $i;

                        $offset = $j - 1 - $i;
                        $quantite = $offset + 1;
                        if($debug)  $total = count($items);
                        // echo "---- TOtal = {$total}i = $i; j = $j; --- OFFSET : $offset ---- <br/>";

                        if ($quantite < 0) break;
                        if ($offset < 0) $offset = 0;
                        $quantite = ($isLast)? 1 : $offset;
                        
                        $start_date = Helpers::getFirstDayOfMonthByStrFrMonth( $items[$i]['value'] );
                        $end_date = Helpers::getLastDayOfMonthByStrFrMonth(  Helpers::addFrMonth( $items[$i]['value'], $offset) );

                        $model_abonnement_activite = DBTable::getModel(DBTable::ABONNEMENT_ACTIVITE);
                        $code_abonnement_activite = AbonnementActivite::generateCode();

                        $data_abonnement_activite = [
                            'code' => $code_abonnement_activite,
                            'facture_id' => $facure_id,
                            'eleve_id' => $eleve_id,
                            'activite_id' => $activite_id,
                            'montant_total' => $montant_activite * $activites['montant_net'],
                            'reduction' => $activites['reduction'],
                            'date_debut' => $start_date,
                            'date_fin' => $end_date,
                        ];

                        $model_abonnement_activite->insert($data_abonnement_activite)->execute();
                        $abonnement_activite_id = Model::getId(DBTable::ABONNEMENT_ACTIVITE, $code_abonnement_activite);
                        array_push($ids_pension_activite, $abonnement_activite_id);

                        $abonnement_detail = DBTable::getModel(DBTable::ABONNEMENT_DETAIL);

                        $code_abonnement_detail = AbonnementDetail::generateCode();

                        $data_abonnment_detail = [
                            'code' => $code_abonnement_detail,
                            'abonnement_id' => $abonnement_activite_id,
                            'periode' =>  'MOIS',
                            'type_abonnement' => 'ACTIVITE',
                            'multiplicateur' => $quantite,
                            'total' =>  $activite['montant'] * $quantite,
                            'prix_unitaire' =>  $activite['montant'],
                            'date_debut' =>  $start_date,
                            'date_fin' =>  $end_date
                        ];

                        $abonnement_detail->insert($data_abonnment_detail)->execute();
                        $abonnement_detail_id = Model::getId(DBTable::ABONNEMENT_DETAIL, $code_abonnement_detail);
                        array_push($ids_pension_abonnement_detail, $abonnement_detail_id);

                        $i = $j - 1;

                        if ($isLast) break;
                        if($debug)  if ($z == 100) die('upd to 10');
                        if($debug)  $z++;
                    }

                    if($debug)  if ($k == 10) die('upd to 100');
                    if($debug)  $k++;

                }

            if($debug)  vd('ok Activité');

        //ACTIVITE

        //CANTINE

            $cantines = $_POST['cantines']??[];
            //checker les valeur par defaut de tous les élements
            $items = is_array($cantines['montant_net'])? $cantines['montant_net'] : [] ;
           
            $i = 0;
            $j = 0;
            if ($debug) $k = 0;
            for ($i = 0; $i<count($items); $i++) {

                $prev_index_month = Helpers::strFrMonth2Index($items[$i]['value']);
                $current_index_month = $prev_index_month;

                $isLast = ($i+1) == count($items);

                if (!$isLast)
                    for ($j = $i+1; $j<count($items); $j++) {
                        $current_index_month = Helpers::strFrMonth2Index($items[$j]['value']);
                        $x = ($prev_index_month + 1);
                        $y = ($current_index_month + 0);

                        if ($y != $x) break;

                        $prev_index_month = $current_index_month;
                    }
                else
                    $j = $i;

                $offset = $j - 1 - $i;
                $quantite = $offset + 1;

                if ($quantite < 0) break;
                if ($offset < 0) $offset = 0;
                $quantite = ($isLast)? 1 : $offset;
                $total = count($items);
                if ($debug) echo "---- total = {$total} i = $i; j = $j; ----- LAST : {$isLast} --- OFFSET : $offset ---- <br/>";

                $start_date = Helpers::getFirstDayOfMonthByStrFrMonth( $items[$i]['value'] );
                $end_date = Helpers::getLastDayOfMonthByStrFrMonth(  Helpers::addFrMonth( $items[$i]['value'], $offset) );

                $model_cantine = DBTable::getModel(DBTable::ABONNEMENT_CANTINE);
                $code_cantine = AbonnementCantine::generateCode();
                $data_abonnment_cantine = [
                    'code' => $code_cantine,
                    'facture_id' => $facure_id,
                    'eleve_id' => $eleve_id,
                    'montant_total' => $cantines['montant'] * $cantines['multiplicateur'] ,
                    'reduction' => $cantines['reduction'],
                    'date_debut' => $start_date,
                    'date_fin' => $end_date,
                ];

                $model_cantine->insert($data_abonnment_cantine)->execute();
                $abonnement_cantine_id = Model::getId(DBTable::ABONNEMENT_CANTINE, $code_cantine);
                array_push($ids_pension_cantine, $abonnement_cantine_id);

                $abonnement_detail = DBTable::getModel(DBTable::ABONNEMENT_DETAIL);
                $code_abonnement_detail = AbonnementDetail::generateCode();

                $data_abonnment_detail = [
                    'code' => $code_abonnement_detail,
                    'abonnement_id' => $abonnement_cantine_id,
                    'periode' =>  'MOIS',
                    'multiplicateur' => $quantite,
                    'total' =>  $cantines['montant'] * $quantite,
                    'prix_unitaire' =>  $cantines['montant'],
                    'date_debut' =>  $start_date,
                    'date_fin' =>  $end_date
                ];
                $abonnement_detail->insert($data_abonnment_detail)->execute();
                $abonnement_detail_id = Model::getId(DBTable::ABONNEMENT_DETAIL, $code_abonnement_detail);
                array_push($ids_pension_abonnement_detail, $abonnement_detail_id);
                if ($debug) $k++;

                if ($debug) if($k==10) die('KO');

                if ($isLast) break;
                $i = $j - 1;
            }
            if($debug) vd('ok Cantine');

        //CANTINE

        //AUTRES
            $autres = $_POST['autres']??[];
            $montant = $autres['montant'];
            $reduction = $autres['reduction'];

          
            if(isset($autres['type_pension']) && !( empty($montant) || $montant == "0")){
                $model_pension_eleve = DBTable::getModel(DBTable::PENSION_ELEVE);
                
                $type_pension = (isset($autres['type_pension']) && empty($type_pension))? "Autres" :$type_pension;

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
                    'motif' => $type_pension,
                    'quantite' => 1
                ];
                $model_pension_eleve->insert($data_pension_eleve_autre)->execute();
            }
        //AUTRES
        // vd('REDUCTION GROUPE FAMILIAL');

        //REDUCTION GROUPE FAMILIAL
            $groupe_familial = $_POST['groupe_familial'];
            // vd($groupe_familial);
            if(isset($groupe_familial['reduction']) && $groupe_familial['reduction'] != "0" && $groupe_familial['reduction'] != ""){
                $groupe_familial_exists = (new GroupeFamilialRepository())->groupe_familial_exists($eleve_id);
                $data_groupe_familial = [];
                $groupe_familial_id = 0;
                
                if(!$groupe_familial_exists){
                    $groupe_familial_id = (new GroupeFamilialRepository())->groupe_familial_by_eleve_id($eleve_id);
                }else{
                    $groupe_familial_code = GroupeFamilial::generateCode();
                    
                    $data_groupe_familial = [
                        'code' => $groupe_familial_code,
                        'famille' => $groupe_familial['famille'],
                    ];

                    GroupeFamilial::table()->insert($data_groupe_familial)->execute();

                    $groupe_familial_id = GroupeFamilial::get_id($groupe_familial_code);
                }

                $old_eleve_groupe_familial = []; //On ne retire jamais une personne de sa famille sans l'avoir affecté à une autre; meme s'il n'est plus de l'étanlissement
                
                // vd($groupe_familial_id);
                foreach ($groupe_familial['membres'] as $key => $eleve_code){
                    Eleve::table()->update()->set('groupe_familial_id', $groupe_familial_id)->where('code', $eleve_code)->execute();
                    // vd($eleve_code);
                }

                $reduction_groupe_familial_code = ReductionFamiliale::generateCode(); 
                ReductionFamiliale::table()->insert([
                    'code' => $reduction_groupe_familial_code,
                    'annee_scolaire_id' => $this->session->get(S::ANNEE_SCOLAIRE),
                    'groupe_familial_id' => $groupe_familial_id,
                    'eleve_id' => $eleve_id,
                    'facture_id' => $facure_id,
                    'montant' => $groupe_familial['reduction']
                ])->execute();

                $reduction_groupe_familial_id = ReductionFamiliale::get_id($reduction_groupe_familial_code);

                foreach ($groupe_familial['membres'] as $eleve_code){
                    GroupeReductionFamiliale::table()->insert([
                        'code' => GroupeReductionFamiliale::generateCode(),
                        'eleve_id' => Eleve::get_id($eleve_code),
                        'reduction_familiale_id' => $reduction_groupe_familial_id,
                    ])->execute();
                }

            }

        //REDUCTION GROUPE FAMILIAL

        // vd('REDUCTION GROUPE FAMILIAL');

        if(isset($_SESSION[S::DATA_TRANSPORT])){
            $_SESSION[S::DATA_TRANSPORT] = null;
        }
        // vd('REDUCTION GROUPE FAMILIAL');

        //vd($result_pension_eleve , $result_abonnement_detail , $result_abonnement_cantine , $result_facture);
        // $result = $result_pension_eleve && $result_abonnement_detail && $result_abonnement_cantine && $result_facture ;
        $result = true;
        // vd('REDUCTION GROUPE FAMILIAL');

        if($result){
            // echo Helpers::toJSON('Versement enregistré avec sucess', TRUE);
            $this->sendResponseAndExit(Helpers::toJSON('Versement enregistré avec sucess'));
        }else{
            $this->sendResponseAndExit(Helpers::toJSON('Erreur d\'enregistement à la base de données !!!', TRUE), false, 400, 'BD error : data '. $code);
        }

    }

    public function impriner_facture_multiple(){

        $data = $_POST;

        //encodage des tables qui seront transferer dans une variable de session avec pour clé la reference de la facture du versement
        $data['pension_classe'] = json_decode($data['pension_classe'], true);
        $data['cantines'] = json_decode($data['cantines'], true);
        $data['autres'] = json_decode($data['autres'], true);
        $data['activites'] = json_decode($data['activites'], true);

        //Acces au données de la facture par session et dans les cookies()
        $_SESSION[$data['reference']] = $data;
        // setcookie($data['reference'], $data, TIME_COOKIE_LONG, URL::link('facture_cantine'));

        $this->renderPDF('reports.facture_multiple', compact('data'), 'facture_versement' );


        $this->renderPDF('reports.versement', compact('data'), 'facture_versement' );

    }

}
