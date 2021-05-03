<?php

namespace Core\Table\SQLTraits;

use PDO;
use Core\Invariant\Query;

trait Find {
    
    /**
	 * Récupère un élément selon la table
	 * 
	 * @param string $id ID de l'élément à récupérer
	 * @return object Objet du type de la table appelée
	 */
	public function find_default(string $id) {
		return $this->query('SELECT * FROM ' . $this->table . ' WHERE id=?', array($id), true);
    }

    public function find_with_condition(string $field, string $value) {
		return $this->query('SELECT * FROM ' . $this->table . ' WHERE '.$field.'=?', array($value), true);
    }
    
    public function findAll(string $field, string $value) {
		return $this->query('SELECT * FROM ' . $this->table . ' WHERE '.$field.'=?', array($value), false);
    }
    
    /*
        $table = getTableName(Table::COMPTE);
        $clause = array();
        array_push($clause,
            array(
                Query::CLAUSE_LEFT => Compte::LOGIN,
                Query::OPERATOR  => Query::OPERATOR_EQUAL,
                Query::CLAUSE_RIGHT => "lemba",
                Query::CONNECTOR => Query::CONNECTOR_AND
            ),
            array(
                Query::CLAUSE_LEFT => Compte::EMAIL,
                Query::OPERATOR  => Query::OPERATOR_EQUAL,
                Query::CLAUSE_RIGHT => "bobiegran@yahoo.fr",
                Query::CONNECTOR => Query::CONNECTOR_AND
            ),
            array(
                Query::CLAUSE_LEFT => Compte::TELEPHONE,
                Query::OPERATOR  => Query::OPERATOR_EQUAL,
                Query::CLAUSE_RIGHT => "66679397"
            )
        );

        $reference = array(
            Compte::ID => 1,
            Compte::TELEPHONE => "66679397",
            Compte::EMAIL => "bobiegran@yahoo.fr"
        );

        $exist = existingValueExcept($table, $clause, $reference);
        var_dump($exist); // THE RESULT WAS TRUE BECAUSE LOGIN NAME IS USE BY ANOTHER USER_ID {2}
    */
    function existingValueExcept($table,  $clause = [], $reference = [], $elt = "id")
    {
        if(!empty($clause) && !empty($reference))
        {
            $last_id = count($clause) - 1;
            $last_elt = $clause[$last_id];
            $last_elt += [Query::CONNECTOR => Query::CONNECTOR_AND];

            $clause[$last_id] = $last_elt;

            $n = count($reference);
            $i = 0;
            foreach($reference as $key => $value)
            {
                if($i < ($n - 1))
                {
                    array_push($clause,
                        array(
                            Query::CLAUSE_LEFT => $key,
                            Query::OPERATOR  => Query::OPERATOR_NOT_EQUAL,
                            Query::CLAUSE_RIGHT => $value,
                            Query::CONNECTOR => Query::CONNECTOR_AND
                        )
                    );
                }
                else
                {
                    array_push($clause,
                        array(
                            Query::CLAUSE_LEFT => $key,
                            Query::OPERATOR  => Query::OPERATOR_NOT_EQUAL,
                            Query::CLAUSE_RIGHT => $value,
                        )
                    );
                }
                ++$i;
            }

            return $this->existingValue($table, $clause, $elt);
        }
        else
            return false;
    }

    /*
        $table = getTableName(Table::COMPTE);

        $clause = array();
        array_push($clause,
            array(
                Query::CLAUSE_LEFT => Compte::LOGIN,
                Query::OPERATOR  => Query::OPERATOR_EQUAL,
                Query::CLAUSE_RIGHT => "gan",
                Query::CONNECTOR => Query::CONNECTOR_AND
            ),
            array(
                Query::CLAUSE_LEFT => Compte::EMAIL,
                Query::OPERATOR  => Query::OPERATOR_EQUAL,
                Query::CLAUSE_RIGHT => "bobiegran@yahoo.fr",
                Query::CONNECTOR => Query::CONNECTOR_AND
            ),
            array(
                Query::CLAUSE_LEFT => Compte::TELEPHONE,
                Query::OPERATOR  => Query::OPERATOR_EQUAL,
                Query::CLAUSE_RIGHT => "66679397"
            )
        );

        $exist = existingValue($table, $clause);
        var_dump($exist);
    */
    function existingValue($table,  $clause = [], $elt = "id")
    {
        $conditions = "";
        $result = array();
        if(!empty($clause))
        {
            $result = $this->$this->makeWhereWhereCondition($clause);
            $conditions = $result[Query::TAG_CONDITION];
        }

        $req = "SELECT " . $elt . " FROM " . $table . $conditions. " ;";

        $q = $this->db->prepare("$req");

        if(!empty($clause))
        {
            $this->buildParameter($result[Query::TAG_CLAUSE_ARRAY], $q);
        }

        $result = $q->execute();
        $count = $q->rowCount();
        $q->closeCursor();

        return ($count ? true : false);
    }

