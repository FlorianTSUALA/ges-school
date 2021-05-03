<?php

namespace Core\Database;

use PDO;
use Exception;
use Core\Config;
use Core\BaseApp;
use PDOException;
use function Core\Helper\vd;

use ClanCats\Hydrahon\Builder;
use ClanCats\Hydrahon\Query\Sql\FetchableInterface;

class HydrahonDatabase extends Database
{
    use QueryTrait;

    public function __construct($db_name='ktame', $db_user='root', $db_host = 'localhost', $db_pass = '', $db_charset='UTF-8')
    {
        $config = Config::getInstance("config/config.php");
        if($db_name == 'ktame'){
            $db_name = $config->get('db_name');
            $db_user = $config->get('db_user');
            $db_host = $config->get('db_host');
            $db_pass = $config->get('db_pass');
        }
        parent::__construct($db_name, $db_charset, $db_user, $db_host, $db_pass);
    }

    protected function getPDO()
    {
        $config = Config::getInstance("config/config.php");

        $this->db_name = $config->get('db_name');
        $this->db_user = $config->get('db_user');
        $this->db_host = $config->get('db_host');
        $this->db_pass = $config->get('db_pass');


        if ($this->pdo === null) {
            try {
                // $pdo = new PDO("mysql:dbname=". $this->db_name .";host=". $this->db_host , $this->db_user, $this->db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"));
                //$pdo = new PDO("mysql:dbname=". $this->db_name .";host=". $this->db_host, $this->db_user, $this->db_pass, array('charset'=>'utf8mb4'));
                $this->pdo = new PDO("mysql:host=". $this->db_host.";dbname=". $this->db_name .";charset=utf8mb4", $this->db_user, $this->db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"));
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $ex) {
                vd($ex);
                die($this->db_host);

                BaseApp::abort(502, "Erreur de connexion avec la base de données !!!");
            }
        }
        return $this->pdo;
    }

    public function builder()
    {
        // create a new mysql query builder
        $connection = $this->getPDO();
        $this->builder = new Builder('mysql', function ($query, $queryString, $queryParameters) use ($connection) {
            $statement = $connection->prepare($queryString);
            try {
                $statement->execute($queryParameters);
            } catch (Exception  $e) {
                vd($e);
                die();
                vd($e->getMessage());
            }

            // when the query is fetchable return all results and let hydrahon do the rest
            // (there's no results to be fetched for an update-query for example)
            if ($query instanceof FetchableInterface) {
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            }
        });
        return $this->builder;
    }
}
