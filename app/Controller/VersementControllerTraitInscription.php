<?php

namespace App\Controller;

use App\Helpers\S;
use Core\Model\Model;
use App\Model\DBTable;
use App\Model\Facture;
use App\Helpers\Helpers;
use Core\Session\Request;
use App\Model\PensionEleve;
use function Core\Helper\dd;
use function Core\Helper\vd;
use App\Model\TypePension;
use App\Repository\EleveRepository;
use App\Repository\AnneeScolaireRepository;
use ClanCats\Hydrahon\Query\Expression as Ex;

trait VersementControllerTraitInscription
{


    /*
    *  **   * Renvoie le formulaire de inscription
    */
    public function index_inscription()
    {
        $route = "versement_inscription";
        $title = "Gestion des frais d Inscription";
        $this->app->setTitle($this->title_page);
        $base_route = $this->base_route;
        $create_title = $this->create_title;
        $view_title = $this->view_title;
        $update_title = $this->update_title;
        $delete_title = $this->delete_title;
        $msg_delete = $this->msg_delete;

        $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
        
        $eleves = (new EleveRepository() )->getEleve();

        $classes = DBTable::getModel('classe')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();

        $annee_scolaires =  (new AnneeScolaireRepository())->getAll();

        $statut_apprenants = DBTable::getModel('statut_apprenant')
                            ->select(['code'=>'id', 'libelle' => 'libelle'])
                            ->where('visibilite', '=', 1)
                            ->orderBy('date_creation', 'desc')
                            ->get();

        $pension_classe = DBTable::getModel('pension_classe')
            ->select(
                [
                    'classe.code' => 'classe_id',
                    'classe.libelle' => 'classe_libelle',
                    'type_pension.code' => 'type_pension',
                    'pension_classe.code' => 'id',
                    'pension_classe.montant' => 'montant',
                    // 'pension_classe.est_mensuel' => 'est_mensuel',
                    // 'pension_classe.mensualite' => 'mensualite',
                    'pension_classe.libelle' => 'libelle'
                ]
            )
            ->join('classe', 'classe.id', '=', 'pension_classe.classe_id')
            ->join('type_pension', 'type_pension.id', '=', 'pension_classe.type_pension_id')
            ->where('pension_classe.visibilite', '=', 1)
            ->where('type_pension.code', '=', TypePension::INSCRIPTION_CODE)
            ->where('type_pension.visibilite', '=', 1)
            ->get();
        
        
        $type_paiements = DBTable::getModel('type_paiement')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();

        // $pension_classe = json_encode($pension_classe);
        // dd($pension_classe);

        $type_pensions = DBTable::getModel('type_pension')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get();
       
        $this->render('sections.versement.inscription.ajout.versement_inscription', compact(
            //versement/inscription file
            //'abonnement_cantine',
            //'class_name', 'base_route', 'title', 'create_title', 'view_title', 'update_title', 'delete_title', 'msg_delete',
            'route',
            'title',
            'classes',
            'statut_apprenants',
            'annee_scolaires',
            'eleves',
            'pension_classe',
            'type_pensions',
            'type_paiements'
        ));
    }
    
    /*
    *  Enregistrement d'un frais de pension d'une inscription
    */
    public function save_inscription($code)
    {
        $debug = false;
        $eleve_id = DBTable::getModel('eleve')->select()->find($code, 'code')['id'];
        $classe_id = DBTable::getModel('classe')->select()->find(Request::getSecParam('classe_id', ''), 'code')['id'];
        $montant_paye = Request::getSecParam('montant_paye', 0);
        
        $nom_eleve =  Request::getSecParam('eleve', 0);

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
                'gestionnaire' => $this->session->get(S::PERS_NOM) . " " . $this->session->get(S::PERS_PRENOM),
                'montant' => $montant_paye,
                'reduction' => $reduction,
                'date_facture' => $date_facture,
                'date_paiement' => $date_paiement,
                'eleve_id' => $eleve_id,
                'annee_scolaire_id' => $annee_scolaire_id,
                'description' => '',
            ];
            $model_facture->insert($data_facture)->execute();
            $facure_id = Model::getId(DBTable::FACTURE, $code_facture);
        //Facture
        if($debug)   vd('ok Facture');



        //PENSION ELEVE
            {
                $motif = Request::getSecParam('motif');
                $quantite = 1;
                $montant = $montant_paye;
                $type_pension_code =  Request::getSecParam('type_pension_id');
                $pension_classe_code = Request::getSecParam('pension_classe_id');

                $type_pension_id = Model::getId(DBTable::TYPE_PENSION, $type_pension_code);
                $pension_classe_id = Model::getId(DBTable::PENSION_CLASSE, $pension_classe_code);

                $model_pension_eleve = PensionEleve::table();
                $code_pension_eleve = PensionEleve::generateCode();

                $data_pension_eleve_inscription = [
                    'code' => $code_pension_eleve,
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
                $model_pension_eleve->insert($data_pension_eleve_inscription)->execute();
            }
            if($debug)  vd('ok Pension eleve');

        //PENSION ELEVE

        $result = true;
        if($result){
            $this->sendResponseAndExit(Helpers::toJSON('Versement enregistré avec sucess', TRUE));
        }else{
            $this->sendResponseAndExit(Helpers::toJSON('Erreur d\'enregistement à la base de données !!!', TRUE), false, 400, 'BD error : data '. $code);
        }

    }

    
    public function impriner_facture_inscription(){

        $data = $_POST;

        //encodage des tables qui seront transferer dans une variable de session avec pour clé la reference de la facture du versement
        $data['pension_classe'] = json_decode($data['pension_classe'], true);
        $data['cantines'] = json_decode($data['cantines'], true);
        $data['autres'] = json_decode($data['autres'], true);
        $data['activites'] = json_decode($data['activites'], true);

        //Acces au données de la facture par session et dans les cookies()
        $_SESSION[$data['reference']] = $data;
        // setcookie($data['reference'], $data, TIME_COOKIE_LONG, URL::link('facture_cantine'));

        $this->renderPDF('reports.facture_inscription', compact('data'), 'facture_versement' );

    }

}
