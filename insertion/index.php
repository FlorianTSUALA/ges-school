<?php

   //include "connect.php";
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
		
	

	
		for($row=3;$row<=$lastRow;$row++){
			
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
			$nationalite =  $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_nationalite).$row)->getValue()   ;
			$sexe =  $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_sexe).$row)->getValue()   ;

             //echo $prenom ;
			//recuperation des codes, id, classes

			$classe = salleDeClasseToClass($salle_classe);
  
		// 	List ($pays_id,$salle_classe_id,$annee_scolaire_id,$classe_id) = initialise_id();
		// 	List ($code_parcours, $code_antecedent_scolaire, $code, $matricule) = initialise_code();

		// 	$antecedent_scolaire_data = new Antecedent_scolaire($classe,$code_antecedent_scolaire);
		//    //insertion dans la bdd
		//    $antecedent_scolaire_id = $antecedent_scolaire_data->insertAntecedent_scolaire();
		
		// 	$eleve_data = new Eleve($code,$pays_id,$antecedent_scolaire_id,$matricule,$nom,$prenom,$sexe,$date_naissance,$lieu_naissance);
		// 	  //insertion dans la bdd
		//     $eleve_id = $eleve_data->insertEleve();
			
		//    echo $classe_id .' '.$salle_classe_id.' '.$eleve_id.' '.$annee_scolaire_id.' '.$code_parcours;
		   
		// 	$parcours_data = new Parcours($classe_id ,$salle_classe_id,$eleve_id,$annee_scolaire_id,$code_parcours);

		// 	//insertion dans la bdd
		// 	$parcours_data->insertParcours();

        //     var_dump($antecedent_scolaire_id);			
 
		}
		 
		$i++;
		
		if ($i == $excel_Obj->getSheetCount()) 
				break;    
		$col2 =13; $row2=2;		
		echo $value=$worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col2).$row2)->getOldCalculatedValue();

    }




?>