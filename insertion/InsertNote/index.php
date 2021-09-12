<?php

   include "connect.php";
   include "fonctions.php";
   require_once "composer.php";


require_once "../Classes/PHPExcel.php";
$path="../fichierWord/Note_Eleve.xlsx";

$reader= PHPExcel_IOFactory::createReaderForFile($path);
//$Reader->setReadDataOnly(true);
$excel_Obj = $reader->load($path);
$i = 0; $trimestre = 'premier trimestre';

	$index_nom = 2;
	$index_prenom = 3;
	$index_date_naissance = 4;
	$index_sexe = 5;
	$row_cours = 1;
	$val1= 25569;
	$val2= 86400;
    $annee_scolaire = '2020-2021';
	

	while ($excel_Obj->setActiveSheetIndex($i))
	{
		$worksheet=$excel_Obj->getSheet($i);
		$Worksheet = $excel_Obj->getActiveSheet();
		$lastRow = $worksheet->getHighestDataRow();
		$salle_classe = $worksheet->getTitle() ;
        $colomncount = $worksheet->getHighestDataColumn();
		$colomncount_number=PHPExcel_Cell::columnIndexFromString($colomncount);
	
	

		for($row=2;$row<=$lastRow;$row++){
			
			$nom =  $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_nom).$row)->getValue()   ;
			$prenom =  $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_prenom).$row)->getValue()   ;
			$inline = $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_date_naissance).$row)->getValue();   		
			
			$timestamp = ($inline - $val1) * $val2 ; 
			$date_naissance =  date("d/m/y",$timestamp)  ;
			$eleve_id = recupereIdEleve($nom,$prenom,$date_naissance);		    		    
			/*$sexe =  $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($index_sexe).$row)->getValue()   ;
			
			List ($salle_classe_id,$annee_scolaire_id,$trimestre_id,$classe_id,$periode_id,$personnel_id) = initialise_id();
		    $eleve_id = recupereIdEleve($nom,$prenom,$date_naissance);
		    $CoursMatiere_ids = recupereIdMatiereCours($salle_classe_id);
			
			//recuperation des codes, id, classes
			//aulieu de 27 mets à taille de fin de column plutot   */

			if(empty($nom) && empty($prenom) && empty($date_naissance ) ){
             //aller à la ligne suivante
			}
                else{
					for($col=6;$col<=27;$col++){

					
						$libelle_cours = $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col).$row_cours)->getValue();
						$note = $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col).$row)->getValue();
						$val = true; 
		
						 if(is_numeric($note)){
							echo ($libelle_cours.' '.$note."<br>");
							//List ($cours_id,$matiere_id) = recupereIdCoursMatiere($libelle_cours);			 
							//$code = genCode('composer');
							//$NoteEleve = new Composer($classe_id ,$matiere_id,$cours_id,$eleve_id,$periode_id,$personnel_id,$code,$note );
						   // $NoteEleve->insertNotes();
							//echo $classe_id.'a'.$matiere_id.'b'.$eleve_id.'c'.$cours_id.'d'.$periode_id.'e'.$personnel_id.'f'.$code.'g'.$note;
							
						 }else {
						   $note = $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col).$row)->getOldCalculatedValue() ;
						   if(is_numeric($note)){
							$val = false;   
						   $note = round_up($note,2);
						   $b=array($libelle_cours=>$note);
						   $a[] = $b ;
						}
						  
						   }
		
						  $note = $worksheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col).$row)->getValue() ;				
						 if(is_string($note) && !empty($note) && $val){
						   $b=array($libelle_cours=>$note);
						   $a[] = $b ;
						   
						 }
						 
					}
				}
				
			 
			$myJSON = json_encode($a);
			echo $myJSON.'<br>';
			$a = [];
			// insertion des moyenne et apppreciation dans la bdd et initialise $a au vide i.e. $a = [] 
		}
		 

		$i++;
		if ($i == $excel_Obj->getSheetCount()) 
				break;    
		
    }




?>