<?php

require_once("helpers/config.php");

class DBHelper {

  static $DEBUG = true;
  private static $instance = null;
  private $conn;
  
  private $host = HOST;
  private $user = USER;
  private $pass = PASSWORD;
  private $name = DBNAME;
   
    private function __construct()
    {

      $lien_db = "mysql:host={$this->host};dbname={$this->name}";

      try {
        
        $this->conn = new PDO($lien_db, $this->user,$this->pass);  
        
        if(self::$DEBUG){
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
      } catch (PDOException $e) {
          die("Echec connexion: ".$e->getMessage());
      }

    }
    
    public static function getInstance()
    {
      if(!self::$instance){
        self::$instance = new DBHelper();
      }
    
      return self::$instance; 
    }
    
    public function getConnection()
    {
      return $this->conn;
    }

    public static function connexion(){
      return DBHelper::getInstance()->getConnection();
    }

    public static function prepare($sql){
      return DBHelper::getInstance()->getConnection()->prepare($sql);
    }

  //DB Function utility for Generic CRUD

    public static function sort($table, $critere, $parametre){
      $sql = "select * from {$table} order by {$critere} {$parametre};";
      $req = DBHelper::connexion()->prepare($sql);
      $req->execute();
      $result = $req->fetchAll();
      return $result;
    }

    public static function sortBy ($table, $critere, $parametre, $champs, $mot_cle){
      $clause_where = " where";
      if(!empty($champs)){
        foreach($champs as $champ){
          $clause_where  .= " {$champ} LIKE '%{$mot_cle}%' OR";
        }
        $clause_where = substr($clause_where, 0, -2);
      }

      
      $sql = "select * from $table $clause_where order by $critere $parametre;";
      $req = DBHelper::connexion()->prepare($sql);
      $req->execute();
      $result = $req->fetchAll();
      return $result;
    }


    public static function execSelectOne($sql){
      $req = DBHelper::connexion()->prepare($sql);
      $req->execute();
      $result = $req->fetch();
      return $result;
    }


    public static function execSelectAll($sql){
      $req = DBHelper::connexion()->prepare($sql);
      $req->execute();
      $result = $req->fetchAll();
      return $result;
    }

    public static function getAll($table){
      $sql = "select * from $table order by date_modification desc;";
      $req = DBHelper::connexion()->prepare($sql);
      $req->execute();
      $result = $req->fetchAll();
      return $result;
    }

    public static function get($table, $id){
      $sql = "select * from $table where id=$id;";
      $req = DBHelper::connexion()->prepare($sql);
      $req->execute();
      $result = $req->fetch();
      return $result;
    }

    public static function getLast($table, $total = 1){
      $sql = "select * from $table order by date_modification desc limit $total; ";
      $req = DBHelper::connexion()->prepare($sql);
      $req->execute();
      $result = $req->fetchAll();
      return $result;
    }

  public static function getCount($table){
      $sql = "select count(*) as total from {$table};";
      $req = DBHelper::connexion()->prepare($sql);
      $req->execute();
      $result = $req->fetch();
      return $result['total'];
  }

  public static function delete($table, $id){
      if ($id) {
          $sql = "delete from {$table} where id={$id};";
          $req = DBHelper::connexion()->prepare($sql);
          $statut =$req->execute();
          return $statut;
      }
  }

  public static function insert($table, $data){
      $str_val = '';
      $str_label = '';
      
      foreach($data as $key => $value){
          $str_label .= " {$key},";
          $str_val .= ":{$key},";
      }

      $str_label = substr($str_label, 0, -1);
      $str_val = substr($str_val, 0, -1);

      $sql = "insert into {$table} ($str_label) values ($str_val);";
      $req = DBHelper::prepare($sql);
      
      foreach($data as $key => $value){
        $req->bindValue(":$key", $value);
      }
      $statut = $req->execute();
      return $statut;
  }

  public static function update($table, $id, $data){
      $str_query = "";
      
      foreach($data as $key => $value){
          $str_query .= "{$key}=:{$key},";
      }
      
      $str_query = substr($str_query, 0, -1);

      $sql = "update {$table} set {$str_query} where id=$id";
      
      $req = DBHelper::prepare($sql);

      foreach($data as $key => $value){
        $req->bindValue(":{$key}", $value);
      }

      $statut = $req->execute(); 
      return $statut;
  }

  // OTHER USABLE FUNCTION
  //protect against SQL injection attacks
  
  /*public function antisql($data)
  {
    if (is_array($data))
    {
      foreach ($data as $name=>$value)
      {
         $data[$name] = mysql_real_escape_string($value);
      }
      }
      else
      {
        $data = mysql_real_escape_string($data);
      }
    return $data;
  }*/

    public static function buildLikeClause($field, $text)
    {
      $keyword = explode(' ', $text);
      $clause = '';

      foreach($keyword as $word){
        $clause .= (' '.$field . ' LIKE "%'. $word.'%" OR');
      }
      
      $clause =  substr($clause, 0, -2);
      return $clause;
    }

    public static function slugify($text)
    {
      return $text;
    }


    // https://lucidar.me/en/web-dev/in-php-how-to-display-date-in-french/
  public static function dateToFrench($date, $format="l j F Y") 
  {
      $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
      $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
      $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
      $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
      return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date) ) ) );
  }

  public static function dateToFrenchShort($date, $format="j F Y") 
  {
      return self::dateToFrench($date, $format);
  }

  public static function getDay($date, $format="j F Y") 
  {
    return explode(" ", self::dateToFrenchShort($date, $format))[0];
  }

  public static function getMois($date, $format="j F Y") 
  {
    return substr(explode(" ", self::dateToFrenchShort($date, $format))[1], 0, 4);
  }

  public static function getAnnee($date, $format="j F Y") 
  {
    // var_dump(self::dateToFrenchShort($date, $format)); die();
    return explode(" ", self::dateToFrenchShort($date, $format))[2];
  }
  
}