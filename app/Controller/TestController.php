<?php

namespace App\Controller;

use App\Model\Eleve;
use Core\Model\Model;
use App\Model\DBTable;
use App\Model\Parcours;
use App\Helpers\Helpers;
use Core\Helper\DBHelper;
use Core\Session\Request;
use App\Model\PensionEleve;
use Core\HTML\FlashMessages;

use function Core\Helper\dd;
use function Core\Helper\vd;
use Spipu\Html2Pdf\Html2Pdf;
use App\Model\DossierMedical;
use App\Model\DossierParental;
use App\Model\StatutApprenant;
use App\Model\AntecedentScolaire;
use App\Repository\ClasseRepository;
use App\Repository\CantineRepository;
use App\Repository\DocumentRepository;
use App\Model\AffectationClasseMatiere;
use App\Repository\PersonnelRepository;
use ClanCats\Hydrahon\Query\Expression;
use App\Repository\ExemplaireRepository;
use App\Repository\AnneeScolaireRepository;
use Core\HTML\MessageFlash\FlashMessagesStatic;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use App\Repository\AffectationSalleClasseRepository;

class TestController extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('cycle');
    }

    public function test( )
    {
        $affectation_salle_eleve = (Parcours::table()
            ->select(
                [
                    'salle_classe.id' => 'salle_classe_id', 
                    'salle_classe.code' => 'salle_classe_code', 
                    'salle_classe.libelle' => 'salle_classe',

                    'classe.id' => 'classe_id',
                    'classe.code' => 'classe_code',
                    'classe.libelle' => 'classe',
                    
                    'statut_apprenant.id' => 'statut_apprenant_id',
                    'statut_apprenant.code' => 'statut_apprenant_code',
                    'statut_apprenant.libelle' => 'statut_apprenant',
                    
                    'eleve.id' => 'eleve_id',
                    'eleve.code' => 'eleve_code',
                    'eleve.nom' => 'eleve_nom',
                    'eleve.prenom' => 'eleve_prenom'
                ])
            ->join('eleve', 'eleve.id', '=', 'parcours.eleve_id')
            ->join('classe', 'classe.id', '=', 'parcours.classe_id')
            ->join('salle_classe', 'salle_classe.id', '=', 'parcours.salle_classe_id')
            ->join('statut_apprenant', 'statut_apprenant.id', '=', 'parcours.statut_apprenant_id')
            ->where('parcours.visibilite', 1)
            // ->where('annee_scolaire_id', $annee_scolaire_id)
            // ->where('classe_id', $classe_id)
            // ->groupBy('salle_classe.id','classe.id')
            // ->orderBy('eleve.nom')
            ->get());
        // vd($personnel_id);
        // foreach ($affectation_salle_eleve as $key => $item) {
        //     $data[$item['classe_code']][$key] = $item;
        //     // $data[$item['id']][$key] = $item;
        //  }
         
        //  ksort($data, SORT_NUMERIC);
       ( Helpers::groupBy($affectation_salle_eleve, 'classe'));
        dd($affectation_salle_eleve);
        // dd($data);
    }

    public function test_( $classe_id = 5)
    {
        $annee_scolaire_id = 3;
        $code = 'PERS_1598894111';
        
        $data =DBTable::getModel(DBTable::PERSONNEL)
        ->select(
            [
                'personnel.id'=> 'id', 
                'personnel.telephone'=> 'telephone',
                'salle_classe.libelle'=> 'classe', 
                'type_personnel.libelle'=> 'fonction', 
                'salle_classe.code'=> 'salle_classe_id', 
                new Expression("concat(personnel.nom,' ',personnel.prenom) as nom_complet"),
                'type_personnel.code' => 'type_personnel_id',
                'type_personnel.libelle' => 'type_personnel',
                'pays.id' => 'pays_id', 
                'pays.libelle' => 'pays', 
                'personnel.sexe' => 'sexe', 
                'personnel.email' => 'email', 
                'personnel.adresse' => 'adresse', 
                'personnel.login' => 'login', 
                'personnel.date_prise_service' => 'date_prise_service', 
                'personnel.date_fin_carriere' => 'date_fin_carriere', 
                'personnel.bibliographie' => 'bibliographie', 
                'personnel.assurance' => 'assurance', 
                'personnel.fonction' => 'fonction', 
                'personnel.pieces_jointes' => 'pieces_jointes', 
                'personnel.photo' => 'photo',
                'affectation_personnel_salle_classe.salle_classe_id' => 'salle_classe_id',
                // 'affectation_personnel_salle_classe.classe_id' => 'classe_id',
                'affectation_personnel_salle_classe.annee_scolaire_id' => 'annee_scolaire_id',
            ]
        )
        ->join('type_personnel', 'type_personnel.id', '=', 'personnel.type_personnel_id')
        ->join('affectation_personnel_salle_classe', 'affectation_personnel_salle_classe.personnel_id', '=', 'personnel.id')
        ->join('salle_classe', 'salle_classe.id', '=', 'affectation_personnel_salle_classe.salle_classe_id')
        ->join('pays', 'pays.id', '=', 'personnel.pays_id')
        ->where('personnel.visibilite', '=', 1)
        ->where('affectation_personnel_salle_classe.annee_scolaire_id', '=', $annee_scolaire_id)
        ->where('personnel.code', '=', $code)
        ->get();
        // 
        
        
            dd($data) ;
    }

    public function testSQL()
    {
        $repository = new AffectationSalleClasseRepository();
        $result = $repository->getEnseignantNonAffecte();
        dd($result);
    }

    public function testpdf()
    {
    
        $date_facturation = 'Mardi, 24 Novembre 2020';
        $eleve = 'kakambi franck';
        $classe = 'Petite-section';
        $reference = 'AC45FA4464';
        $remise = '156';
        $reste = '0';
        $solde_paye = '0';
        $sous_total = '0';
        $items = [];
        $this->renderPDF('reports.cantine', compact('date_facturation', 'eleve', 'classe', 'reference', 'remise', 'reste', 'solde_paye', 'sous_total', 'items'), 'facture_cantine' );  
    
    }

    public function testAlert()
    {
        $filter_by = 'ALL';
        $code = '';
        $start_date = '2022-01-01';
        // $end_date = '';
        
        $cantine_repository = new CantineRepository();
        $items = $cantine_repository->getInfoByClasseDate($start_date, $filter_by, $code);
        dd($items);   
    }

    public function testA()
    {

        $results = (new ExemplaireRepository())->getAllEmprunt();
        echo Helpers::toJSON($results) ;
        dd("ok");
        $repository = new PersonnelRepository();
        $items = (new PersonnelRepository())->getDocumentGroupByPersonnel();

        dd($items);
    }

    public function testB()
    {
        $annee_scolaire =  (new AnneeScolaireRepository())->getActive('id');

        $req = "
            select * from facture
            left
            
        
        ";

        $abonnements = DBTable::getModel(DBTable::ABONNEMENT_CANTINE)
        ->select(
            [
                'abonnement_cantine.code'=> 'id', 
                'abonnement_cantine.date_paiement'=> 'date_paiement', 
                'abonnement_cantine.date_debut'=> 'date_debut ', 
                'abonnement_cantine.date_fin'=> 'date_fin', 
                'abonnement_cantine.montant_total'=> 'montant_total', 
                'classe.libelle'=> 'classe', 
                'classe.code'=> 'code_classe', 
                new Expression("concat(eleve.nom,' ',eleve.prenom) as nom_eleve"),
                'eleve.code' => 'eleve_id'
            ]
        )
        ->join('eleve', 'eleve.id', '=', 'abonnement_cantine.eleve_id')
        ->join('parcours', 'eleve.id', '=', 'parcours.eleve_id')
        ->join('classe', 'parcours.classe_id', '=', 'classe.id')
        // ->where('parcours.annee_scolaire_id', '=', $annee_scolaire)
        ->get();
        dd($abonnements);
    }

    public function testB1()
    {
        $annee_scolaire =  (new AnneeScolaireRepository())->getActive('id');

        $abonnements = DBTable::getModel(DBTable::ABONNEMENT_CANTINE)
        ->select(
            [
                'abonnement_cantine.code'=> 'id', 
                'abonnement_cantine.date_paiement'=> 'date_paiement', 
                'abonnement_cantine.date_debut'=> 'date_debut ', 
                'abonnement_cantine.date_fin'=> 'date_fin', 
                'abonnement_cantine.montant_total'=> 'montant_total', 
                'classe.libelle'=> 'classe', 
                'classe.code'=> 'code_classe', 
                new Expression("concat(eleve.nom,' ',eleve.prenom) as nom_eleve"),
                'eleve.code' => 'eleve_id'
            ]
        )
        ->join('eleve', 'eleve.id', '=', 'abonnement_cantine.eleve_id')
        ->join('parcours', 'eleve.id', '=', 'parcours.eleve_id')
        ->join('classe', 'parcours.classe_id', '=', 'classe.id')
        ->join('pension_classe', 'pension_classe.classe_id', '=', 'parcours.classe_id')
        // ->where('parcours.visibilite', '=', 1)
        // ->where('parcours.annee_scolaire_id', '=', $annee_scolaire)
        ->get();
        dd($abonnements);
    }

    public function testC()
    {
        // $this->    
    }


}