<?php

namespace App\Controller;

use Core\Routing\URL;
use function Core\Helper\dd;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Controller\ExcelControllerTrait;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

// use App\Controller\Admin\AppController;
// https://jsfiddle.net/GlennSuperdude/4u6xp3t3/88
// https://github.com/tabalinas/jsgrid

class ExcelController extends AppController
{
    use ExcelControllerTrait, ExcellControllerTraitEleveLoader;
    /**
     * Initialise les Models qu'on charge dans ce controller
     **/
    public function __construct()
    {
        parent::__construct();
    }


    public function loader() {
        // https://phpspreadsheet.readthedocs.io/en/latest/topics/reading-files/
        $this->app->setTitle('Chargement des données  - ' . $this->organisation);
        $route = 'loader';
        $this->render('sections.data_loader.index', compact('route'));
    }


    public function display_jsgrid() {

    }

    public function saving_data() {

    }

    public function prepare_data()
    {
        $path= URL::storage('data') ."excel/comelinesListe.xlsx";
        $ligne_debut = 3;
        $numero_feuille = 0;

        $excel_Obj = IOFactory::load($path);
        // $reader= IOFactory::createReaderForFile($path);
        //$Reader->setReadDataOnly(true);
        // $excel_Obj = $reader->load($path);
        
        //read excel data and store it into an array
        $xls_data = $excel_Obj->getActiveSheet()->toArray(null, true, true, true);
        /* $xls_data contains this array:
        [1=>['A'=>'Domain', 'B'=>'Category', 'C'=>'Nr. Pages'], 2=>['A'=>'CoursesWeb.net', 'B'=>'Web Development', 'C'=>4000], 3=>['A'=>'MarPlo.net', 'B'=>'Courses & Games', 'C'=>15000]]
        */

        //now it is created a html table with the excel file data
        $html_tb ='<table border="1"><tr><th>'. implode('</th><th>', $xls_data[1]) .'</th></tr>';
        $nr = count($xls_data); //number of rows
        for($i=2; $i<=$nr; $i++){
        $html_tb .='<tr><td>'. implode('</td><td>', $xls_data[$i]) .'</td></tr>';
        }
        $html_tb .='</table>';

        echo $html_tb; 
        dd('ok');

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
        
        $nbre_feuille = $excel_Obj->getSheetCount();

        while ($excel_Obj->setActiveSheetIndex($numero_feuille))
        {
            $worksheet=$excel_Obj->getSheet($numero_feuille);
            $Worksheet = $excel_Obj->getActiveSheet();
            $lastRow = $worksheet->getHighestDataRow();
            $colomncount = $worksheet->getHighestDataColumn();
            $colomncount_number = Coordinate::columnIndexFromString($colomncount);

            echo "  <tr>
                        <td>nationnalité</td>
                        <td>Salle de classe</td>
                        <td>annee scolaire</td>
                        <td>classe</td>
                        <td>nom</td>
                        <td>prenom</td>
                        <td>sexe</td>
                        <td>date_naissance</td>
                        <td>lieu_naissance</td>
                        <td>antecedent_scolaire</td>
                    </tr>
            ";
            for($row=3;$row<=$lastRow;$row++){
                $val1= 25569;
                $val2= 86400;
                $salle_classe =  $worksheet->getCell(Coordinate::stringFromColumnIndex($index_classe).$row)->getValue()   ;
                $antecedent_scolaire  =  $worksheet->getCell(Coordinate::stringFromColumnIndex($index_antecedent_scolaire).$row)->getValue()   ;
                $nom =  $worksheet->getCell(Coordinate::stringFromColumnIndex($index_nom).$row)->getValue()   ;
                $prenom =  $worksheet->getCell(Coordinate::stringFromColumnIndex($index_prenom).$row)->getValue()   ;
                $inline = $worksheet->getCell(Coordinate::stringFromColumnIndex($index_date_naissance).$row)->getValue();   		
                
                $timestamp = ($inline - $val1) * $val2 ; 
                $date_naissance =  date("d/m/y",$timestamp)  ;
                            
                $lieu_naissance =  $worksheet->getCell(Coordinate::stringFromColumnIndex($index_lieu_naissance).$row)->getValue()   ;
                $nationalite =  $worksheet->getCell(Coordinate::stringFromColumnIndex($index_nationalite).$row)->getValue()   ;
                $sexe =  $worksheet->getCell(Coordinate::stringFromColumnIndex($index_sexe).$row)->getValue()   ;
                $classe = salleDeClasseToClass($salle_classe);

                echo "  <tr>
                            <td>$nationalite</td>
                            <td>$salle_classe</td>
                            <td>$annee_scolaire</td>
                            <td>$classe</td>
                            <td>$nom</td>
                            <td>$prenom</td>
                            <td>$sexe</td>
                            <td>$date_naissance</td>
                            <td>$lieu_naissance</td>
                            <td>$antecedent_scolaire</td>
                        </tr>
                ";

                echo "$nationalite, $salle_classe,$annee_scolaire,$classe";
    
                // List ($pays_id,$salle_classe_id,$annee_scolaire_id,$classe_id) = initialise_id();
                // List ($code_parcours, $code_antecedent_scolaire, $code, $matricule) = initialise_code();

                // $antecedent_scolaire_id = $this->insert_antecedent_scolaire($classe,$code_antecedent_scolaire);
                // $eleve_id =  $this->insert_eleve($code,$pays_id,$antecedent_scolaire_id,$matricule,$nom,$prenom,$sexe,$date_naissance,$lieu_naissance);
                // $parcours_id = $this->insert_parcours($classe_id ,$salle_classe_id,$eleve_id,$annee_scolaire_id,$code_parcours);
    
            }
            
            $i++;
            
            if ($i == $nbre_feuille) 
                    break;    
            $col2 =13; $row2=2;		
            echo $value = $worksheet->getCell(Coordinate::stringFromColumnIndex($col2).$row2)->getOldCalculatedValue();

        }

    }

}
