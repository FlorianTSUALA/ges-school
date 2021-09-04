<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\Model\HydrahonModel;
use ClanCats\Hydrahon\Query\Expression;
use Core\Helper\DateHelpers;
use App\Model\now;

use function Core\Helper\dd;
use function Core\Helper\vd;

class Facture extends Model implements FrequentlyReapeat
{
    use HydrahonModel;
    protected $entity;

    const REFERENCE = "reference";
    const MONTANT = "montant";
    const REDUCTION = "reduction";
    const DATE_FACTURE = "date_facture";
    const BENEFICAIRE = "beneficaire";
    const GESTIONNAIRE = "gestionnaire";
    const JOURDELAI = 5 ;
    //const PAYER_RETARD = "true" ;

    public function __construct(){
        parent::__construct();
        $this->fillables =
            [
                new FormModel(true, self::LIBELLE),
                new FormModel(true, self::DESCRIPTION),
               //to complete

            ];
    }

    public static function getColumns()
    {
        $columns = '';
        $columns .= '{ "data": "id" },';
        $columns .= '{ "data": "libelle" },';
        $columns .= '{ "data": "code_enregistrement" },';
        $columns .= '{ "data": "matricule" },';
        $columns .= '{ "data": "date_naissance" },';
        $columns .= '{ "data": "lieu_naissance" },';
        return $columns;
    }

    public static function getColumnsomme()
    {
        $columns = '';
        $columns .= '{ "data": "total" },';;
        return $columns;
    }



    public static function get_retard_paie_scolarite($mois_encours = NULL,  $jour_delai = 1)
    {
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
   
       return $tab_eleve_retard ;

    }
    
// somme des paies

  public static function get_paie_facture_total($personnel_id, $date = Null ){

    if($date == NULL){
      $date = new \DateTime('now');
      $date =  $date->format('Y-m-d'); 
    }
    $req =
    " SELECT sum(facture.montant) as total
      from facture
      where facture.visibilite = 1  and  facture.date_paiement = '$date' and facture.personnel_id = $personnel_id
   
    ";
      $result = (new self)->query($req);
      return (new self)->toObject($result);

  }

  public static function get_paie_facture_activite($personnel_id, $date = Null ){

    if($date == NULL){
      $date = new \DateTime('now');
      $date =  $date->format('Y-m-d'); 
    }
       $req =
       " SELECT sum(abonnement_detail.total) as total, activite.libelle 
       from abonnement_activite 
       INNER JOIN facture on facture.id = abonnement_activite.facture_id
       INNER JOIN abonnement_detail on abonnement_activite.id = abonnement_detail.abonnement_id
       INNER JOIN activite on activite.id = abonnement_activite.activite_id
       where facture.visibilite = 1  and abonnement_detail.type_abonnement = 'ACTIVITE' and facture.date_paiement = '$date' and facture.personnel_id = $personnel_id
       group by activite.libelle 
      ";

      $result = (new self)->query($req);
      return (new self)->toObject($result);
  }

  public static function get_paie_facture_cantine($personnel_id, $date = Null ){
   
    if($date == NULL){
      $date = new \DateTime('now');
      $date =  $date->format('Y-m-d'); 
    }
    $req =
      " SELECT sum(abonnement_detail.total) as total
        from abonnement_cantine
        INNER JOIN facture on facture.id = abonnement_cantine.facture_id
        INNER JOIN abonnement_detail on abonnement_cantine.id = abonnement_detail.abonnement_id
        where facture.visibilite = 1  and abonnement_detail.type_abonnement = 'CANTINE' 
        and  facture.date_paiement = '$date' 
        and facture.personnel_id = $personnel_id
        ";

        $result = (new self)->query($req);
        return (new self)->toObject($result);
  }

  public static function get_paie_facture_scolarite($personnel_id, $date = Null ){

    if($date == NULL){
      $date = new \DateTime('now');
      $date =  $date->format('Y-m-d'); 
    }
    $req =
        " SELECT sum(facture.montant) as total
        from
        (select  pension_eleve.montant, facture.date_paiement, pension_eleve.reduction, tranche_scolaire.libelle
        from facture
        left join pension_eleve  on facture.id = pension_eleve.facture_id
        left join tranche_scolaire on tranche_scolaire.id = pension_eleve.tranche_scolaire_id
        left join type_pension on type_pension.id = pension_eleve.type_pension_id
        where  facture.visibilite = 1 and type_pension.code = 'SCOLARITE' and  facture.date_paiement = '$date' and facture.personnel_id = $personnel_id
        order by facture.date_paiement)";

        $result = (new self)->query($req);
        return (new self)->toObject($result);
 }

