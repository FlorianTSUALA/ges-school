<?php

namespace App\Controller;

// require dirname(dirname(__DIR__)). '/lib/phpe/vendor/autoload.php';
use App\App;
use DateTime;
use App\Helpers\S;

use App\Model\Pays;
use App\Model\Eleve;
use App\Model\Classe;
use Core\Routing\URL;
use App\Model\Parcours;
use Core\Session\Request;
use App\Model\SalleClasse;

use App\Model\AnneeScolaire;
use function Core\Helper\dd;

use App\Model\StatutApprenant;
use App\Repository\EleveRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Controller\ExcelControllerTrait;
use App\Controller\ExcellEleveInsertionTrait;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

// use App\Controller\Admin\AppController;
// https://jsfiddle.net/GlennSuperdude/4u6xp3t3/88
// https://github.com/tabalinas/jsgrid

class ExcelController extends AppController
{
    use ExcelControllerTrait, ExcellEleveInsertionTrait;
    /**
     * Initialise les Models qu'on charge dans ce controller
     **/
    public function __construct()
    {
        parent::__construct();
    }


    public function index() {
        // https://phpspreadsheet.readthedocs.io/en/latest/topics/reading-files/

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

    public function old_excell()
    {
        $inputFileType = 'Xlsx';
        $path_excel_files = '../ressources/data/excel_files/';
        $file ="2020_CPA_T1Note.xlsx";
        $inputFileName =  $path_excel_files .$file;
        // Create a new Reader of the type defined in $inputFileType
        $reader = IOFactory::createReader($inputFileType);
        // Load $inputFileName to a PhpSpreadsheet Object
        $spreadsheet = $reader->load($inputFileName);



        
        //read excel data and store it into an array
        $xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
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
        die("Error");
        // Reader\19_Reading_worksheet_information_without_loading_entire_file.php


        // php -S localhost:8000 -t vendor/phpoffice/phpspreadsheet/samples
    }


    public function draft()
    {
        $path_excel_files = '../ressources/data/excel_files/';

        //** */
            // $spreadsheet = new Spreadsheet();
            // $sheet = $spreadsheet->getActiveSheet();
            // $sheet->setCellValue('A1', 'Hello World !');
            // $writer = new Xlsx($spreadsheet);
            // $writer->save('../hello world.xlsx');
            //create directly an object instance of the IOFactory class, and load the xlsx file
        //** */


        $fxls = $path_excel_files.'excel-file_1.xlsx';
        // $spreadsheet = IOFactory::load($fxls);
        $reader = IOFactory::createReaderForFile($fxls);

        $spreadsheet = $reader->load($fxls);

        //read excel data and store it into an array
        $xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
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

        $classe = "";

        dd("ok");

        //ANTECEDANT SCOLAIRE
        $code_antecedent_scolaire = $this->antecedent_scolaire->genCode();
        $data_antecedent_scolaire = [
            'code' => $code_antecedent_scolaire,
            'classe' => $classe,
            
        ];
        $result_antecedent_scolaire = $this->antecedent_scolaire->save($data_antecedent_scolaire);
        $id_antecedent_scolaire = $this->antecedent_scolaire->id($code_antecedent_scolaire);

    

        //INFO ELEVE
        $code_eleve = $this->eleve->genCode();

        
        $matricule =  (new EleveRepository())->getMatricule() ;

        $photo_name = 'no-photo.jpg';
      


        $data_eleve = [
            'code' => $code_eleve,
            'matricule' => $matricule,
            'nom' => Request::getSecParam('nom_eleve', ''),
            'prenom' => Request::getSecParam('prenom_eleve', ''),
            
            'lieu_naissance' => Request::getSecParam('lieu_naissance_eleve', ''),
            'date_naissance' => Request::getSecParam('date_naissance_eleve', ''),
            'sexe' => Request::getSecParam('sexe_eleve', ''),
            'photo' => $photo_name,
            Eleve::PAYS_ID => $this->pays->id(Request::getSecParam('pays_eleve', ''), Pays::LIBELLE),
            'anciennete' => (Request::getSecParam('anciennete_eleve', '') === '')? 0 : Request::getSecParam('anciennete_eleve', ''),
           
            Eleve::GROUPE_FAMILIAL_ID => null,
       
            Eleve::ANTECEDENT_SCOLAIRE_ID => $id_antecedent_scolaire,
        ];

        $result_eleve = $this->eleve->save($data_eleve);
        $id_eleve = $this->eleve->id($code_eleve);

        $id_salle_classe = $this->salle_classe->id(Request::getSecParam('salle_classe_eleve', ''), SalleClasse::LIBELLE);
        $id_salle_classe = ($id_salle_classe == false) ? null : $id_salle_classe;

        $id_annee_scolaire = $this->annee_scolaire->id(Request::getSecParam('annee_scolaire', ''), AnneeScolaire::LIBELLE);
        $code_annee_scolaire = $this->annee_scolaire->code(Request::getSecParam('annee_scolaire', ''), AnneeScolaire::LIBELLE);
        //PARCOURS ELEVE
        $code_parcours = $this->parcours->genCode();
        $data_parcours = [
            'code' => $code_parcours,
            Parcours::ANNEE_SCOLAIRE_ID => $id_annee_scolaire,
            'date_inscription' => (new DateTime('NOW'))->format('Y-m-d H:i:s'),
            Parcours::ELEVE_ID => $id_eleve,
            Parcours::STATUT_APPRENANT_ID => $this->statut_apprenant->id(Request::getSecParam('statut_eleve', ''), StatutApprenant::LIBELLE),
            Parcours::CLASSE_ID => $this->classe->id(Request::getSecParam('classe_eleve', ''), Classe::LIBELLE),
            Parcours::SALLE_CLASSE_ID => $id_salle_classe,
        ];

        $result_parcours = $this->parcours->save($data_parcours);
        $id_parcours = $this->parcours->id($code_parcours);

    }
}
