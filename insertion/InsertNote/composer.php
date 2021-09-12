<?php
      include "connect.php"; 
  


class Composer {
 
    public  $classe_id ;
    public  $matiere_id ;
    public  $cours_id;
    public  $eleve_id;
    //public  $annee_scolaire_id;
    public  $periode_id;
    public  $personnel_id;
    public  $code;
    public  $note;

   
 

   public function __construct($classe_id ,$matiere_id,$cours_id,$eleve_id,$periode_id,$personnel_id,$code,$note ){
    $this->classe_id = $classe_id;
    $this->matiere_id = $matiere_id;
    $this->cours_id = $cours_id;
    $this->eleve_id = $eleve_id;
    $this->periode_id = $periode_id;
    $this->personnel_id = $personnel_id;
    $this->code = $code;
    $this->note = $note;
   
   }
   

   
   function insertNotes(){
      global $pdo;
      $sql = "INSERT INTO composer (classe_id ,matiere_id,cours_id,eleve_id,periode_id,personnel_id,code,note )
      VALUES (:classe_id ,:matiere_id,:cours_id,:eleve_id,:periode_id,:personnel_id,:code ,:note )";
      $res = $pdo->prepare($sql);
      $res->execute(["classe_id"=>$this->classe_id ,"matiere_id"=>$this->matiere_id ,"cours_id"=>$this->cours_id,"eleve_id"=>$this->eleve_id,"periode_id"=>$this->periode_id ,"personnel_id"=>$this->personnel_id,"code"=>$this->code,"note"=>$this->note]);
 

     /* global $pdo;
      $sql = "INSERT INTO eleve (code, pays_id,antecedent_scolaire_id, matricule,nom, prenom,sexe,date_naissance,lieu_naissance)
           VALUES (:code,:pays_id,:antecedent_scolaire_id,:matricule,:nom,:prenom,:sexe,:date_naissance,:lieu_naissance)";
           $res = $pdo->prepare($sql);
           $res->execute(["code"=>$this->code,"pays_id"=>$this->pays_id,"antecedent_scolaire_id"=>$this->antecedent_scolaire_id,"matricule"=>$this->matricule,"nom"=>$this->nom,"prenom"=>$this->prenom,"sexe"=>$this->sexe,"date_naissance"=>$this->date_naissance,"lieu_naissance"=>$this->lieu_naissance]);
          
						 

      $sql = "INSERT INTO `users`(`firstname`, `lastname`) VALUES (:firstname,:lastname)";
      $res = $pdo->prepare($sql);
      $exec = $res->execute(array(":firstname"=>$firstname,":lastname"=>$lastname));*/

    
        }

}
 




?>