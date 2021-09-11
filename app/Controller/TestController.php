<?php

namespace App\Controller;

use DateTime;
use DateHelpers;
use App\Helpers\S;
use App\Model\Pays;
use App\Model\Eleve;
use Core\Model\Model;
use App\Model\DBTable;
use App\Model\Facture;
use App\Model\Parcours;
use App\Helpers\Helpers;

use Core\Helper\DBHelper;
use Core\Session\Request;
use App\Model\TypePension;
use App\Model\PensionEleve;
use App\Model\PensionClasse;
use Core\HTML\FlashMessages;
use function Core\Helper\dd;
use function Core\Helper\vd;
use Spipu\Html2Pdf\Html2Pdf;
use App\Model\DossierMedical;
use App\Model\DossierParental;
use App\Model\StatutApprenant;
use App\Model\AntecedentScolaire;
use App\Repository\EleveRepository;
use App\Repository\ClasseRepository;
use App\Repository\CantineRepository;
use App\Repository\DocumentRepository;
use App\Model\AffectationClasseMatiere;
use App\Repository\PersonnelRepository;
use App\Repository\VersementRepository;
use ClanCats\Hydrahon\Query\Expression;
use App\Repository\ExemplaireRepository;
use App\Repository\StatutEleveRepository;
use App\Repository\PrixPaiementRepository;
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

    public function test()
    {   
        $jour_delai = 5 ;
        $tab_eleve_id = array();
        $mois_encours = NULL;
        if(isset($mois_encours)){
          $mois_encours = strtolower($mois_encours) ;
          $mois_encours = ucfirst($mois_encours) ;  
        }    
        $eleve_retard = 'NULL';
        $tab_eleve_ids = DBTable::getModel('eleve')
      ->select(['id'=>'eleve_id',])
      ->get();

      foreach ($tab_eleve_ids as $tab_eleve_id1)
      array_push($tab_eleve_id, $tab_eleve_id1['eleve_id']);
      
      $tab_eleve_retard = array();
      if(!isset($mois_encours)) { 
        $mois_encours = self::mois_en_lettre(date("m")) ;   
        }

      
      foreach($tab_eleve_id as $eleve_id ){
       
      
       $tranche_id_mois = DBTable::getModel('tranche_scolaire')
      ->select(['pension_eleve.tranche_scolaire_id'=>'tranche_scolaire_id',
              'tranche_scolaire.libelle'=>'mois' ])
      ->join('pension_eleve', 'tranche_scolaire.id', '=', 'pension_eleve.tranche_scolaire_id')
      ->join('type_pension', 'type_pension.id', '=', 'pension_eleve.type_pension_id')
      ->where('type_pension.libelle','=','Scolarité') 
      ->where('pension_eleve.visibilite', '=', 1)
      ->where('tranche_scolaire_id', '<>', 'NULL')
      ->where('pension_eleve.eleve_id', '=', $eleve_id)
      ->get(); 

      //dd($tranche_id_mois);
    //$tableau_valeur = array()

    $payer_retard = "true"; 
    $jour_int = (int) date("d");

    if ($jour_int >= $jour_delai) {

      foreach($tranche_id_mois as $tranche_id_moi){ 
     // $mois_deb=substr($pentions_facture_cant['date_debut'],5,2);
     
    
        if ($tranche_id_moi['mois'] == $mois_encours ){
            $payer_retard = "false"; 
            break ; }
     }
   
   if($payer_retard == "true") {

    $eleve_retards = DBTable::getModel('eleve')
    ->select([new Expression("concat( eleve.nom,' ',eleve.prenom) as nom_complet"),
                             'salle_classe.libelle' => 'salle_classe',])
      ->join('parcours', 'parcours.eleve_id', '=', 'eleve.id')
      ->join('salle_classe', 'salle_classe.id', '=', 'parcours.salle_classe_id')
      ->where('eleve.visibilite', '=', 1)
      ->where('salle_classe.libelle', '<>', 'NULL')
      ->where('eleve.id', '=', $eleve_id)
      ->get(); 

      foreach ($eleve_retards as $eleve_retard)
      array_push($tab_eleve_retard, $eleve_retard);      
   }
   
  }
      }
 
      dd($tab_eleve_retard );
     return $tab_eleve_retard ;
    }

    public function actualiser_statut_eleve(){
      $annee_scolaire_id = $this->session->get(S::ANNEE_SCOLAIRE); //annee scolaire courante
      (new StatutEleveRepository())->actualiser_statut( $annee_scolaire_id);
      echo "Good Job";
    }

    public function test11( )
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

    public static function getFullYear($datetime)
    {
        $time = strtotime($datetime);
        return date("Y", $time);
    }


    public function testSQL()
    {




      dd((new AnneeScolaireRepository())->get_annee_scolaire_precedente_id(3));
      dd((new PrixPaiementRepository())->getPensionGroupByClasse($this->session->get(S::ANNEE_SCOLAIRE)));

      $date = new \DateTime('now');

      vd($date->format('Y-m-d'));
      // dd(Helpers::format($date['date']));

      //dd((new AnneeScolaireRepository)->getAnneeScolaireID('2019-2020')) ;
      $pension_classe = DBTable::getModel('pension_classe')
      ->select(
          [
              'classe.code' => 'classe_id',
              'classe.libelle' => 'classe_libelle',
              'type_pension.code' => 'type_pension',
              'pension_classe.code' => 'id',
              'pension_classe.montant' => 'montant',
              // 'pension_classe.est_mensuel' => 'est_mensuel',
              // 'pension_classe.mensualite' => 'mensualite',
              'pension_classe.libelle' => 'libelle'
          ]
      )
      ->join('classe', 'classe.id', '=', 'pension_classe.classe_id')
      ->join('type_pension', 'type_pension.id', '=', 'pension_classe.type_pension_id')
      ->where('pension_classe.visibilite', '=', 1)
      ->where('type_pension.code', '=', TypePension::INSCRIPTION_CODE)
      ->where('type_pension.visibilite', '=', 1)
      ->get();
      
      // dd($pension_classe);
      dd(json_encode(DBTable::getModel('mois')->select(['code'=>'id', 'libelle' => 'libelle'])->where('visibilite', '=', 1)->get()));
      // dd((new VersementRepository )->getInfoEleveActivite(1,2) );
      dd(Facture::get_paie_facture_activite(4));
    //dd((new AnneeScolaireRepository)->getAnneeScolaireID('2019-2020')) ;
    
    //dd((new VersementRepository )->getInfoEleveActivite(1,2) );
  
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
        $this->renderPDF('reports.cantine', compact('date_facturation', 'eleve', 'classe', 'reference', 'reduction', 'reste', 'solde_paye', 'sous_total', 'items'), 'facture_cantine' );  
    
    }

    public function testAlert()
    {
        $filter_by = 'ALL';
        $code = '';
        $start_date = '2022-01-01';
        $date = 
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
       // $items = (new PersonnelRepository())->getDocumentGroupByPersonnel();

      //  dd($items);
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

    public static function mois_en_lettre($mois)
    {
      if ($mois=='01') {
        return 'Janvier';
      }
      elseif ($mois=='02') {
        return 'Février';
      }
      elseif ($mois=='03') {
        return 'Mars';
      }
      elseif ($mois=='04') {
        return 'Avril';
      }
      elseif ($mois=='05') {
        return 'Mai';
      }
      elseif ($mois=='06') {
        return 'Juin';
      }
      elseif ($mois=='07') {
        return 'Juillet';
      }
      elseif ($mois=='08') {
        return 'Août';
      }
      elseif ($mois=='09') {
        return 'Septembre';
      }
      elseif ($mois=='10') {
        return 'Octobre';
      }
      elseif ($mois=='11') {
        return 'Novembre';
      }
      elseif ($mois=='12') {
        return 'Décembre';
      }
      else {
        return '';
      }
    }

}