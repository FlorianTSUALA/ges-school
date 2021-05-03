
        //Enregistrement des payements de cantines
        $abonnement_resto = DBTable::getModel('abonnement_cantine');
        foreach ($data_pension as $item) {
            $data = [];
            $pension_classe_id = Model::getId('pension_classe', $item['pension_classe_code']);
            $type_pension_id = Model::getId('type_pension', $item['type_pension_code']);
          
            $multiplicateur = $item['multiplicateur'];
            $quantite = $item['recapitulatif'];
            $montant = $item['montant'];
            $mensualite = $item['mensualite'];
            $est_mensuel = $item['est_mensuel'];

            $data['reduction'] = $reduction;
            $data['code'] = Model::generateCode();
            $data['type_pension_id'] = $type_pension_id;
            $data['classe_id'] = $classe_id;

            $data['type_paiement_id'] = $type_paiement_id;
            
            if (isset($multiplicateur) && is_array($multiplicateur)) {
                foreach ($multiplicateur as $tranche) {
                    $data['tranche_scolaire_id'] = Model::getId('tranche_scolaire', $tranche['id']);
                    $data['montant'] = $mensualite;

                    try {
                        var_dump($data);
                        $result = $pension_eleve->insert($data)->execute();
                    } catch (Exception $ex) {
                    }
                }
            } else {
                $data['tranche_scolaire_id'] = null;
                try {
                    var_dump($data);
                    $result = $pension_eleve->insert($data)->execute();
                } catch (Exception $ex) {
                }
            }
        }



        //Enregistrement despayements des frais de scolarité
        foreach ($data_pension as $item) {
            $data = [];
            $state = $item['state'];
            // var_dump($state);
            if ($state == 'true') {
                // var_dump( $item);
                // die();
                $pension_classe_id = Model::getId('pension_classe', $item['pension_classe_code']);
                $type_pension_id = Model::getId('type_pension', $item['type_pension_code']);
                // $type_pension = $item['type_pension_code'];
                $multiplicateur = $item['multiplicateur'];
                $quantite = $item['recapitulatif'];
                $montant = $item['montant'];
                $mensualite = $item['mensualite'];
                $est_mensuel = $item['est_mensuel'];

                $data['reduction'] = $reduction;
                $data['date_paiement'] = $date_paiement;
                $data['quantite'] = $quantite;
                $data['libelle'] = $reference;
                $data['motif'] = $motif;
                $data['reste'] = $reste;
                $data['autres'] = $autre;
                $data['montant'] = $montant;
                $data['code'] = Model::generateCode();
                $data['type_pension_id'] = $type_pension_id;
                $data['classe_id'] = $classe_id;
                $data['pension_classe_id'] = $pension_classe_id;
                $data['eleve_id'] = $eleve_id;
                // $data['parcours_id'] = $parcours_id;

                $data['type_paiement_id'] = $type_paiement_id;
                $pension_eleve = DBTable::getModel('pension_eleve');
                if (isset($multiplicateur) && is_array($multiplicateur)) {
                    foreach ($multiplicateur as $tranche) {
                        $data['tranche_scolaire_id'] = Model::getId('tranche_scolaire', $tranche['id']);
                        $data['montant'] = $mensualite;

                        try {
                            var_dump($data);
                            $result = $pension_eleve->insert($data)->execute();
                        } catch (Exception $ex) {
                        }
                    }
                } else {
                    $data['tranche_scolaire_id'] = null;
                    try {
                        var_dump($data);
                        $result = $pension_eleve->insert($data)->execute();
                    } catch (Exception $ex) {
                    }
                }
                die();
                //var_dump($result);
            }
        }
