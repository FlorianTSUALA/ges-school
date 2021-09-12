<?php

   include "connect.php";
   include "fonctions.php";
   include "eleve.php";
   include "antecedent_scolaire.php";
   include "parcours.php";
   include "execelVariables.php";

 



  $antecedent_scolaire_data = new Antecedent_scolaire($classe,$code_antecedent_scolaire);



$eleve_data = new Eleve($code,$pays_id,$antecedent_scolaire_id,$matricule,$nom,$prenom,$sexe,$date_naissance,$lieu_naissance);

?>