    /*
     * Permet de retourner soit toutes les donnees d'une table
     * soit un ensemble de donnees specifique suivant un filtre precis
     * @param string $table, array $clause, string $elt AND string $function
     * @return false|string Returns the result of SQL function
     * @since 1.0.0
     *
     *
        $clause = array();
        array_push($clause,
            array(
                Query::CLAUSE_LEFT => Slide::VISIBILITE,
                Query::OPERATOR  => Query::OPERATOR_EQUAL,
                Query::CLAUSE_RIGHT => UN
            )
        );

        $order = array(Slide::TITRE => Query::ORDER_DESC);

        $data_slide = getAllByFilter($table_slide, $clause, Query::SELECTOR_ALL, $order);
     *
    */
    function getAllByFilter($table, $clause = [], $ensble_elt = "*", $order = "", $filtering = false, $limit = "")
    {
        $conditions = "";
        $result = array();
        if(!empty($clause))
        {
            $result = $this->makeWhereWhereCondition($clause);
            $conditions = $result[Query::TAG_CONDITION];
        }
        $elt = $this->makeWhereSelectList($ensble_elt);

        $orderBy = $this->makeWhereOrderList($order);
        $limit = (empty($limit))? $limit : " LIMIT ".$limit;
        if($filtering)
        {
            $req = "SELECT " . Query::FILTER_DISTINCT . " " . $ensble_elt . " FROM " . $table . $conditions . $orderBy . $limit . " ;";
        }
        else
        {
            $req = "SELECT " . $ensble_elt . " FROM " . $table . $conditions . $orderBy . $limit . " ;";
        }

        $q = $this->db->prepare("$req");

        if(!empty($clause))
        {
            $this->buildParameter($result[Query::TAG_CLAUSE_ARRAY], $q);
        }

        $result = $q->execute();

        $data = $q->fetchAll(PDO::FETCH_OBJ);
        $q->closeCursor();

        return ($data ? ((count($data) > 1) ? $data : $data[0]) : false);
    }


    /*
     * Backend data find by clausing check like business layer [couche metier]
     * @param string $table, array $clause AND string $elt
     * @return false|string Returns the result of value element
     * @since 1.0.0
    */
    function getValueWithPrecision($table, $clause = [], $elt = "id")
    {
        $conditions = "";
        $result = array();
        if(!empty($clause))
        {
            $result = $this->makeWhereWhereCondition($clause);
            $conditions = $result[Query::TAG_CONDITION];
        }

        $req = "SELECT " . $elt . " as element FROM " . $table . $conditions .";";
        $q = $this->db->prepare("$req");

        if(!empty($clause))
        {
            $this->buildParameter($result[Query::TAG_CLAUSE_ARRAY], $q);
        }

        $result = $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        $q->closeCursor();

        return ($data ? $data->element : false);
    }

    /*
     * Backend data find by function IN SQL language like business layer [couche metier]
     * @param string $table, array $clause, string $elt AND string $function
     * @return false|string Returns the result of SQL function
     * @since 1.0.0
     *

        $clause = array();
        array_push($clause, $this->makeWhereClause(Compte::LOGIN, Query::OPERATOR_EQUAL, $login));
        array_push($clause, $this->makeWhereClause(Compte::PASSWORD, Query::OPERATOR_EQUAL, $password));
        array_push($clause, $this->makeWhereClause(Compte::VISIBILITE, Query::OPERATOR_EQUAL, UN));

        or

        $clause_point_marchand = array();
        array_push($clause_point_marchand,
            array(
                Query::CLAUSE_LEFT => PointMarchand::VISIBILITE,
                Query::OPERATOR  => Query::OPERATOR_EQUAL,
                Query::CLAUSE_RIGHT => UN,
                Query::CONNECTOR => Query::CONNECTOR_AND
            ),
            array(
                Query::CLAUSE_LEFT => PointMarchand::STATUT,
                Query::OPERATOR  => Query::OPERATOR_EQUAL,
                Query::CLAUSE_RIGHT => UN
            )
        );
        $nbre_total_point_marchand = getValueByFucntionSQL($table_point_marchand, $clause_point_marchand);
    */
    function getValueByFucntionSQL($table, $clause = [], $elt = "id", $function = "COUNT")
    {
        $conditions = "";
        $result = array();
        if(!empty($clause))
        {
            $result = $this->makeWhereWhereCondition($clause);
            $conditions = $result[Query::TAG_CONDITION];
        }

        // $elt = $this->makeWhereSelectList($elt);
        $req = "SELECT " . rtrim($function) . "( " . $elt . " ) as element FROM " . $table . $conditions .";";

        $q = $this->db->prepare("$req");

        if(!empty($clause))
        {
            $this->buildParameter($result[Query::TAG_CLAUSE_ARRAY], $q);
        }

        $result = $q->execute();
        $data = $q->fetch(PDO::FETCH_OBJ);
        $q->closeCursor();

        return ($data ? $data->element : false);
    }


