<?php
   require_once "fonctions.php";

  

class Antecedent_scolaire {
 
 
    public  $classe;
    public  $code;

   public function __construct($classe,$code ){
      $this->classe = $classe;
      $this->code = $code;
    
   }

   // iinsere une donnée dans la table antecedent_scolaire
   
   function insertAntecedent_scolaire(){
         global $pdo;
         $sql = "INSERT INTO antecedent_scolaire (code, classe)
         VALUES (:code,:classe)";
         $res = $pdo->prepare($sql);
         $res->execute(["code"=>$this->code,"classe"=>$this->classe]);

         //recupere l'id de l'enregistrement nouvellement creéé

        $requete = $pdo->query('SELECT * FROM antecedent_scolaire');
        while( $donnees =  $requete->fetch()){
        if ($donnees['code'] === $this->code)
        return $donnees['id'];   

 
      }
   }

}



?>