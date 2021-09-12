<?php
     // include "connect.php"; 

class Parcours {
 
    public  $classe_id ;
    public  $salle_classe_id ;
    public  $eleve_id;
    public  $annee_scolaire_id;
    public  $code;
   
 

   public function __construct($classe_id ,$salle_classe_id,$eleve_id,$annee_scolaire_id,$code ){
    $this->classe_id = $classe_id;
    $this->salle_classe_id = $salle_classe_id;
    $this->eleve_id = $eleve_id;
    $this->annee_scolaire_id = $annee_scolaire_id;
    $this->code = $code;
   
   }

   function insertParcours(){
      global $pdo;
      $sql = "INSERT INTO parcours (classe_id ,salle_classe_id,eleve_id,annee_scolaire_id,code )
      VALUES (:classe_id ,:salle_classe_id,:eleve_id,:annee_scolaire_id,:code)";
      $res = $pdo->prepare($sql);
      $res->execute(["classe_id"=>$this->classe_id ,"salle_classe_id"=>$this->salle_classe_id,"eleve_id"=>$this->eleve_id,"annee_scolaire_id"=>$this->annee_scolaire_id,"code"=>$this->code]);
 

 }

}



?>