    /**
     * Cette fonction est trés utile pour les champs de recherches
     * @param $table
     * @param array $condition
     * @param array $clause
     * @param string $orderBy
     * @param string $elt
     * @return bool
     */
    function getSomethingLike($table, $condition = array(), $clause = array(), $orderBy = "",$elt = "*")
    {
        $arrayAll = array();
        $conditionValues = " WHERE ";
        if(!empty($condition))
        {
            $n = count($condition);
            $i = 0;

            foreach ($condition as $key => $value)
            {
                if($i < ($n - 1))
                {
                    $conditionValues .= " $key = :$key AND";
                }
                else
                {
                    $conditionValues .= " $key = :$key ";
                }
                ++$i;
                $arrayAll[$key] = $value;
            }
        }

        $clauseValues = "";
        if(!empty($clause))
        {
            $clauseValues = "AND ";
            $n = count($clause);
            $i = 0;

            foreach ($clause as $key => $value)
            {
                if($i < ($n - 1))
                {
                    $clauseValues .= " $key LIKE \"%". $value . "%\" OR";
                }
                else
                {
                    $clauseValues .= " $key LIKE \"%". $value . "%\" ";
                }
                ++$i;
                $arrayAll[$key] = $value;
            }
        }

        $orderBy = $orderBy ? " ORDER BY " . $orderBy : "";
        $req = "SELECT " . $elt . " FROM " . $table . $conditionValues . $clauseValues . $orderBy . ";";
        $q = $this->db->prepare("$req");

        if(!empty($condition))
        {
            foreach ($condition as $key => $value)
            {
                $q->bindValue(":$key", $value, $this->get_pdo_type($value));
            }
        }

        $result = $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        $q->closeCursor();

        return $data ? : false;
    }

#################   TO USE
#################   TESTED

    /*
        *  @Deprecated
        *  Realise une requete de jointure entre deux table
        *  @param string -----> $join : type de jointure
        *  @param string -----> $from_table : table primaire de la jointure
        *  @param string -----> $to_table : table secondaire de la jointure
        *  @param array(["key" => $value]....) -----> $join_clause : tableau associatif d'element a comparer dans la clause join
        *  @param array(["key" => $value]....) -----> $where_clause : tableau associatif d'element a comparer dans la clause where
        *  @param string -----> $ensble_elt : ensemble d'element à retourner dans le resultat de la requete
        *  @param string -----> $filter : element donc on souhaite supprimer des  doublons
        *  @param string -----> $order : element selon lequel on souhaite retourner les resultats de la requte
        *  @return false|string resultat de la requete
        *  @since 1.0.0
        *  @todo : ajouter les nom de table afin d'eviter toute ambiguité lors de l'execution des requetes
    */
    function getAllBySingleOuterJoin($join, $from_table, $to_table,  $join_clause = [], $where_clause = [], $select_list = "*", $filter = "", $order = "")
    {
        $ensble_elt = $this->makeWhereSelectList($select_list);

        /*
         * CONSTRUCTION OF CONDITION
        */
        $join_conditions = "";
        $clauseArray = array();
        $i = 0;
        $n = count($join_clause);
        foreach ($join_clause as $key => $value)
        {
            if($i < ($n - 1))
            {
                $join_conditions .= is_null($value)?  " $key is null AND" :  " $key = ? AND";
            }
            else
            {
                $join_conditions .= is_null($value)? " $key is null " :  " $key = ? ";
            }
            ++$i;
            $clauseArray += [$key => $value];
        }

        if($join_conditions)
            $join_conditions = " ON " . $join_conditions;


        $where_conditions = "";
        $n = count($where_clause);
        $i = 0;
        foreach ($where_clause as $key => $value)
        {
            if($i < ($n - 1))
            {
                $where_conditions .= is_null($value)?  " $key is null AND" :  " $key = ? AND";
            }
            else
            {
                $where_conditions .= is_null($value)? " $key is null " :  " $key = ? ";
            }
            ++$i;
            $clauseArray += [$key => $value];
        }
        if($where_conditions)
            $where_conditions = "WHERE" . $where_conditions;

        /*
         * ORDER BY SOME FILTER
        */
        $orderBy = !empty($order) ? "ORDER BY " . $order : "";

        $req = "SELECT " .  $filter . " " . $ensble_elt . " FROM " . $from_table . " " . $join. " " . $to_table ." ". $join_conditions . " " . $where_conditions . $orderBy . " ;";

        $q = $this->db->prepare("$req");
        $i = 0;
        foreach ($clauseArray as $key => $value)
        {
            $q->bindValue(++$i, $value, $this->get_pdo_type($value));
        }
        //var_dump($req);
        $result = $q->execute();

        $data = $q->fetchAll(PDO::FETCH_OBJ);
        $q->closeCursor();

        return ($data ? ((count($data) > 1) ? $data : $data[0]) : false);
    }

#################    TO USE
#################    NOT TESTED
    /*
        *  @method getAllByDoubleOuterJoin
        *   Realise une requete de jointure entre deux table
        *  @param string -----> $join : type de jointure
        *  @param string -----> $from_table : table primaire de la jointure
        *  @param string -----> $to_table : table secondaire de la jointure
        *  @param array(["key" => $value]....) -----> $join_clause : tableau associatif d'element a comparer dans la clause join
        *  @param array(["key" => $value]....) -----> $where_clause : tableau associatif d'element a comparer dans la clause where
        *  @param string -----> $ensble_elt : ensemble d'element à retourner dans le resultat de la requete
        *  @param string -----> $filter : element donc on souhaite supprimer des  doublons
        *  @param string -----> $order : element selon lequel on souhaite retourner les resultats de la requte
        *  @param string -----> $limit : renvoie le nombre de ligne spécifie
        *  @return false|string resultat de la requete
        *  @since 1.0.0
        *  @todo : ajouter les nom de table afin d'eviter toute ambiguité lors de l'execution des requetes
        */
    /*
        ## EXAMPLE OF JOINS ARRAY
        $joins = [];

        $join["JOIN_TYPE"] = "JOIN_TYPE";
        $join["JOIN_TABLE"] = "JOIN_TABLE";
        $join["JOIN_CLAUSE"] = "JOIN_CLAUSE";
        array_push($joins, $join);

        $join["JOIN_TYPE"] = "JOIN_TYPE_1";
        $join["JOIN_TABLE"] = "JOIN_TABLE_1";
        $join["JOIN_CLAUSE"] = "JOIN_CLAUSE_1";
        array_push($joins, $join);

        $join["JOIN_TYPE"] = "JOIN_TYPE_2";
        $join["JOIN_TABLE"] = "JOIN_TABLE_2";
        $join["JOIN_CLAUSE"] = "JOIN_CLAUSE_2";
        array_push($joins, $join);
*/
    function getAllByMultiOuterJoin_V_old( $table, $joins, $where_clause = [], $select_list = "*", $filter = "", $order = "", $limit ="", $debug = false)
    {
        $ensble_elt = $this->makeWhereSelectList($select_list);

        /*
         * CONSTRUCTION OF CONDITION
        */
        $join = "";
        $clauseArray = array();
        $where_conditions = "";


        foreach($joins as $val){
            $join_type = $val[JOIN_TYPE];
            $join_table = $val[JOIN_TABLE];
            $join_clause = $val[JOIN_CLAUSE];
            $join_conditions = "";

            $n = count($join_clause);
            $i = 0;
            foreach ($join_clause as $key => $value)
            {
                $temp = explode(' ', $join_table);
                $new_key = ($temp[1] == '')? $key : $temp[1].".".$key;
                if($i < ($n - 1))
                {
                    $join_conditions .= is_null($value)?  " $new_key is null AND" :  " $new_key = $value AND";
                }
                else
                {
                    $join_conditions .= is_null($value)? " $new_key is null " :  " $new_key = $value ";
                }
                ++$i;
                //$clauseArray += [$key => $value];
            }
            $join_conditions = " ON " . $join_conditions;
            $join .=" " . $join_type. " " . $join_table ." ". $join_conditions;
        }

        $result = $this->makeWhereWhereCondition($where_clause) ;
        $clauseArray += $result[Query::TAG_CLAUSE_ARRAY];
        $where_conditions = $result[Query::TAG_CONDITION];

        /*
         * ORDER BY SOME FILTER
        */
        $orderBy = !empty($order) ? "ORDER BY " . $order : "";
        $limit = !empty($limit) ? "LIMIT " . $limit : "";

        $req = "SELECT " . $filter . " " . $ensble_elt . " FROM " . $table . " " . $join. " " . $where_conditions ." ". $orderBy . " " . $limit. " ;";
        if($debug)
        {
            var_dump($clauseArray);
            var_dump($req);
            die();
        }
        $q = $this->db->prepare("$req");
        $this->buildParameter($clauseArray, $q);

        $result = $q->execute();

        $data = $q->fetchAll(PDO::FETCH_OBJ);
        $q->closeCursor();
        return ($data ? (is_array($data) ? $data : array($data)) : false);
    }


#################    TO USE
#################    NOT TESTED