  public static function get_paie_facture_inscription($personnel_id, $date = Null ){

    if($date == NULL){
      $date = new \DateTime('now');
      $date =  $date->format('Y-m-d'); 
    }

    $req =
        " SELECT sum(facture.montant) as total
        from
        (select  pension_eleve.montant, facture.date_paiement, pension_eleve.reduction, tranche_scolaire.libelle
        from facture
        left join pension_eleve  on facture.id = pension_eleve.facture_id
        left join tranche_scolaire on tranche_scolaire.id = pension_eleve.tranche_scolaire_id
        left join type_pension on type_pension.id = pension_eleve.type_pension_id
        where  facture.visibilite = 1 and type_pension.code = 'INSCRIPTION' and  facture.date_paiement = '$date' and facture.personnel_id = $personnel_id
        order by facture.date_paiement)";

      $result = (new self)->query($req);
      return (new self)->toObject($result);

   
  }
  
// somme des paies end

    public static function get_pensions_facture($fact_id)
    {
      // table pension elève
      $pension_eleve = DBTable::getModel('pension_eleve')
                ->select()
                ->join('type_pension', 'type_pension.id', '=', 'pension_eleve.type_pension_id')
                ->where('pension_eleve.facture_id', '=', $fact_id)
                ->where('pension_eleve.visibilite', '=', 1)
                ->where('type_pension.visibilite', '=', 1)
                ->orderBy('pension_eleve.id', 'DESC')
                ->get();

      return $pension_eleve;
    }


    public static function get_details_facture_scolarite($fact_id)
    {

      // table pension elève
      $pension_eleve = DBTable::getModel('pension_eleve')
                ->select()
                ->join('type_pension', 'type_pension.id', '=', 'pension_eleve.type_pension_id')
                ->where('pension_eleve.facture_id', '=', $fact_id)
                ->where('type_pension.id', '=', 1)
                ->where('pension_eleve.visibilite', '=', 1)
                ->where('type_pension.visibilite', '=', 1)
                ->orderBy('pension_eleve.id', 'DESC')
                ->get();

      return $pension_eleve;

    }


    public static function get_details_facture_inscription($fact_id)
    {

      // table pension elève
      $pension_eleve = DBTable::getModel('pension_eleve')
                ->select()
                ->join('type_pension', 'type_pension.id', '=', 'pension_eleve.type_pension_id')
                ->where('pension_eleve.facture_id', '=', $fact_id)
                ->where('type_pension.id', '=', 4)
                ->where('pension_eleve.visibilite', '=', 1)
                ->where('type_pension.visibilite', '=', 1)
                ->orderBy('pension_eleve.id', 'DESC')
                ->get();


      return $pension_eleve;

    }

    public static function get_details_facture_tenue($fact_id)
    {

      // table pension elève
      $pension_eleve = DBTable::getModel('pension_eleve')
                ->select()
                ->join('type_pension', 'type_pension.id', '=', 'pension_eleve.type_pension_id')
                ->where('pension_eleve.facture_id', '=', $fact_id)
                ->where('type_pension.id', '=', 7)
                ->where('pension_eleve.visibilite', '=', 1)
                ->where('type_pension.visibilite', '=', 1)
                ->orderBy('pension_eleve.id', 'DESC')
                ->get();


      return $pension_eleve;

    }


    public static function get_details_abonnement_activite($fact_id,$ele_id)
    {

      // table pension elève
      $abonnement_activite = DBTable::getModel('abonnement_activite')
                ->select()
                ->join('abonnement_detail', 'abonnement_detail.abonnement_id', '=', 'abonnement_activite.id')
                ->where('abonnement_activite.facture_id', '=', $fact_id)
                ->where('abonnement_activite.eleve_id', '=', $ele_id)
                ->where('abonnement_activite.visibilite', '=', 1)
                ->where('abonnement_detail.visibilite', '=', 1)
                ->orderBy('abonnement_activite.id', 'DESC')
                ->get();


      return $abonnement_activite;

    }

    public static function get_details_facture_pension_autre($fact_id)
    {
      // table pension elève
      $abonnement_activite = DBTable::getModel('pension_eleve')
                ->select()
                ->where('pension_eleve.facture_id', '=', $fact_id)
                ->whereNull('pension_eleve.type_pension_id')
                ->where('pension_eleve.visibilite', '=', 1)
                ->orderBy('pension_eleve.id', 'DESC')
                ->get();

      //var_dump($abonnement_activite); die();

      if (! empty($abonnement_activite)) {
        return $abonnement_activite[0];
      }
      else {
        return array();
      }

    }

