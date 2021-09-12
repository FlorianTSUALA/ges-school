<?php
  // include "excelVariables.php";
   //include "connect.php";
   require_once "Date.php";

    function genCode($value1){
     return strtoupper(substr( $value1, 0, 4)."_".Date('U'));
    }

    function round_up($value, $places)
	{
		$mult = pow(10, abs($places));
		return $places < 0 ?
		ceil($value / $mult) * $mult :
			ceil($value * $mult) / $mult;
	}
 
    function initialise_code()
    {


        return array (genCode('parcours'),genCode('antecedent_scolaire'),genCode('eleve'),genCode('matricule'));

    }

    
    function salleDeClasseToClass( $salle_classe)
    {
     return substr( $salle_classe,0,-1);
       
    }


    function initialise_id()
    { 
      global $nationalite, $pdo, $salle_classe,$annee_scolaire,$classe;


        $requete = $pdo->query('SELECT * FROM pays');
  
        while( $donnees =  $requete->fetch()){
     
            if ($donnees['libelle']===$nationalite)
            $pays_id = $donnees['id'];
        }
        $requete->closeCursor();
     
        $requete1 = $pdo->query('SELECT * FROM salle_classe');
       
        while( $donnees =  $requete1->fetch()){
     
            if ($donnees['libelle']===$salle_classe)
            $salle_classe_id = $donnees['id'];
        }
        $requete1->closeCursor();
     
        $requete2 = $pdo->query('SELECT * FROM annee_scolaire');
       
        while( $donnees =  $requete2->fetch()){
     
            if ($donnees['libelle'] === $annee_scolaire)
            $annee_scolaire_id = $donnees['id'];
        }
        $requete2->closeCursor();
     
        $requete3 = $pdo->query('SELECT * FROM classe');
       
        while( $donnees =  $requete3->fetch()){
     
            if ($donnees['libelle'] === $classe)
            $classe_id = $donnees['id'];
        }
        $requete3->closeCursor();

        return array ($pays_id,$salle_classe_id,$annee_scolaire_id,$classe_id); ;

    }

?>