    /*
        *  @method getAllByDoubleOuterJoin
        *   Realise une requete de jointure entre deux table
        *  @param string -----> $join : type de jointure
        *  @param string -----> $from_table : table primaire de la jointure
        *  @param string -----> $to_table : table secondaire de la jointure
        *  @param array(["key" => $value]....) -----> $join_clause : tableau associatif d'element a comparer dans la clause join
        *  @param array(["key" => $value]....) -----> $where_clause : tableau associatif d'element a comparer dans la clause where
        *  @param string -----> $ensble_elt : ensemble d'element à retourner dans le resultat de la requete
        *  @param string -----> $filter : element donc on souhaite supprimer des  doublons
        *  @param string -----> $order : element selon lequel on souhaite retourner les resultats de la requte
        *  @param string -----> $limit : renvoie le nombre de ligne spécifie
        *  @return false|string resultat de la requete
        *  @since 1.0.0
        *  @todo : ajouter les nom de table afin d'eviter toute ambiguité lors de l'execution des requetes
        */
    /*
        ## EXAMPLE OF JOINS ARRAY
        $joins = [];

        $join["JOIN_TYPE"] = "JOIN_TYPE";
        $join["JOIN_TABLE"] = "JOIN_TABLE";
        $join["JOIN_CLAUSE"] = "JOIN_CLAUSE";
        array_push($joins, $join);

        $join["JOIN_TYPE"] = "JOIN_TYPE_1";
        $join["JOIN_TABLE"] = "JOIN_TABLE_1";
        $join["JOIN_CLAUSE"] = "JOIN_CLAUSE_1";
        array_push($joins, $join);

        $join["JOIN_TYPE"] = "JOIN_TYPE_2";
        $join["JOIN_TABLE"] = "JOIN_TABLE_2";
        $join["JOIN_CLAUSE"] = "JOIN_CLAUSE_2";
        array_push($joins, $join);
*/
    function getAllByMultiOuterJoin( $table, $joins, $where_clause = [], $select_list = "*", $filter = "", $order = "", $limit ="", $debug = false)
    {
        
        $ensble_elt = $this->makeWhereSelectList($select_list);

        /*
         * CONSTRUCTION OF CONDITION
        */
        $join = "";
        $clauseArray = array();
        $where_conditions = "";


        foreach($joins as $val){
            $join_type = $val[JOIN_TYPE];
            $join_table = $val[JOIN_TABLE];
            $join_clause = $val[JOIN_CLAUSE];
            $join_conditions = "";

            $n = count($join_clause);
            $i = 0;
            foreach ($join_clause as $key => $value)
            {
                if($i < ($n - 1))
                {
                    $join_conditions .= is_null($value)?  " $key is null AND" :  " $key = $value AND";
                }
                else
                {
                    $join_conditions .= is_null($value)? " $key is null " :  " $key = $value ";
                }
                ++$i;
                //$clauseArray += [$key => $value];
            }
            $join_conditions = " ON " . $join_conditions;
            $join .=" " . $join_type. " " . $join_table ." ". $join_conditions;
        }

        $result = $this->makeWhereWhereCondition($where_clause) ;
        $clauseArray += $result[Query::TAG_CLAUSE_ARRAY];
        $where_conditions = $result[Query::TAG_CONDITION];

        /*
         * ORDER BY SOME FILTER
        */
        $orderBy = !empty($order) ? "ORDER BY " . $order : "";
        $limit = !empty($limit) ? "LIMIT " . $limit : "";

        $req = "SELECT " . $filter . " " . $ensble_elt . " FROM " . $table . " " . $join. " " . $where_conditions ." ". $orderBy . " " . $limit. " ;";
        if($debug)
        {
            var_dump($clauseArray);
            var_dump($req);
            die();
        }
        $q = $this->db->prepare("$req");
        $this->buildParameter($clauseArray, $q);

        $result = $q->execute();

        $data = $q->fetchAll(PDO::FETCH_OBJ);
        $q->closeCursor();
        return ($data ? (is_array($data) ? $data : array($data)) : false);
    }


#################    TO DOCUMENT USING IN JOIN

