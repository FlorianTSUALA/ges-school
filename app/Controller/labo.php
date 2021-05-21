<?php

namespace App\Controller;

use App\Model\Model;
use App\Model\DBTable;
use Core\Session\Request;
use App\Model\Facture;
use App\Model\AbonnementCantine;
use App\Model\Periode;
use App\Helpers\HTMLHelpers;
    
    public function save($code){
        $montant_paye = Request::getSecParam('montant_total', 0);
        $nom_eleve = Request::getSecParam('nom_eleve', '------/|\--/|\--/|\------');
        $reduction = Request::getSecParam('reduction', 0);
        $date_facture = date('Y-m-d');
        $reference = Request::getSecParam('reference', 0);
        $type_paiement_id = Model::getId(DBTable::TYPE_PAIEMENT, Request::getSecParam('type_paiement_id', ''));

        // Facture
        $model_facture = DBTable::getModel(DBTable::FACTURE);
        $code_facture = Facture::generateCode();
        $data_facture = [
            'code': => $code_facture,
            'type_paiement_id' => $type_paiement_id,
            'libelle' => 'Facture versement',
            'reference' => $reference,
            'beneficiare' => $nom_eleve,
            'gestionnaire' => 'Secretaire',
            'montant' => $montant_paye,
            'reduction' => $reduction,
            'date_facture' => $date_facture,
            'description' => '',
        ];
        $model_facture->insert($data_facture)->execute();
        $facture_id = Model::getId(DBTable::FACTURE, $code_facture);
        // Facture

        $model = DBTable::getModel(DBTable::ABONNEMENT_ACTIVITE);
        $code_activite = AbonnementActivite::generateCode();

        $eleve_id = Model::getId(DBTable::ELEVE, Request::getSecParam('eleve_id', ''));
        $data_abonnement = [
            'code' => $code_activite,
            'montant_total' => $montant_paye,
            'reduction' => $reduction,
            'eleve_id' => $eleve_id,
            'facture_id' => $facture_id,
            'date_paiement' => Request::getSecParam('date_paiement', '');
            'date_debut' => Request::getSecParam('date_fin', '');
        ];

        $model->insert($data_abonnement);

        $abonnement_detail = DBTable::getModel(DBTable:: ABONNEMENT_DETAIL);
        $items = $_POST['activite']['data'];
        $abonnement_activite_id = Model::getId(DBTable::ABONNEMENT_CANTINE, $code_cantine);
        $dayCount = 0;

        $start_day = Request::getSecParam('date_debut', '');
        $end_day = Request::getSecParam('date_debut', '');

        foreach ($items as $item) {
            # code...
            $dayCount = Periode::getDayCount($item['periode']) * $item['duree'] - 1;
            $end_day = Helpers::addDays($start_day, $dayCount);

            $data_abonnement_detail = [
                'code' => AbonnementDetail::generateCode(),
                'abonnement_id' => $item['periode'],
                'periode' => $item['periode'],
                'multiplicateur' => $item['duree'],
                'total' => $item['sous_total'],
                'prix_unitaire' => $item['prix_unitaire'],
                'date_debut' => $start_day,
                'date_fin' => $end_day
            ];

            $start_day = Helpers::addDays($end_day, 1);

            $abonnement_detail->insert($data_abonnement_detail)->execute();

        }

        if(isset($abonnement_activite_id)){
            $this->sendRespondAndExit(Helper::toJSON('Abonnement enregistré avec succès'));
        }else{
            $this->sendResponseAndExit(Helpers::toJSON('Erreur d\'enregistrement'))
        }

    }
?>