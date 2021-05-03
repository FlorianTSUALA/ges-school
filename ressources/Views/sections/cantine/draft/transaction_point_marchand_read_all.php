<?php require_once(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "ressources" . DIRECTORY_SEPARATOR ."config". DIRECTORY_SEPARATOR ."kgs_invariants.php"); ?>
<?php require_once(KGS_COMPONENTS_DIRECTORY . DIRECTORY_SEPARATOR ."kgs_magic_tools.php"); ?>
<?php require_once(KGS_CONTROLLERS_PROPRIETAIRE_DIRECTORY . DIRECTORY_SEPARATOR ."datatableModel.php"); ?>
<?php require_once(".." . DIRECTORY_SEPARATOR ."api_common.php"); ?>


<?php
    include_get();

  
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');


    require_once(KGS_MODELS_DIRECTORY . DIRECTORY_SEPARATOR . Model::DB_CONNEXION);
    require_once(KGS_MODELS_DIRECTORY . DIRECTORY_SEPARATOR . Model::DB_FIND);

    $table_transaction_assurance = getTableName(Table::TRANSACTION_ASSURANCE);
    $table_transaction_commerciale =   getTableName(Table::TRANSACTION_COMMERCIALE);
    $table_transaction_education =   getTableName(Table::TRANSACTION_EDUCATION);
    $table_transaction_financiere =   getTableName(Table::TRANSACTION_FINANCIERE);
    $table_type_operation_point_marchand =   getTableName(Table::TYPE_OPERATION_POINT_MARCHAND);
    $table_point_marchand =   getTableName(Table::POINT_MARCHAND);
    $table_service =   getTableName(Table::SERVICE);
    $table_caisse =   getTableName(Table::CAISSE);
    $table_utilisateur =   getTableName(Table::UTILISATEUR);
    $table_compte_abonne =   getTableName(Table::COMPTE_ABONNE);
    $table_journal_transaction =   getTableName(Table::JOURNAL_TRANSACTION);
    $table_type_paiement = getTableName(Table::TYPE_PAIEMENT);

    $_PUT = array();
    parse_str(file_get_contents('php://input'), $_PUT);

    $username = LOG::HACKER_MOBILE;
    $account = LOG::ACCOUNT_MOBILE_SYSTEM;

    $actionlog = "";

    $compte_point_marchand_id = stringProtected(isset($_PUT[PointMarchand::COMPTE_ID])? $_PUT[PointMarchand::COMPTE_ID] : (isset($_GET[PointMarchand::COMPTE_ID])? $_GET[PointMarchand::COMPTE_ID] : -1));
    $result_with_statut = stringProtected(isset($_PUT[API::TAG_STATUS])? $_PUT[API::TAG_STATUS] : (isset($_GET[API::TAG_STATUS])? $_GET[API::TAG_STATUS] : -1));

    $limit = stringProtected(isset($_PUT[API::TAG_LIMIT])? $_PUT[API::TAG_LIMIT] : (isset($_GET[API::TAG_LIMIT])? $_GET[API::TAG_LIMIT] : -1));

    $start_date = stringProtected(isset($_PUT[API::TAG_START_DATE])? $_PUT[API::TAG_START_DATE] : (isset($_GET[API::TAG_START_DATE])? $_GET[API::TAG_START_DATE] : -1));
    $end_date = stringProtected(isset($_PUT[API::TAG_END_DATE])? $_PUT[API::TAG_END_DATE] : (isset($_GET[API::TAG_END_DATE])? $_GET[API::TAG_END_DATE] : -1));
    
    $order_by = stringProtected(isset($_PUT[API::TAG_ORDER_BY])? $_PUT[API::TAG_ORDER_BY] : (isset($_GET[API::TAG_ORDER_BY])? $_GET[API::TAG_ORDER_BY] : -1));

    $clause = array();
    array_push($clause, makeClause(PointMarchand::COMPTE_ID, Query::OPERATOR_EQUAL, $compte_point_marchand_id));
    array_push($clause, makeClause(PointMarchand::VISIBILITE, Query::OPERATOR_EQUAL, UN));
    


    $point_marchand = getAllByFilter($table_point_marchand,  $clause, SELECT_ALL);
    if($point_marchand)
    {
        $transactions;

        $select_list = [];
        $clause = array();
        if($start_date != -1 && $end_date != -1){
            array_push($clause, makeClause(Transaction::DATE_PAIEMENT, Query::OPERATOR_BETWEEN,
                [Query::CLAUSE_LEFT => $start_date, Query::CLAUSE_RIGHT => $end_date]));
        }
        $limit  = ($limit == -1)? "" : $limit;
        switch ($point_marchand->service_code)
        {
            case Service::CODE_ASSURANCE:
            {
                $joins = [];

                //TABLE TOPM
                    $join[JOIN_TYPE] = JOIN_LEFT;
                    $join[JOIN_TABLE] = $table_type_operation_point_marchand;
                    $join[JOIN_CLAUSE] = [
                                            $table_transaction_assurance.".".TransactionAssurance::TYPE_OPERATION_POINT_MARCHAND_ID
                                            => $table_type_operation_point_marchand.".".TypeOperationPointMarchand::ID
                                         ];


                    array_push($joins, $join);
                    $join[JOIN_TABLE] = $table_compte_abonne;
                    $join[JOIN_CLAUSE] = 
                                        [
                                            $table_transaction_assurance .".".TransactionAssurance::COMPTE_ABONNE_ID
                                            => $table_compte_abonne.".". CompteAbonne::ID
                                        ];
                    array_push($joins, $join);


                //$select_list += [$table_transaction_assurance.".".TransactionAssurance::CODE => DatatableAtribute::TRAN_CODE ];
                $select_list += [$table_compte_abonne.".".CompteAbonne::NOM_COMPLET => DatatableAtribute::CODE_TRAN_NOM_DEPOSANT ];
                $select_list += [$table_transaction_assurance.".".TransactionAssurance::DATE_PAIEMENT => DatatableAtribute::CODE_TRAN_DATE ];
                $select_list += [$table_transaction_assurance.".".TransactionAssurance::MONTANT => DatatableAtribute::CODE_TRAN_MONTANT ];
                $select_list += [$table_transaction_assurance.".".TransactionAssurance::MOTIF => DatatableAtribute::CODE_TRAN_MOTIF ];
                $select_list += [$table_transaction_assurance.".".TransactionAssurance::REMISE => DatatableAtribute::CODE_TRAN_REMISE ];
                $select_list += [$table_transaction_assurance.".".TransactionAssurance::REFERENCE => DatatableAtribute::CODE_TRAN_REF ];
                //$select_list += [$table_transaction_assurance.".".TransactionAssurance::TELEPHONE => DatatableAtribute::TRAN_TEL ];

                //$select_list += [$table_transaction_assurance.".".TransactionAssurance::TELEPHONE => DatatableAtribute::TRAN_TEL ];
                $select_list += [$table_transaction_assurance.".".TransactionAssurance::NUMERO_POLICE_ASSURANCE => DatatableAtribute::CODE_TRAN_NUM_POL_ASS ];
                //$select_list += [$table_type_contrat_assurance.".".TypeContratAssurance::LIBELLE => DatatableAtribute:: TRAN_TYPE_CONTRAT_ASS];
                $select_list += [$table_type_operation_point_marchand.".".TypeOperationPointMarchand::LIBELLE => DatatableAtribute::CODE_TRAN_MOTIF];
                //$select_list += [$table_type_operation_point_marchand.".".TypeOperationPointMarchand::CODE => DatatableAtribute::TRAN_PM_COD ];
                
                array_push($clause, makeClause($table_transaction_assurance.".".TransactionAssurance::POINT_MARCHAND_ID, Query::OPERATOR_EQUAL, $point_marchand->id));
                array_push($clause, makeClause($table_transaction_assurance.".".TransactionAssurance::VISIBILITE, Query::OPERATOR_EQUAL, UN));
                array_push($clause, makeClause($table_transaction_assurance.".".TransactionAssurance::STATUT, Query::OPERATOR_EQUAL, UN));

                $transactions = getAllByMultiOuterJoin(
                    $table_transaction_assurance,
                    $joins,
                    $clause,
                    $select_list, "", $table_transaction_assurance.".".TransactionAssurance::DATE_PAIEMENT . " DESC", $limit, false
                );
            }
            break;

            case Service::CODE_COMMERCIAL:
            {

                $joins = [];

                //TABLE TOPM
                    $join[JOIN_TYPE] = JOIN_LEFT;
                    $join[JOIN_TABLE] = $table_type_operation_point_marchand;
                    $join[JOIN_CLAUSE] = [
                                            $table_transaction_commerciale.".".TransactionCommerciale::TYPE_OPERATION_POINT_MARCHAND_ID
                                            => $table_type_operation_point_marchand.".".TypeOperationPointMarchand::ID
                                         ];

                                        
                    array_push($joins, $join);

                //BUILD IN
                    //$select_list += [$table_transaction_commerciale.".".TransactionCommerciale::CODE => DatatableAtribute::TRAN_CODE ];
                    //$select_list += [$table_transaction_commerciale.".".TransactionCommerciale::CODE => DatatableAtribute::TRAN_CODE ];
                    $select_list += [$table_transaction_commerciale.".".TransactionCommerciale::DATE_PAIEMENT => DatatableAtribute::CODE_TRAN_DATE ];
                    $select_list += [$table_transaction_commerciale.".".TransactionCommerciale::MONTANT => DatatableAtribute::CODE_TRAN_MONTANT ];
                   // $select_list += [$table_transaction_commerciale.".".TransactionCommerciale::MOTIF => DatatableAtribute::TRAN_NUM_POL_ASS ];
                    $select_list +=  [$table_transaction_commerciale.".".TransactionCommerciale::REMISE => DatatableAtribute::CODE_TRAN_REMISE ];
                    $select_list += [$table_transaction_commerciale.".".TransactionCommerciale::REFERENCE => DatatableAtribute::CODE_TRAN_REF ];
                    //$select_list += [$table_transaction_commerciale.".".TransactionCommerciale::TELEPHONE => DatatableAtribute::TRAN_TEL ];

                    $select_list += [$table_type_operation_point_marchand.".".TypeOperationPointMarchand::LIBELLE  => DatatableAtribute::CODE_TRAN_MOTIF ];
                    //$select_list += [$table_type_operation_point_marchand.".".TypeOperationPointMarchand::CODE  => DatatableAtribute::TRAN_PM_COD ];
                    //$select_list += [$table_caisse.".".Caisse::CODE  => DatatableAtribute::TRAN_CAISSE_COD ];
                    //$select_list += [$table_caisse.".".Caisse::LIBELLE  => DatatableAtribute::TRAN_CAISSE_LIB ];

                //getAllByMultiOuterJoin( $table, $joins, $where_clause = [], $select_list = "*", $filter = "", $order = "", $limit)

               
                array_push($clause, makeClause($table_transaction_commerciale.".".TransactionCommerciale::POINT_MARCHAND_ID, Query::OPERATOR_EQUAL, $point_marchand->id));
                array_push($clause, makeClause($table_transaction_commerciale.".".TransactionCommerciale::VISIBILITE, Query::OPERATOR_EQUAL, UN));
                array_push($clause, makeClause($table_transaction_commerciale.".".TransactionCommerciale::STATUT, Query::OPERATOR_EQUAL, UN));

                $transactions = getAllByMultiOuterJoin(
                    $table_transaction_commerciale,
                    $joins,
                    $clause,
                    $select_list, "", $table_transaction_commerciale.".".TransactionCommerciale::DATE_PAIEMENT . " DESC", $limit, false
                );

               // $result =  _traiter($transactions, JournalTransaction::TRANSACTION_COMMERCIALE_ID);
            }
            break;

            case Service::CODE_EDUCATION:
            {
                $joins = [];

                //TABLE TOPM
                    $join[JOIN_TYPE] = JOIN_LEFT;
                    $join[JOIN_TABLE] = $table_type_operation_point_marchand;
                    $join[JOIN_CLAUSE] = [
                                            $table_transaction_education.".".TransactionCommerciale::TYPE_OPERATION_POINT_MARCHAND_ID
                                            => $table_type_operation_point_marchand.".".TypeOperationPointMarchand::ID
                                         ];
                    array_push($joins, $join);

                //$select_list += [$table_transaction_education.".".TransactionEducation::CODE => DatatableAtribute::TRAN_CODE ];
                $select_list += [$table_transaction_education.".".TransactionEducation::DATE_PAIEMENT => DatatableAtribute::CODE_TRAN_DATE ];
                $select_list += [$table_transaction_education.".".TransactionEducation::MONTANT => DatatableAtribute::CODE_TRAN_MONTANT ];
                $select_list += [$table_transaction_education.".".TransactionEducation::MOTIF => DatatableAtribute::CODE_TRAN_MOTIF ];
                $select_list += [$table_transaction_education.".".TransactionEducation::REMISE => DatatableAtribute::CODE_TRAN_REMISE ];
                $select_list += [$table_transaction_education.".".TransactionEducation::REFERENCE => DatatableAtribute::CODE_TRAN_REF ];
                //$select_list += [$table_transaction_education.".".TransactionEducation::TELEPHONE => DatatableAtribute::TRAN_TEL ];

                $select_list += [ $table_transaction_education.".".TransactionEducation::NOM_ELEVE ];
                $select_list += [ $table_transaction_education.".".TransactionEducation::NOMTUTEUR ];
                $select_list += [ $table_transaction_education.".".TransactionEducation::PRENOM_ELEVE ];
                $select_list += [ $table_transaction_education.".".TransactionEducation::PRENOM_TUTEUR ];
                $select_list += [ $table_transaction_education.".".TransactionEducation::PERIODE ];
                $select_list += [ $table_transaction_education.".".TransactionEducation::ANNEE_ACADEMIQUE ];
                $select_list += [ $table_transaction_education.".".TransactionEducation::MATRICULE ];
                $select_list += [ $table_transaction_education.".".TransactionEducation::CLASSE ];
                $select_list += [ $table_type_operation_point_marchand.".".TypeOperationPointMarchand::LIBELLE  => DatatableAtribute::CODE_TRAN_MOTIF ];

                array_push($clause, makeClause($table_transaction_education.".".TransactionEducation::POINT_MARCHAND_ID, Query::OPERATOR_EQUAL, $point_marchand->id));
                array_push($clause, makeClause($table_transaction_education.".".TransactionEducation::VISIBILITE, Query::OPERATOR_EQUAL, UN));
                array_push($clause, makeClause($table_transaction_education.".".TransactionEducation::STATUT, Query::OPERATOR_EQUAL, UN));
                
                $transactions = getAllByMultiOuterJoin(
                    $table_transaction_education,
                    $joins,
                    $clause,
                    $select_list, "", $table_transaction_education.".".TransactionEducation::DATE_PAIEMENT . " DESC", $limit, false
                );
            }
            break;

            case Service::CODE_FINANCE:
            {
                $joins = [];
                //TABLE TOPM
                $join[JOIN_TYPE] = JOIN_LEFT;
                $join[JOIN_TABLE] = $table_type_operation_point_marchand;
                $join[JOIN_CLAUSE] = 
                                    [
                                        $table_transaction_financiere .".".TransactionCommerciale::TYPE_OPERATION_POINT_MARCHAND_ID
                                        => $table_type_operation_point_marchand.".".TypeOperationPointMarchand::ID
                                    ];

                array_push($joins, $join);
                $join[JOIN_TABLE] = $table_compte_abonne;
                $join[JOIN_CLAUSE] = 
                                    [
                                        $table_transaction_financiere .".".TransactionCommerciale::COMPTE_ABONNE_ID
                                        => $table_compte_abonne.".". CompteAbonne::ID
                                    ];

                array_push($joins, $join);

                //$select_list += [$table_transaction_financiere.".".TransactionFinanciere::CODE => DatatableAtribute::TRAN_CODE ];
                $select_list += [$table_compte_abonne.".".CompteAbonne::NOM_COMPLET => DatatableAtribute::CODE_TRAN_NOM_DEPOSANT ];
                $select_list += [$table_transaction_financiere.".".TransactionFinanciere::DATE_PAIEMENT => DatatableAtribute::CODE_TRAN_DATE ];
                $select_list += [$table_transaction_financiere.".".TransactionFinanciere::MONTANT => DatatableAtribute::CODE_TRAN_MONTANT ];
                //---$select_list += [$table_transaction_financiere.".".TransactionFinanciere::MONTANT => DatatableAtribute::TRAN_FRAIS_TTC ];
                //$select_list += [$table_transaction_financiere.".".TransactionFinanciere::MOTIF => DatatableAtribute::TRAN_MOTIF ];
                $select_list += [$table_transaction_financiere.".".TransactionFinanciere::REMISE => DatatableAtribute::CODE_TRAN_REMISE ];
                $select_list += [$table_transaction_financiere.".".TransactionFinanciere::REFERENCE => DatatableAtribute::CODE_TRAN_REF ];
                //$select_list += [$table_transaction_financiere.".".TransactionFinanciere::TELEPHONE => DatatableAtribute::TRAN_TEL ];
                $select_list += [ $table_transaction_financiere.".".TransactionFinanciere::NUMERO_COMPTE => DatatableAtribute::CODE_TRAN_NUM_COMPTE];
    
                $select_list += [ $table_transaction_financiere.".".TransactionFinanciere::ORIGINE_FONDS => DatatableAtribute::CODE_TRAN_ORIGINE_FOND];

                //---$select_list += [ $table_transaction_financiere.".".TransactionFinanciere::NUMERO_COMPTE => DatatableAtribute::TRAN_NUM_COMPTE];
                //$select_list += [ $table_transaction_financiere.".".TransactionFinanciere::INTITULE_COMPTE => TransactionFinanciere::INTITULE_COMPTE];
                //$select_list += [ $table_type_compte_finance.".".TypeCompteFinance::LIBELLE ];
                //$select_list += [ $table_type_operation_point_marchand.".".TypeOperationPointMarchand::LIBELLE ];
                $select_list += [ $table_type_operation_point_marchand.".".TypeOperationPointMarchand::LIBELLE => DatatableAtribute::CODE_TRAN_MOTIF ];
                
               
                array_push($clause, makeClause($table_transaction_financiere.".".TransactionFinanciere::POINT_MARCHAND_ID, Query::OPERATOR_EQUAL, $point_marchand->id));
                array_push($clause, makeClause($table_transaction_financiere.".".TransactionFinanciere::VISIBILITE, Query::OPERATOR_EQUAL, UN));
                array_push($clause, makeClause($table_transaction_financiere.".".TransactionFinanciere::STATUT, Query::OPERATOR_EQUAL, UN));
                

                $transactions = getAllByMultiOuterJoin(
                    $table_transaction_financiere,
                    $joins,
                    $clause,
                    $select_list, "", $table_transaction_financiere.".".TransactionFinanciere::DATE_PAIEMENT . " DESC", $limit, false
                );
                //var_dump($transactions);
                //die();
            }
            break;

            default:
                setKGSLog($account, $username, "Une erreur est survenue dans l'enregistrement des paiements.");
        }

        function _traiter($_data, $id = 0)
        {
        }

        $account = TITRE_ABONNE;
        $compte_id = $compte_point_marchand_id;


        $clause = array();
        array_push($clause, makeClause(Utilisateur::COMPTE_ID, Query::OPERATOR_EQUAL, $compte_id));
        array_push($clause, makeClause(Utilisateur::VISIBILITE, Query::OPERATOR_EQUAL, UN));




        $username = getValueWithPrecision($table_utilisateur, $clause, Utilisateur::NOM);
        $actionlog = " consulte l'historique de ces transactions.";

        if(empty($transactions))
        {
            $results[API::TAG_DATATABLE_DR] = API::TAG_DATATABLE_VALUE_DR;
            $results[API::TAG_DATATABLE_RT] = 0;
            $results[API::TAG_DATATABLE_RF] = 0;
            $results[API::TAG_STATUS] = API::TAG_SUCCESS;
            $results[API::TAG_DATA] = $transactions;
            echo json_encode($results, JSON_PRETTY_PRINT);
        }
        else
        {
            $results[API::TAG_DATA] = $transactions;
            $results[API::TAG_STATUS] = API::TAG_SUCCESS;
            $results[API::TAG_DATATABLE_DR] = API::TAG_DATATABLE_VALUE_DR;
            $results[API::TAG_DATATABLE_RT] = count($transactions);
            $results[API::TAG_DATATABLE_RF] = count($transactions);
            $results[API::TAG_DATA] = $transactions;
            echo json_encode($results, JSON_PRETTY_PRINT);
        }
    }
    else
    {
        $actionlog = " a eu une erreur lors de la consultation de ses transactions.";
        $results[API::TAG_DATATABLE_DR] = API::TAG_DATATABLE_VALUE_DR;
        $results[API::TAG_DATATABLE_RT] = 0;
        $results[API::TAG_DATATABLE_RF] = 0;
        $results[API::TAG_DATA] = $transactions;
        $results[API::TAG_STATUS] = API::TAG_ERROR;

        echo json_encode(array(API::TAG_RESULT => $results), JSON_PRETTY_PRINT);

    }
    setKGSLog($account, $username, $actionlog);
?>