    /*
     * EXAMPLE :
     *      $order = array(Slide::TITRE => Query::ORDER_DESC);
     *
     *      $order_list = array(
     *                          "column-01" => Query::ORDER_DESC,
     *                          "column-02" => Query::ORDER_ASC,
     *                          "column-03" => Query::ORDER_DESC
     *                      );
     */
    function makeWhereOrderList($order_list)
    {
        $ensble_elt = " ORDER BY ";
        $i = 0;

        if(is_array($order_list))
        {
            $len = count($order_list);
            if(isAssoc($order_list))
            {
                foreach($order_list as $key => $value)
                {
                    if ($i == ($len - 1))
                    {
                        $ensble_elt .= ($key ." ". $value." ") ;
                    }
                    else
                    {
                        $ensble_elt .= (" ".$key ." ". $value. Query::SEPARATOR_COMMA ) ;
                    }
                    $i++;
                }

            }
            else
            {
                foreach($order_list as $value)
                {
                    if($i == ($len - 1))
                    {
                        $ensble_elt .= ($value." ");
                    }
                    else
                    {
                        $ensble_elt .= (" ".$value. Query::SEPARATOR_COMMA );
                    }
                    $i++;
                }
            }
        }
        else
        {
            if(!is_null($order_list) && !empty($order_list))
            {
                $ensble_elt .= $order_list;
            }
            else
            {
                $ensble_elt = "";
            }
        }

        return $ensble_elt;
    }

################    TO DOCUMENT USING IN JOIN

    function makeWhereSelectList($select_list)
    {
        $ensble_elt = "";
        $i = 0;

        if(is_array($select_list))
        {
            $len = count($select_list);
            if(isAssoc($select_list))
            {
                foreach($select_list as $key => $value)
                {
                    if ($i == ($len - 1))
                    {
                        $ensble_elt .= ($key ." AS ". $value." ") ;
                    }
                    else
                    {
                        $ensble_elt .= (" ".$key ." AS ". $value. Query::SEPARATOR_COMMA ) ;
                    }
                    $i++;
                }

            }
            else
            {
                foreach($select_list as $value)
                {
                    if($i == ($len - 1))
                    {
                        $ensble_elt .= ($value." ");
                    }
                    else
                    {
                        $ensble_elt .= (" ".$value. Query::SEPARATOR_COMMA );
                    }
                    $i++;
                }
            }
        }
        else
        {
            if(!is_null($select_list))
            {
                $ensble_elt = $select_list;
            }
            else
            {
                $ensble_elt = "*";
            }
        }

        return $ensble_elt;
    }


