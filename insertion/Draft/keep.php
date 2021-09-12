<?php

   include "connect.php";
   include "fonctions.php";
   include "eleve.php";
   include "antecedent_scolaire.php";
   include "parcours.php";


require_once "Classes/PHPExcel.php";
$path="fichierWord/comelinesListe.xlsx";

$reader= PHPExcel_IOFactory::createReaderForFile($path);
//$Reader->setReadDataOnly(true);
$excel_Obj = $reader->load($path);
$i = 0;

	
	$index_classe = 1;
	$index_antecedent_scolaire = 2;
	$index_nom = 3;
	$index_prenom = 4;
	$index_date_naissance = 5;
	$index_lieu_naissance = 6;
	$index_nationalite = 7;
    $index_sexe = 8;
    $annee_scolaire = '2020-2021';
	

	while ($excel_Obj->setActiveSheetIndex($i))
	{
		$worksheet=$excel_Obj->getSheet($i);
		$Worksheet = $excel_Obj->getActiveSheet();
		$lastRow = $worksheet->getHighestDataRow();
        $colomncount = $worksheet->getHighestDataColumn();
		$colomncount_number=PHPExcel_Cell::columnIndexFromString($colomncount);
		
	

	
		for($row=3;$row<=$lastRow-3;$row++){
			
		
			$val1= 25569;
			$val2= 86400;
			$salle_classe =  $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_classe).$row)->getValue()   ;
			$antecedent_scolaire  =  $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_antecedent_scolaire).$row)->getValue()   ;
			$nom =  $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_nom).$row)->getValue()   ;
			$prenom =  $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_prenom).$row)->getValue()   ;
			$inline = $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_date_naissance).$row)->getValue();   		
			
				$timestamp = ($inline - $val1) * $val2 ; 
				$date_naissance =  date("d/m/y",$timestamp)  ;
			
			
			$lieu_naissance =  $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_lieu_naissance).$row)->getValue()   ;
			//$nationalite =  $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_nationalite).$row)->getValue()   ;
			$sexe =  $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_sexe).$row)->getValue()   ;
			

		}
		 
		$i++;
		
		if ($i == $excel_Obj->getSheetCount()) 
				break;    
		$col2 =13; $row2=2;		
		echo $value=$worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col2).$row2)->getOldCalculatedValue();

    }

  // $classe = salleDeClasseToClass($salle_classe);
  
   //List ($code_parcours, $code_antecedent_scolaire, $code, $matricule) = initialise_code();
     
  // echo $nationalite.' ' ;


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

   $antecedent_scolaire_id = 3 ;


$eleve_data = new Eleve($code,$pays_id,$antecedent_scolaire_id,$matricule,$nom,$prenom,$sexe,$date_naissance,$lieu_naissance);
$antecedent_scolaire_data = new Antecedent_scolaire($classe,$code_antecedent_scolaire);
//$parcours_data = new Parcours($classe_id,$salle_classe_id,$eleve_id,$annee_scolaire_id,$code_parcours);

echo $code.' '.$pays_id.' '.$code_antecedent_scolaire.' '.$matricule.' '.$nom.' '.$prenom.' '.$sexe.' '.$date_naissance.' '.$lieu_naissance ;
 $eleve_data->insertEleve() ;

 var_dump($eleve_data);
//echo salleDeClasseToClass($salle_classe);


$code = "ELEV_1598610091" ;
$pays_id = 10 ;
$antecedent_scolaire_id = 2;
$matricule = '2019-09-15 08:00:00A000';
$nom = 'ndoho';
$prenom = 'cabrel';
$sexe = 'M';
$date_naissance = '2020-08-28';
$lieu_naissance = "bandja";

$eleve_data = new Eleve($code,$pays_id,$antecedent_scolaire_id,$matricule,$nom,$prenom,$sexe,$date_naissance,$lieu_naissance);
$eleve_data->insertEleve() ;
?>