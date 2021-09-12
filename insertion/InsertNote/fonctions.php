<?php
  // include "excelVariables.php";
   include "connect.php";
   require_once "composer.php";
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
      global  $pdo, $salle_classe,$annee_scolaire,$trimestre,$salle_classe_id,$libelle_cours;

     
        $requete1 = $pdo->query('SELECT * FROM salle_classe');      
        while( $donnees =  $requete1->fetch()){    
            if ($donnees['libelle']===$salle_classe)
            $salle_classe_id = $donnees['id'];
        }    $requete1->closeCursor();

     
        $requete2 = $pdo->query('SELECT * FROM annee_scolaire');      
        while( $donnees =  $requete2->fetch()){    
            if ($donnees['libelle'] === $annee_scolaire)
            $annee_scolaire_id = $donnees['id'];
        }   $requete2->closeCursor();

     

        $requete4 = $pdo->query('SELECT * FROM trimestre ');
        while( $donnees =  $requete4->fetch()){
            if ($donnees['libelle'] === $trimestre)
            $trimestre_id = $donnees['id'];
        }   $requete4->closeCursor();

        $requete6 = $pdo->query('SELECT * FROM salle_classe');
        while( $donnees =  $requete6->fetch()){
            if ($donnees['libelle'] === $salle_classe)
            $classe_id = $donnees['classe_id'];
            $personnel_id = $donnees['personnel_id'];
        }   $requete6->closeCursor();


        /* //'pays.libelle'=>'pays'
        //->join('pension_classe', 'pension_classe.classe_id', '=', 'parcours.classe_id')
         //$requete6 = $pdo->query('SELECT cours_id, matiere_id FROM cours,matiere,affectation_matiere_classe',
         // WHERE matiere.id = affectation_matiere_classe.matiere_id
         // AND  affectation_matiere_classe.id = cours.affectation_matiere_classe_id
        // );*/


        $requete5 = $pdo->query('SELECT * FROM periode');
        while( $donnees =  $requete5->fetch()){
            if ($donnees['trimestre_id'] === $trimestre_id)
            $periode_id = $donnees['id'];

        }   $requete5->closeCursor();



        return array ($salle_classe_id,$annee_scolaire_id,$trimestre_id,$classe_id,$periode_id,$personnel_id); 

    }


    function recupereIdEleve($nom,$prenom,$date_naissance){
       
        global  $pdo;
        
       
        $requete8 = $pdo->query('SELECT * FROM eleve');
        while( $donnees =  $requete8->fetch()){
            if ($donnees['nom'] === $nom && $donnees['prenom'] === $prenom  ){
                $date0 = str_replace('/','-',$date_naissance);
                 $date1 = substr( $date0, 0, 8);
                 $date2 = substr( $donnees['date_naissance'], 2, 8);
                //echo $date1 .'zero macabo'.$date2;
                if($date1 === $date2){ //echo 'tintin'.$donnees['id'];
                   return $donnees['id'];
                }
            }
        }   $requete8->closeCursor();
       

        
    };

    function recupereIdMatiereCours($salle_classe_id){

        global  $pdo;
        $sql = " SELECT c.id as cours_id, m.id as matiere_id, c.libelle as libelle_cours
        FROM matiere as m
        JOIN affectation_classe_matiere AS a ON m.id = a.matiere_id
        JOIN cours AS c ON a.id = c.affecter_classe_matiere_id
        WHERE c.salle_classe_id = $salle_classe_id " ;

        var_dump($sql);

        $requete7 = $pdo->query($sql);
        while( $donnees =  $requete7->fetch()){
            $CoursMatiere_ids[] = $donnees;
        }   $requete7->closeCursor();
  
       return  $CoursMatiere_ids;
    }

    //foreach
    function recupereIdCoursMatiere($libelle_cours){
       
        global  $CoursMatiere_ids;

        foreach ($CoursMatiere_ids as $CoursMatiere_id) {
            if($CoursMatiere_id['libelle_cours']  === $libelle_cours)
            {
                $cours_id =$CoursMatiere_id['cours_id'] ;
                $matiere_id =$CoursMatiere_id['matiere_id'] ;

             return  array($cours_id ,$matiere_id);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
            } 
          }
    };
    //$composer1->insertNote();
    


?>