    /*
     * Permet de retourner soit toutes les donnees d'une table
     * soit un ensemble de donnees specifique suivant un filtre precis
     * @param string $table, array $clause, string $elt AND string $function
     * @return false|string Returns the result of SQL function
     * @since 1.0.0
    */
    function getAllWithFilterBetween($table, $clause = [], $ensble_elt = "*", $filter = "", $order = "",  $limit = "")
    {
        /*
         * CONSTRUCTION OF CONDITION
         */
        $conditions = "";
        $n = count($clause);
        $i = 0;
        foreach ($clause as $key => $value)
        {
            if($i < ($n - 1))
            {
                $conditions .= " $key = :$key AND";
            }
            else
            {
                $conditions .= " $key = :$key ";
            }
            ++$i;
        }

        if($conditions)
            $conditions = "WHERE" . $conditions;

        /*
         * ORDER BY SOME FILTER
         */
        $orderBy = !empty($order) ? "ORDER BY " . $order : "";


        if($filter)
        {
            $req = "SELECT " . $filter . " " . $ensble_elt . " FROM " . $table . " " . $conditions . $orderBy . " ;";
        }
        else
        {
            $req = "SELECT " . $ensble_elt . " FROM " . $table . " " . $conditions . $orderBy . " ;";
        }

        $q = $this->db->prepare("$req");

        foreach ($clause as $key => $value)
        {
            $q->bindValue(":$key", $value, $this->get_pdo_type($value));
        }

        $result = $q->execute();



        $data = $q->fetchAll(PDO::FETCH_OBJ);
        $q->closeCursor();

        return ($data ? ((count($data) > 1) ? $data : $data[0]) : false);
    }


    /*
     * Construit la clause conditionnelle en fonction du type d'operateur
     *Une entrée comporte trois partie : [ Partie gauche | Operateur | Partie droite ]
     * @param string  array $clause
     * @return false|string Returns the result of SQL function
     * @since 1.0.0
    */
    function makeWhereSimpleWhereCondition($clause)
    {
        //var_dump($clause);
        //die();
        $req = " ";
        switch($clause[Query::OPERATOR]){
            case Query::OPERATOR_BETWEEN :
                $req .= $clause[Query::CLAUSE_LEFT] ." ". $clause[Query::OPERATOR] ." ? ". Query::CONNECTOR_AND." ? " ;
                break;

            case Query::OPERATOR_LIKE :
                $req .= $clause[Query::CLAUSE_LEFT]. " ". $clause[Query::OPERATOR] ." \"%". " ? ". "%\"  ";
                break;

            default:
                $tmp = is_null($clause[Query::CLAUSE_RIGHT])? "  is null" : " ". $clause[Query::OPERATOR] ." ? ";
                $tmp =  (is_null($clause[Query::CLAUSE_RIGHT]) && ($clause[Query::OPERATOR] == Query::OPERATOR_NOT_EQUAL) ) ? "  is not null" : $tmp;
                $req .= $clause[Query::CLAUSE_LEFT] ." ". $tmp;
        }
        return $req." ";
    }


    /*
     * Construit la clause conditionnelle en fonction du type d'operateur
     *Une entrée comporte trois partie : [ Partie gauche | Operateur | Partie droite ]
     * @param string  array $clause
     * @return false|string Returns the result of SQL function
     * @since 1.0.0
    */
    function makeWhereWhereCondition($clauses)
    {

        $result = array();
        $req = " ";
        $conditions = " WHERE ";

        $i = 0;
        $clauseArray = array();

        if(is_array($clauses)){
            $n = count($clauses);
            if($n > 0)
            {
                foreach ($clauses as $clause)
                {
                    if($i < ($n - 1))
                    {
                        $conditions .= $this->makeWhereSimpleWhereCondition($clause) . " ". (!empty($clause[Query::CONNECTOR])? $clause[Query::CONNECTOR] : Query::CONNECTOR_AND ) ;
                    }
                    else
                    {
                        $conditions .= $this->makeWhereSimpleWhereCondition($clause);
                    }
                    ++$i;
                    $clauseArray += [$clause[Query::CLAUSE_LEFT] => $clause[Query::CLAUSE_RIGHT] ];
                }
            }
        }
        else
        {
            $conditions = "";
        }

        $result[Query::TAG_CLAUSE_ARRAY] = $clauseArray;
        $result[Query::TAG_CONDITION] = $conditions;

        return $result;
    }

    /*
     * Help to bind value using array clause
     *Une entrée comporte trois partie : [ Partie gauche | Operateur | Partie droite ]
     * @param string  array $clause
     * @return false|string Returns the result of SQL function
     * @since 1.0.0
    */
    function buildParameter($clauseArray = [], &$request_instance)
    {
        $i = 0;
        foreach ($clauseArray as $key => $value)
        {
            if(!is_null($value) || !empty($value)){
                if(is_array($value)){
                    $request_instance->bindValue(++$i, $value[Query::CLAUSE_LEFT], $this->get_pdo_type($value[Query::CLAUSE_LEFT]));
                    $request_instance->bindValue(++$i, $value[Query::CLAUSE_RIGHT], $this->get_pdo_type($value[Query::CLAUSE_RIGHT]));
                }else{
                    $request_instance->bindValue(++$i, $value, $this->get_pdo_type($value));
                }
            }
        }
    }

