<?php

namespace Core\Database;

use PDO;

use PDOException;
use function Core\Helper\dd;

trait QueryTrait
{
    
    /**
	 * Fait une requête SQL qu'elle reçoit en paramètre
	 * 
	 * @access public
	 * @param string $statement requête SQL
	 * @param string $className classe de retour pour la récupération des données
	 * @param bool $oneResult (optional) indique si on souhaite récupérer un élément et on fait un fetch ou plusieurs et on fait un fetchAll
	 * @return object $className objet retourné selon celui passé en paramètre
	 */
    public function query($statement, $className = null, $one = false)
    {
        
        $pdo = $this->getPDO();
        $res = $pdo->query($statement);
        
        if ($className === null)
        {
            $res->setFetchMode(PDO::FETCH_OBJ);
        }
        else
        {
            $res->setFetchMode(PDO::FETCH_CLASS, $className);
        }
        
        if ($one)
        {
            $data = $res->fetch();
        } else
        {
           try{
            $data = $res->fetchAll();
           } catch (PDOException $ex) {
                dd($ex);
            }
        }
        $res->closeCursor();
        return $data;
    }

    /**
	 * Fait un requête SQL préparée qu'elle reçoit en paramètre
	 * 
	 * @access public
	 * @param string $statement requête SQL
	 * @param array $parameters paramètre à ajouter dans la requête SQL
	 * @param string $className classe de retour pour la récupération des données
	 * @param bool $oneResult (optional) indique si on souhaite récupérer un élément et on fait un fetch ou plusieurs et on fait un fetchAll
	 * @return object $className objet retourné selon celui passé en paramètre
	 */
    public function prepareSQL($statement, $param, $class_name, $one = false)
    {
        $pdo = $this->getPDO();
        $req = $pdo->prepare($statement);
        $req->execute($param);
      
        if ($class_name === null)
        {
            $req->setFetchMode(PDO::FETCH_OBJ);
        }
        else
        {
            $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }

        if($one){
            $data = $req->fetch();
        }
        else{
            $data = $req->fetchAll();
        }
        return $data;
    }

    public function prepare($statement)
    {
        $pdo = $this->getPDO();
        return $pdo->prepare($statement);
    }

    
	public function toObject($data) {
		return json_decode(json_encode($data));
	}

}