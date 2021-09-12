<?php
  
   require_once "connect.php";




class Eleve {
 
    public  $code;
    public  $pays_id ;
    public  $antecedent_scolaire_id ;
    public  $matricule;
    public  $nom;
    public  $prenom;
    public  $sexe;
    public  $date_naissance;
    public  $lieu_naissance;

   public function __construct($code,$pays_id ,$antecedent_scolaire_id,$matricule,$nom,$prenom,$sexe,$date_naissance,$lieu_naissance){
    $this->code = $code;
    $this->pays_id = $pays_id;
    $this->antecedent_scolaire_id = $antecedent_scolaire_id;
    $this->matricule = $matricule;
    $this->nom = $nom;
    $this->prenom = $prenom;
    $this->sexe = $sexe;
    $this->date_naissance = $date_naissance;
    $this->lieu_naissance = $lieu_naissance;
    
   }
      


   function insertEleve(){
    global $pdo;
  $sql = "INSERT INTO eleve (code, pays_id,antecedent_scolaire_id, matricule,nom, prenom,sexe,date_naissance,lieu_naissance)
       VALUES (:code,:pays_id,:antecedent_scolaire_id,:matricule,:nom,:prenom,:sexe,:date_naissance,:lieu_naissance)";
       $res = $pdo->prepare($sql);
       $res->execute(["code"=>$this->code,"pays_id"=>$this->pays_id,"antecedent_scolaire_id"=>$this->antecedent_scolaire_id,"matricule"=>$this->matricule,"nom"=>$this->nom,"prenom"=>$this->prenom,"sexe"=>$this->sexe,"date_naissance"=>$this->date_naissance,"lieu_naissance"=>$this->lieu_naissance]);
      
       //recupere l'id de l'enregistrement nouvellement creéé

       $requete = $pdo->query('SELECT * FROM eleve');
       while( $donnees =  $requete->fetch()){
       if ($donnees['code'] === $this->code)
       return $donnees['id']; 
       }
  }
  
  
} 



?>