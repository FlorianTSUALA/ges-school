<?php

namespace App\Model;

use Core\Model\Model;
use Core\HTML\Form\FormModel;
use Core\Model\HydrahonModel;

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


    public static function get_eleve_by_facture($id_fact)
    {
      $id_eleve=0;
      $eleve=array();
      $pention = DBTable::getModel('pension_eleve')->select(['eleve_id'=>'eleve_id'])
                ->where('visibilite', '=', 1)
                ->where('facture_id', '=', $id_fact)
                ->get();
      if (! empty($pention)) {
        $id_eleve=$pention[0]['eleve_id'];
      }
      else {
        $abonnement_activite = DBTable::getModel('abonnement_activite')->select(['eleve_id'=>'eleve_id'])
                  ->where('visibilite', '=', 1)
                  ->where('facture_id', '=', $id_fact)
                  ->get();
        if (! empty($abonnement_activite)) {
          $id_eleve=$abonnement_activite[0]['eleve_id'];
        }
        else {
          $abonnement_cantine = DBTable::getModel('abonnement_cantine')->select(['eleve_id'=>'eleve_id'])
                    ->where('visibilite', '=', 1)
                    ->where('facture_id', '=', $id_fact)
                    ->get();
          if (! empty($abonnement_cantine)) {
            $id_eleve=$abonnement_cantine[0]['eleve_id'];
          }
        }
      }

      if ($id_eleve != 0) {
        $eleve = DBTable::getModel('eleve')->select()
                  ->where('visibilite', '=', 1)
                  ->where('id', '=', $id_eleve)
                  ->get();
        if (! empty($eleve)) {
          $eleve=$eleve[0];
          //var_dump($eleve);
        }
      }

      return $eleve;
    }

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


      // table abonnement activite
      // $abonnement_activite = DBTable::getModel('abonnement_activite')
      //           ->select()
      //           ->where('facture_id', '=', $fact_id)
      //           ->where('visibilite', '=', 1)
      //           ->orderBy('id', 'DESC')
      //           ->get();
      //
      // // table abonnement detail
      // $abonnement_detail = DBTable::getModel('abonnement_detail')
      //           ->select()
      //           ->where('facture_id', '=', $fact_id)
      //           ->where('visibilite', '=', 1)
      //           ->orderBy('id', 'DESC')
      //           ->get();
      //
      // // table abonnement detail
      // $abonnement_cantine = DBTable::getModel('abonnement_cantine')
      //           ->select()
      //           ->where('facture_id', '=', $fact_id)
      //           ->where('visibilite', '=', 1)
      //           ->orderBy('id', 'DESC')
      //           ->get();

      //  table pension_eleve autres

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
      $activite = DBTable::getModel('abonnement_activite')
                ->select()
                ->where('abonnement_activite.facture_id', '=', $fact_id)
                ->where('abonnement_activite.eleve_id', '=', $ele_id)
                ->where('abonnement_activite.visibilite', '=', 1)
                ->orderBy('abonnement_activite.id', 'DESC')
                ->get();

      if (! empty($activite)) {
        $activite_id=$activite[0]['id'];
      }
      else {
        $activite_id=0;
      }

      //table pension elève
      $pension_cantine = DBTable::getModel('abonnement_detail')
                ->select()
                ->where('abonnement_detail.abonnement_id', '=', $activite_id)
                ->where('abonnement_detail.visibilite', '=', 1)
                ->orderBy('abonnement_detail.id', 'ASC')
                ->get();

     //var_dump($pension_cantine);


        return $pension_cantine;

    }
}
