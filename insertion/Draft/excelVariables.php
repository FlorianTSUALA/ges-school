<?php

   require_once "connect.php";
   require_once "fonctions.php";
   require_once "eleve.php";
   require_once "antecedent_scolaire.php";
   require_once "parcours.php";


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
			$nationalite =  $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_nationalite).$row)->getValue()   ;
			$sexe =  $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_sexe).$row)->getValue()   ;
			

		}
		 
		$i++;
		
		if ($i == $excel_Obj->getSheetCount()) 
				break;    
		$col2 =13; $row2=2;		
		echo $value=$worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col2).$row2)->getOldCalculatedValue();

    }



?>