    /*


        $scalar_function =
            array(
                    Query::FUNCTION  => Query::OPERATOR_EQUAL, //COUNT
                    Query::ALIAS => UN                          //total
                )
            array(
                    Query::FUNCTION  => Query::OPERATOR_EQUAL, //SUM
                    Query::ALIAS => UN                          //total
                )
        $interval =

        array(
                    Query::INTERVAL_PERIOD => MONTH, //SUM
                    Query::INTERVAL_WIDTH =>  5                         //total
            )




        */

    /*
     *
        SELECT DATE_FORMAT( CONCAT(YEAR(". $column . "), "-",
            MONTH(". $column . "), "-",
            DAYOFMONTH(". $column . "), " ",
            HOUR(". $column . "), ":",
            MINUTE(". $column . "), ":",
            SECOND(". $column . ")), GET_FORMAT(DATETIME,'ISO'))
        FROM sum_transaction_commerciales;

        $clause = array();
        array_push($clause, $this->makeWhereClause(Compte::LOGIN, Query::OPERATOR_EQUAL, $login));
        array_push($clause, $this->makeWhereClause(Compte::PASSWORD, Query::OPERATOR_EQUAL, $password));
        array_push($clause, $this->makeWhereClause(Compte::VISIBILITE, Query::OPERATOR_EQUAL, UN));

        $group_select = "";
        $scalar_function =
        array(
                Query::FUNCTION  => Query::OPERATOR_EQUAL, //COUNT
                Query::ALIAS => UN                          //total
            )
        array(
                Query::FUNCTION  => Query::OPERATOR_EQUAL, //SUM
                Query::ALIAS => UN                          //total
            )
    $interval =

    array(
                Query::INTERVAL_PERIOD => MONTH, //SUM
                Query::INTERVAL_WIDTH =>  5                         //total
        )

        $column =
            array(
                Query::COLUMN => sum_...datecreation, //SUM
                Query::TAG_ALIAS =>  date                          //total
        )

    */
    function getResultWithDateInterval($table, $clause = [], $column = "id", $scalar_function_clause = "COUNT", $type_period, $width)
    {

        $sep_date = "'-'";
        $sep_time = "':'";
        $sep_space = "' '";
        $sep_dash = ".";

        $select_year = "YEAR(". $table.$sep_dash.$column[Query::COLUMN] . ")";
        $select_month = "MONTH(". $table.$sep_dash.$column[Query::COLUMN] . ")";
        $select_day = "DAYOFMONTH(". $table.$sep_dash.$column[Query::COLUMN] . ")";
        $select_hour = "HOUR(". $table.$sep_dash.$column[Query::COLUMN] . ")";
        $select_min = "MINUTE(". $table.$sep_dash.$column[Query::COLUMN] . ")";
        $select_sec = "SECOND(". $table.$sep_dash.$column[Query::COLUMN] . ")";

        $group_year = "EXTRACT(YEAR FROM ". $table.$sep_dash.$column[Query::COLUMN] . ")";
        $group_month = "EXTRACT(MONTH FROM ". $table.$sep_dash.$column[Query::COLUMN] . ")";
        $group_day = "EXTRACT(DAY FROM ". $table.$sep_dash.$column[Query::COLUMN] . ")";
        $group_hour = "EXTRACT(HOUR FROM ". $table.$sep_dash.$column[Query::COLUMN] . ")";
        $group_min = "EXTRACT(MINUTE FROM ". $table.$sep_dash.$column[Query::COLUMN] . ")";
        $group_sec = "EXTRACT(SECOND FROM ". $table.$sep_dash.$column[Query::COLUMN] . ")";

        switch($type_period){
            case  Query::INTERVAL_PERIOD_YEAR:
                $select_year = "FLOOR(YEAR(". $table.$sep_dash.$column[Query::COLUMN] . ")/".$width. ")";
                $select_month = "'0'";
                $select_day = "'0'";
                $select_hour = "'0'";
                $select_min = "'0'";
                $select_sec = "'0'";

                $group_year = "FLOOR(EXTRACT(YEAR FROM ". $table.$sep_dash.$column[Query::COLUMN] . ")/". $width .")";

                $group_month = "";
                $group_day = "";
                $group_hour = "";
                $group_min = "";
                $group_sec = "";
                break;

            case  Query::INTERVAL_PERIOD_MONTH:
                $select_month = "FLOOR(MONTH(". $table.$sep_dash.$column[Query::COLUMN] . ")/". $width .")";

                $select_day = "'0'";
                $select_hour = "'0'";
                $select_min = "'0'";
                $select_sec = "'0'";

                $group_month = "FLOOR(EXTRACT(MONTH FROM ". $table.$sep_dash.$column[Query::COLUMN] . ")/". $width .")";

                $group_day = "";
                $group_hour = "";
                $group_min = "";
                $group_sec = "";

                break;

            case  Query::INTERVAL_PERIOD_DAY:
                $select_month = "FLOOR(DAYOFMONTH(". $table.$sep_dash.$column[Query::COLUMN] . ")/".$width .")";
                $select_day = "'0'";
                $select_hour = "'0'";
                $select_min = "'0'";
                $select_sec = "'0'";

                $group_day = "FLOOR(EXTRACT(DAY FROM ". $table.$sep_dash.$column[Query::COLUMN] . ")/". $width .")";

                $group_hour = "";
                $group_min = "";
                $group_sec = "";

                break;

            case  Query::INTERVAL_PERIOD_HOUR:
                $select_hour = "FLOOR(HOUR(". $table.$sep_dash.$column[Query::COLUMN] . ")/".$width .")";

                $select_hour = "'0'";
                $select_min = "'0'";
                $select_sec = "'0'";

                $group_hour = "FLOOR(EXTRACT(HOUR FROM ". $table.$sep_dash.$column[Query::COLUMN] . ")/". $width .")";

                $group_min = "";
                $group_sec = "";

                break;

            case  Query::INTERVAL_PERIOD_MINUTE:
                $select_min = "FLOOR(MINUTE(". $table.$sep_dash.$column[Query::COLUMN] . ")/".$width .")";

                $select_sec = "'0'";

                $group_min = "FLOOR(EXTRACT(MINUTE FROM ". $table.$sep_dash.$column[Query::COLUMN] . ")/". $width .")";

                $group_sec = "";

                break;

            case  Query::INTERVAL_PERIOD_SECONDE:
                $sec = "FLOOR(SECOND(". $table.$sep_dash.$column[Query::COLUMN] . ")/".$width .")";

                $group_sec = "FLOOR(EXTRACT(SECOND FROM ". $table.$sep_dash.$column[Query::COLUMN] . ")/". $width .")";

                break;
            default :
        }

        $select_date = " DATE_FORMAT( CONCAT( "
            // $select_date = " unix_timestamp(DATE_FORMAT( CONCAT( "
            . $select_year . Query::SEPARATOR_COMMA . $sep_date . Query::SEPARATOR_COMMA . $select_month . Query::SEPARATOR_COMMA . $sep_date . Query::SEPARATOR_COMMA . $select_day . Query::SEPARATOR_COMMA .   $sep_space  . Query::SEPARATOR_COMMA .
            $select_hour .  Query::SEPARATOR_COMMA . $sep_time . Query::SEPARATOR_COMMA .
            $select_min . Query::SEPARATOR_COMMA  . $sep_time . Query::SEPARATOR_COMMA .
            $select_sec .") , GET_FORMAT(DATETIME,'ISO')".
            ") AS " . $column[Query::TAG_ALIAS] ." ";
        // ")) AS " . $column[Query::TAG_ALIAS] ." ";

        $group_select = $group_year . Query::SEPARATOR_ESCAPE;
        $group_select = (empty($group_month))? $group_select : $group_select . Query::SEPARATOR_COMMA . $group_month;
        $group_select = (empty($group_day))? $group_select : $group_select . Query::SEPARATOR_COMMA . $group_day;
        $group_select = (empty($group_hour))? $group_select : $group_select . Query::SEPARATOR_COMMA . $group_hour;
        $group_select = (empty($group_min))? $group_select : $group_select . Query::SEPARATOR_COMMA . $group_min;
        $group_select = (empty($group_sec))? $group_select : $group_select . Query::SEPARATOR_COMMA . $group_sec;

        $select_aggregator = Query::SEPARATOR_COMMA;
        if(is_array($scalar_function_clause))
            $scalar_function_clause = array($scalar_function_clause);
        $n = count($scalar_function_clause);
        $i = 1;
        foreach($scalar_function_clause as $scalar_function){
            if($i++ == $n){
                $select_aggregator .= rtrim($scalar_function[Query::TAG_FUNCTION]). "(". $table.$sep_dash.$scalar_function[Query::COLUMN].")". Query::ALIAS . $scalar_function[Query::ALIAS]. Query::SEPARATOR_ESCAPE;
            }else{
                $select_aggregator .= rtrim($scalar_function[Query::TAG_FUNCTION]). "(". $table.$sep_dash.$scalar_function[Query::COLUMN].")". Query::ALIAS . $scalar_function[Query::ALIAS] . Query::SEPARATOR_COMMA;
            }
        }

        $result = [];
        $conditions =" ";
        if(!empty($clause))
        {
            $result = $this->makeWhereWhereCondition($clause);
            $conditions = $result[Query::TAG_CONDITION];
        }

        $req = "SELECT " . $select_date . Query::SEPARATOR_ESCAPE . $select_aggregator." FROM " . $table . $conditions . Query::SEPARATOR_ESCAPE ." GROUP BY " . $column[Query::TAG_ALIAS] .
            " ORDER BY ". $select_day ." DESC;";

        $q = $this->db->prepare("$req");

        if(!empty($clause))
        {
            $this->buildParameter($result[Query::TAG_CLAUSE_ARRAY], $q);
        }

        $res = $q->execute();
        $data = $q->fetchAll(PDO::FETCH_OBJ);
        $q->closeCursor();

        return ($data ? (is_array($data) ? $data : array($data)) : false);
    }
}