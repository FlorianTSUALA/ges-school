<?php

namespace Core\Database;

use PDO;

class Database
{

    protected $db_name;
    protected $db_user;
    protected $db_host;
    protected $db_charset;
    protected $db_pass;

    /**
     * @var \PDO
     */
    protected $pdo;
    
    /**
     * @var ClanCats\Hydrahon\Builder
     */
    protected $builder;


    public function __construct($db_name, $db_charset, $db_user, $db_host, $db_pass)
    {
        $this->db_host = $db_host;
        $this->db_charset = $db_charset;
        $this->db_user = $db_user;
        $this->db_name = $db_name;
        $this->db_pass = $db_pass;
    }

    function UniqCode($prefix="ZX",$length=8)
    {
        return substr(strtoupper(uniqid($prefix)), 0, $length);
    }


    




}