    public static function get_details_abonnement_cantine($fact_id,$ele_id)
    {

      // table pension elève
      $cantine = DBTable::getModel('abonnement_cantine')
                ->select()
                ->where('abonnement_cantine.facture_id', '=', $fact_id)
                ->where('abonnement_cantine.eleve_id', '=', $ele_id)
                ->where('abonnement_cantine.visibilite', '=', 1)
                ->orderBy('abonnement_cantine.id', 'DESC')
                ->get();

      if (! empty($cantine)) {
        $cantine_id=$cantine[0]['id'];
      }
      else {
        $cantine_id=0;
      }

      //var_dump($cantine_id);

      $abonnement_cantine = DBTable::getModel('abonnement_detail')
                ->select()
                ->join('abonnement_cantine', 'abonnement_detail.abonnement_id', '=', 'abonnement_cantine.id')
                ->where('abonnement_detail.abonnement_id', '=', $cantine_id)
                ->where('abonnement_detail.visibilite', '=', 1)
                ->where('abonnement_cantine.visibilite', '=', 1)
                ->orderBy('abonnement_cantine.id', 'DESC')
                ->get();




      return $abonnement_cantine;

    }


    public static function get_details_facture_cantine_eleve($fact_id,$ele_id)
    {

      //table pension elève
      $pension_cantine = DBTable::getModel('abonnement_cantine')
                ->select()
                //->join('abonnement_cantine', 'abonnement_cantine.id', '=', 'abonnement_detail.abonnement_id')
                ->where('abonnement_cantine.facture_id', '=', $fact_id)
                ->where('abonnement_cantine.eleve_id', '=', $ele_id)
                ->where('abonnement_cantine.visibilite', '=', 1)
                //->where('abonnement_detail.visibilite', '=', 1)
                ->orderBy('abonnement_cantine.id', 'ASC')
                ->get();

      // $pension_cantine = DBTable::getModel('abonnement_detail')
      //           ->select()
      //           ->join('abonnement_cantine', 'abonnement_cantine.id', '=', 'abonnement_detail.abonnement_id')
      //           ->where('abonnement_cantine.facture_id', '=', $fact_id)
      //           ->where('abonnement_cantine.eleve_id', '=', $ele_id)
      //           ->where('abonnement_cantine.visibilite', '=', 1)
      //           ->where('abonnement_detail.visibilite', '=', 1)
      //           ->orderBy('abonnement_detail.id', 'ASC')
      //           ->get();


        return $pension_cantine;

    }

    public static function get_details_facture_activite($fact_id,$ele_id)
    {

      // table pension elève
      $details_activite = DBTable::getModel('abonnement_activite')
                ->select()
                ->where('abonnement_activite.facture_id', '=', $fact_id)
                ->where('abonnement_activite.eleve_id', '=', $ele_id)
                ->where('abonnement_activite.visibilite', '=', 1)
                ->orderBy('abonnement_activite.id', 'DESC')
                ->get();


        return $details_activite;

    }

    public static function get_details_facture_activite_new($fact_id,$ele_id)
    {

      // table pension elève
      $details_activite = DBTable::getModel('abonnement_activite')
                ->select()
                ->where('abonnement_activite.facture_id', '=', $fact_id)
                ->where('abonnement_activite.eleve_id', '=', $ele_id)
                ->where('abonnement_activite.visibilite', '=', 1)
                ->orderBy('abonnement_activite.id', 'ASC')
                ->get();


        return $details_activite;

    }

    public static function get_activite_facture_eleve($fact_id,$ele_id)
    {

      $activite_ids = DBTable::getModel('abonnement_activite')
                ->select(['activite_id'=>'activite_id'])
                ->distinct()
                ->where('abonnement_activite.facture_id', '=', $fact_id)
                ->where('abonnement_activite.eleve_id', '=', $ele_id)
                ->where('abonnement_activite.visibilite', '=', 1)
                // ->orderBy('abonnement_activite.id', 'DESC')
                ->get();


      $ids_act=[];
      foreach ($activite_ids as $activite_id) {
        $ids_act[]=intval($activite_id['activite_id']);
        //var_dump($activite_id);
      }

      //var_dump($ids_act);


      // table pension elève
      $activites = DBTable::getModel('activite')
                ->select()
                ->whereIn('activite.id', $ids_act)
                ->where('activite.visibilite', '=', 1)
                ->orderBy('activite.id', 'DESC')
                ->get();

        return $activites;

    }


    public static function convert_mois_lettre_en_code_tranche_sco($m)
    {
      if ($m=='Janvier' || $m=='janvier' || $m=='01') {
        return 'TRAN_1598852718';
      }
      elseif ($m=='Février' || $m=='février' || $m=='FÃ©vrier' || $m=='02') {
        return 'TRAN_1598854167';
      }
      elseif ($m=='Mars' || $m=='mars' || $m=='03') {
        return 'TRAN_1598854187';
      }
      elseif ($m=='Avril' || $m=='avril' || $m=='04') {
        return 'TRAN_1598854806';
      }
      elseif ($m=='Mai' || $m=='mai' || $m=='05') {
        return 'TRAN_1598854815';
      }
      elseif ($m=='Juin' || $m=='juin' || $m=='06') {
        return 'TRAN_1598854822';
      }
      elseif ($m=='Juillet' || $m=='juillet' || $m=='07') {
        return 'TRAN_1598854833';
      }
      else {
        require '';
      }
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
