
<?php

use Core\Routing\URL;
use App\Helpers\Helpers;
use App\Model\DBTable;
use App\Model\Facture;
use App\Model\Eleve;

    $include_res_header = '';
    $include_res_header = '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/extensions/rowReorder.dataTables.min.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/extensions/responsive.dataTables.min.css">'. "\n";
    // $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/forms/icheck/icheck.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/pickers/daterange/daterangepicker.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/ui/jquery-ui.min.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/forms/selects/select2.min.css">'. "\n";
    $include_res_header .= Helpers::dataTableResponsibleSearchBar() . "\n";
    $include_res_header .=  '<style>
                        #menu ul, #menu li {list-style-type: none;}

                        #menu div div li a, #menu  div li a, #menu  li{
                            font-size: 100% !important;
                            line-height: 60% !important;
                        }

                        #menu div div li a, #menu div div li {
                            font-size: 100% !important;
                            line-height: 50% !important;
                        }

                        #menu li a:hover {
                            background-color: aliceblue;
                        }

                        #menu li :active:hover {
                            background-color: #fff;
                            color: #3BAFDA;
                        }

                        #menu li a:active {
                            background-color: #3BAFDA;
                            color: #fff;
                        }

                        li.select2-results__option strong.select2-results__group:hover {
                            background-color: #ddd;
                            cursor: pointer;
                        }

                        </style>


                    ';

    $include_res_footer = ''. "\n";
    $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/jquery.dataTables.min.js"></script>'. "\n";
    $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>'. "\n";
    $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>'. "\n";
    $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/datatable/dataTables.rowReorder.min.js"></script>'. "\n";


    $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>';
    $include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/forms/repeater/jquery.input.js"></script>';
    $include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/forms/repeater/lib.js"></script>';
    $include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>';


    // $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>'. "\n";
    // $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>'. "\n";
    // $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/repeater/jquery.input.js"></script>'. "\n";
    // $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/icheck/icheck.min.js"></script>'. "\n";

    // <!-- BEGIN DATE PICKER VENDOR JS-->
    $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"></script>'. "\n";
    $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>'. "\n";
    // <!-- END DATE PICKER VENDOR JS-->

$include_res_footer .= "";

ob_start();
// include 'versement_detail_modal-script.php';
include 'versement_liste-script_new.php';
$include_footer_script = ob_get_clean();
?>
<!--
    ******  VARIABLES *****

    --- $title

-->


<?php

  function mois_en_lettre($mois)
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

?>

<div class="app-content content">


        <div>
        <!-- <div class="content-detached "> -->
            <div class="content-body">
                <section class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header my-0 pb-0">
                                <div class="d-flex">
                                    <div class="p-0  col-md-3 mr-auto ">
                                        <h4 class="card-title" id="heading-prev-next">Tableu de versements</h4>
                                        <small class="text-muted">Consultation, Generation de recus, filtre par periode.</small>
                                    </div>
                                    <div class="p-0 mr-1   ">
                                        <button class="btn btn-primary " onclick="window.location.href='<?= URL::link('versement') ?>'"  >
                                            <i class="ft-plus white"></i> Nouveau versement
                                        </button>
                                    </div>
                                    <div class="p-0 mr-1 ">
                                        <fieldset class="input-group">
                                            <!-- <div class="input-group-prepend">
                                            <span class="input-group-text">L &nbsp; <span class="fa fa-calendar"></span></span>
                                            </div> -->
                                            <input id="localization" type='text' class="form-control form-control-sm localeRange" />
                                            <div class="input-group-append">
                                            <span class="input-group-text">Date &nbsp; <span class="fa fa-calendar"></span></span>
                                            </div>
                                            <!-- <small class="text-muted">Allows you to provide.</small> -->
                                        </fieldset>
                                    </div>

                                    <div class="p-0   ">
                                        <span class="dropdown">
                                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled><i class="icon-settings mr-1"></i>Rapport</button>
                                            <span class="dropdown-menu arrow  dropdown-menu-left">
                                                <a href="#" class="dropdown-item"><i class="fa fa-file-excel-o"></i> Excel </a>
                                                <a href="#" class="dropdown-item"><i class="fa fa-file-word-o"></i> Word</a>
                                                <a href="#" class="dropdown-item"><i class="fa fa-file-pdf-o"></i> PDF </a>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex  mt-1 ">
                                </div>

                            </div>

                              <?php if (isset($_SESSION['message'])){
                                  $message=$_SESSION['message'];
                                  echo $message;
                                  $_SESSION['message']='';
                                } ?>



                            <div class="card-content my-0 py-0">
                                <div class="card-body">
                                    <div class="table-responsive-sm">
                                       <table  id="datatable" class="table table-bordered table-striped table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Libéllé</th>
                                                    <th>Montant</th>
                                                    <th>Réduction</th>
                                                    <th>Date</th>
                                                    <th>Elève concerné</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php $comp=0; foreach ($factures as $facture): ?>
                                              <tr>
                                                  <td><?php $comp++; echo $comp; ?></td>
                                                  <td><?php echo $facture['libelle'] ?></td>
                                                  <td><?php echo number_format($facture['montant'],0,',',' ').' Fcfa' ?></td>
                                                  <td><?php echo number_format($facture['reduction'],0,',',' ').' Fcfa' ?></td>
                                                  <td><?php $date = new DateTime($facture['date_facture']); echo $date->format('d/m/Y'); ?></td>
                                                  <td>
                                                    <?php
                                                        $eleve=Facture::get_eleve_by_facture($facture['id']);
                                                        $ele_id=(! empty($eleve))?$eleve['id']:0;
                                                        if (! empty($eleve)) {
                                                          ?>
                                                          <a href="javascript:void()" class="btn-link" data-toggle="modal" data-target="#details_eleve<?php echo $eleve['id'] ?>" title="afficher les détails">
                                                              <?php echo $eleve['nom'].' '.$eleve['prenom']; ?>
                                                            </a>

                                                            <div class="modal fade" id="details_eleve<?php echo $eleve['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                              <div class="modal-dialog modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                  <div class="modal-header" style="background: #f5a663;">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Détails d'un élève</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                    <div class="row">
                                                                      <img class="col-md-6" src="<?php echo  URL::base().'/assets/app-assets/images/portrait/small/'.$eleve['photo'] ?>" alt="Photo de l'élève">
                                                                      <div class="col-md-6">
                                                                        <table>
                                                                          <tr>
                                                                            <td style="background: white; border: none; width: 30%;"><strong>Matricule: </strong></td>
                                                                            <td style="background: white; border: none; width: 70%;"><?php echo $eleve['matricule'] ?></td>
                                                                          </tr>

                                                                          <tr>
                                                                            <td style="background: white; border: none;"><strong>Nom: </strong></td>
                                                                            <td style="background: white; border: none;"><?php echo $eleve['nom'] ?></td>
                                                                          </tr>

                                                                          <tr>
                                                                            <td style="background: white; border: none;"><strong>Prénom: </strong></td>
                                                                            <td style="background: white; border: none;"><?php echo $eleve['prenom'] ?></td>
                                                                          </tr>

                                                                          <tr>
                                                                            <td style="background: white; border: none;"><strong>Sexe: </strong></td>
                                                                            <td style="background: white; border: none;"><?php echo ($eleve['sexe'] == 'M')?'Masculin':'Féminin' ?></td>
                                                                          </tr>

                                                                          <tr>
                                                                            <td style="background: white; border: none;"><strong>Date de naissance: </strong></td>
                                                                            <td style="background: white; border: none;"><?php $date = new DateTime($eleve['date_naissance']); echo $date->format('d/m/Y'); ?></td>
                                                                          </tr>

                                                                          <tr>
                                                                            <td style="background: white; border: none;"><strong>Lieu de naissance: </strong></td>
                                                                            <td style="background: white; border: none;"><?php echo $eleve['lieu_naissance'] ?></td>
                                                                          </tr>

                                                                          <tr>
                                                                            <td style="background: white; border: none;"><strong>Classe: </strong></td>
                                                                            <td style="background: white; border: none;">
                                                                              <?php
                                                                                $parcours=Eleve::get_parcours_eleve($eleve['id']);
                                                                                if (! empty($parcours)) {
                                                                                  echo $parcours['libelle'];
                                                                                }
                                                                              ?>

                                                                            </td>
                                                                          </tr>
                                                                        </table>



                                                                      </div>
                                                                    </div>
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" style="background: #f5a663;" data-dismiss="modal">Fermer</button>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>


                                                          <?php
                                                        }
                                                     ?>

                                                  </td>
                                                  <td style="width: 13%;">

                                                    <a href="javascript:void(0)" data-action="action-voir" data-toggle="modal" data-target="#details_facture<?php echo $facture['id'] ?>" title="voir" style="color: blue;"><i class="ft-eye"></i></a> &nbsp;&nbsp;&nbsp;

                                                    <div class="modal fade" id="details_facture<?php echo $facture['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                      <div class="modal-dialog modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                          <div class="modal-header" style="background: #f5a663;">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Détails de la facture</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">&times;</span>
                                                            </button>
                                                          </div>
                                                          <div class="modal-body">



                                                            <section class="card">
                                                                <div id="invoice-template" class="card-body bg-light rounded">
                                                                    <!-- Invoice Company Details -->
                                                                    <div id="invoice-company-details" class="row">
                                                                        <div class="col-md-6 col-sm-12 text-center text-md-left">
                                                                            <div class="media">
                                                                                <img src="<?= URL::base() ?>assets/app-assets/images/logo/logo-80x80.png" alt="company logo" class=""/>
                                                                                <div class="media-body">
                                                                                    <ul class="ml-2 px-0 list-unstyled">
                                                                                        <li class="text-bold-800"><h2>Les comilines</h2></li>
                                                                                        <li>Batterie 4 </li>
                                                                                        <li>Libreville, Gabon</li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 col-sm-12 text-center text-md-right">
                                                                            <h2>REÇU DE VERSEMENT</h2>
                                                                            <p class="pb-3" id="recap-reference"> <strong>Réference : </strong> <?= $facture['reference'] ;?> </p>
                                                                            <ul class="px-0 list-unstyled">
                                                                                <li>Solde à payer</li>
                                                                                <li class="lead text-bold-800"><strong class="text-danger" id="recap-total-top"><?= number_format(($facture['montant']-$facture['reduction']),0,',',' ') ;?> Fcfa</strong></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <!--/ Invoice Company Details -->

                                                                    <!-- Invoice Customer Details -->
                                                                    <div id="invoice-customer-details" class="row pt-2">
                                                                        <div class="col-sm-12 text-center text-md-left">
                                                                            <p class="text-muted">Facture de</p>
                                                                        </div>
                                                                        <div class="col-md-6 col-sm-12 text-center text-md-left">
                                                                            <ul class="px-0 list-unstyled">
                                                                                <li class="text-bold-800">Elève : <strong id="reca?p-nom"><?php echo (! empty($eleve))?$eleve['nom'].' '.$eleve['prenom']:''; ?> </strong></li>
                                                                                <li>Classe : <strong id="recap-classe"><?php echo (! empty($parcours))?$parcours['libelle']:'';?></strong></li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="col-md-6 col-sm-12 text-center text-md-right">
                                                                            <p><span class="text-muted">Date de facturation :</span> <strong id="recap-date"><?php $date = new DateTime($facture['date_facture']); echo $date->format('d/m/Y');?></strong></p>

                                                                        </div>
                                                                    </div>
                                                                    <!--/ Invoice Customer Details -->

                                                                    <!-- Invoice Items Details -->
                                                                    <div id="invoice-items-details" class="pt-2">
                                                                        <div class="row">
                                                                            <div class="table-responsive col-sm-12">
                                                                                <table class="table">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Numéro</th>
                                                                                            <th>Objet et description</th>
                                                                                            <th class="text-right">Montant</th>
                                                                                            <th class="text-right">Quantité</th>
                                                                                            <th class="text-right">Montant Total</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody id="recap-body">

                                                                                      <?php
                                                                                        $pentions_facture_scolarite=Facture::get_details_facture_scolarite($facture['id']);
                                                                                        $comp_detail=0;
                                                                                        if (! empty($pentions_facture_scolarite)) {
                                                                                          $comp_detail++;
                                                                                          $tot=0;
                                                                                          $mois=array();
                                                                                          foreach ($pentions_facture_scolarite as $sco) {
                                                                                            $tot+=$sco['montant'];
                                                                                            $mois[]=substr($sco['motif'],22);
                                                                                          }

                                                                                          $mois_order=array();
                                                                                          for ($i=(count($pentions_facture_scolarite)-1); $i >= 0 ; $i--) {
                                                                                            $mois_order[]=$mois[$i];
                                                                                          }

                                                                                          ?>
                                                                                          <tr>
                                                                                              <th scope="row" id="recap-numero_ligne"><?= $comp_detail ;?></th>
                                                                                              <td>
                                                                                                  <p id="recap-typepaiement"><?= "Pension : Scolarité" ;?></p>
                                                                                                  <em class="text-muted" id="recap-description"><?= "Concernant les tranches suivantes :";?>
                                                                                                    <?php foreach ($mois_order as $m): ?>
                                                                                                      <?php echo $m.',' ?>
                                                                                                    <?php endforeach; ?>

                                                                                                  </em>
                                                                                              </td>
                                                                                              <td class="text-right" id="recap-prix"><?= number_format($pentions_facture_scolarite[0]['montant'],0,',',' ');?> Fcfa</td>
                                                                                              <td class="text-right" id="recap-quantite"><?= count($pentions_facture_scolarite);?></td>
                                                                                              <td class="text-right" id="recap-somme"><?= number_format($tot,0,',',' ');?> Fcfa</td>
                                                                                          </tr>
                                                                                          <?php
                                                                                        }
                                                                                       ?>


                                                                                       <?php
                                                                                         $pentions_facture_inscription=Facture::get_details_facture_inscription($facture['id']);

                                                                                         if (! empty($pentions_facture_inscription)) {
                                                                                           $comp_detail++;
                                                                                           $tot=0;
                                                                                           foreach ($pentions_facture_inscription as $sco) {
                                                                                             $tot+=$sco['montant'];
                                                                                           }


                                                                                           ?>
                                                                                           <tr>
                                                                                               <th scope="row" id="recap-numero_ligne"><?= $comp_detail ;?></th>
                                                                                               <td>
                                                                                                   <p id="recap-typepaiement"><?= "Pension : Inscription" ;?></p>

                                                                                               </td>
                                                                                               <td class="text-right" id="recap-prix"><?= number_format($pentions_facture_inscription[0]['montant'],0,',',' ');?> Fcfa</td>
                                                                                               <td class="text-right" id="recap-quantite"><?= count($pentions_facture_inscription);?></td>
                                                                                               <td class="text-right" id="recap-somme"><?= number_format($tot,0,',',' ');?> Fcfa</td>
                                                                                           </tr>
                                                                                           <?php
                                                                                         }
                                                                                        ?>

                                                                                       <?php
                                                                                         $pentions_facture_tenue=Facture::get_details_facture_tenue($facture['id']);

                                                                                         if (! empty($pentions_facture_tenue)) {
                                                                                           $comp_detail++;
                                                                                           $tot=0;
                                                                                           $mois=array();
                                                                                           foreach ($pentions_facture_tenue as $sco) {
                                                                                             $tot+=$sco['montant'];
                                                                                           }

                                                                                           ?>
                                                                                           <tr>
                                                                                               <th scope="row" id="recap-numero_ligne"><?= $comp_detail ;?></th>
                                                                                               <td>
                                                                                                   <p id="recap-typepaiement"><?= "Pension : Tenue" ;?></p>

                                                                                               </td>
                                                                                               <td class="text-right" id="recap-prix"><?= number_format($pentions_facture_tenue[0]['montant'],0,',',' ');?> Fcfa</td>
                                                                                               <td class="text-right" id="recap-quantite"><?= count($pentions_facture_tenue);?></td>
                                                                                               <td class="text-right" id="recap-somme"><?= number_format($tot,0,',',' ');?> Fcfa</td>
                                                                                           </tr>
                                                                                           <?php
                                                                                         }
                                                                                        ?>


                                                                                        <?php
                                                                                          $pentions_facture_cantine=Facture::get_details_facture_cantine_eleve($facture['id'],$ele_id);
                                                                                          // var_dump($pentions_facture_cantine);
                                                                                          // die();

                                                                                          if (! empty($pentions_facture_cantine)) {
                                                                                            $comp_detail++;
                                                                                            $tot=$pentions_facture_cantine[0]['montant_total'];

                                                                                            $mois=array();
                                                                                            $qte=0;
                                                                                            foreach ($pentions_facture_cantine as $pentions_facture_cant) {
                                                                                              $mois_deb=substr($pentions_facture_cant['date_debut'],5,2);
                                                                                              $mois_fin=substr($pentions_facture_cant['date_fin'],5,2);
                                                                                              $i=$mois_deb;
                                                                                              while ($i <=$mois_fin) {
                                                                                                $mois[]=$i;
                                                                                                $qte++;
                                                                                                $i++;
                                                                                              }

                                                                                            }


                                                                                            $pu=($qte>0)?$tot/$qte:0;

                                                                                            ?>
                                                                                            <tr>
                                                                                                <th scope="row" id="recap-numero_ligne"><?= $comp_detail ;?></th>
                                                                                                <td>
                                                                                                    <p id="recap-typepaiement"><?= "Pension : Cantine" ;?></p>
                                                                                                    <em class="text-muted" id="recap-description"><?= "Concernant les tranches suivantes :";?>
                                                                                                      <?php foreach ($mois as $m): ?>
                                                                                                        <?php echo mois_en_lettre($m).',' ?>
                                                                                                      <?php endforeach; ?>

                                                                                                      </em>
                                                                                                </td>
                                                                                                <td class="text-right" id="recap-prix"><?= number_format($pu,0,',',' ');?> Fcfa</td>
                                                                                                <td class="text-right" id="recap-quantite"><?= $qte;?></td>
                                                                                                <td class="text-right" id="recap-somme"><?= number_format($tot,0,',',' ');?> Fcfa</td>
                                                                                            </tr>
                                                                                            <?php
                                                                                          }
                                                                                         ?>


                                                                                         <?php
                                                                                           $pentions_facture_scolarite=Facture::get_details_facture_activite($facture['id'],$ele_id);
                                                                                           if (! empty($pentions_facture_scolarite)) {
                                                                                               $comp_detail++;

                                                                                             ?>
                                                                                             <tr>
                                                                                                 <th scope="row" id="recap-numero_ligne"><?= $comp_detail ;?></th>
                                                                                                 <td>
                                                                                                     <p id="recap-typepaiement"><?= "Pension des activités :" ;?></p>
                                                                                                     <em class="text-muted" id="recap-description"><?= "Concernant les tranches suivantes :";?>

                                                                                                     </em>
                                                                                                 </td>
                                                                                                 <td class="text-right" id="recap-prix"> Fcfa</td>
                                                                                                 <td class="text-right" id="recap-quantite"></td>
                                                                                                 <td class="text-right" id="recap-somme"> Fcfa</td>
                                                                                             </tr>
                                                                                             <?php
                                                                                           }
                                                                                          ?>


                                                                                        <!-- <tr>
                                                                                            <th scope="row" id="recap-numero_ligne"><?= $numero_ligne??"" ;?></th>
                                                                                            <td>
                                                                                                <p id="recap-typepaiement"><?= $typepaiement??"" ;?></p>
                                                                                                <em class="text-muted" id="recap-description"><?= $description??"";?></em>
                                                                                            </td>
                                                                                            <td class="text-right" id="recap-prix"><?= $prix??"";?> Fcfa</td>
                                                                                            <td class="text-right" id="recap-quantite"><?= $quantite??"";?></td>
                                                                                            <td class="text-right" id="recap-somme"><?= $somme??"";?> Fcfa</td>
                                                                                        </tr> -->
                                                                                        <!--
                                                                                            <tr>
                                                                                                <th scope="row">2</th>
                                                                                                <td>
                                                                                                    <p>Tranche mensuelle</p>
                                                                                                    <em class="text-muted">Il s'agit de la scolarité mensuelle d'un élève.</em>
                                                                                                </td>
                                                                                                <td class="text-right">20 000 Fcfa</td>
                                                                                                <td class="text-right">5</td>
                                                                                                <td class="text-right">100 000 Fcfa</td>
                                                                                            </tr>
                                                                                        -->
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6 col-sm-12 text-center text-md-left">
                                                                                <p class="lead">Mode de paiement:&nbsp;<strong id="recap-mode_paiement"><?= $mode_paiement??"";?></strong></p>
                                                                                <div class="row">
                                                                                    <div class="col-md-8">
                                                                                        <table class="table table-borderless table-sm">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td id="recap-banque"><?= $banque??"";?></td>
                                                                                                    <td class="text-right" id="recap-nom_banque"><?= $nom_banque??"";?>: </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td id="recap-cheque"><?= $cheque??"";?>:</td>
                                                                                                    <td class="text-right" id="recap-numero_cheque"><?= $numero_cheque??"";?></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-12">
                                                                                <p class="lead">Montant total du versement</p>
                                                                                <div class="table-responsive">
                                                                                    <table class="table">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>Sous-Total</td>
                                                                                                <td class="text-right"><strong id="recap-sous_total"><?= number_format(($facture['montant']),0,',',' ') ;?> Fcfa</strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Remise</td>
                                                                                                <td class="text-right"><strong id="recap-reduction"><?= number_format(($facture['reduction']),0,',',' ') ;?> Fcfa</strong></td>
                                                                                            </tr>

                                                                                            <tr class="bg-grey bg-lighten-4">
                                                                                                <td class="text-bold-800">Solde à payer</td>
                                                                                                <td class="text-bold-800 text-right text-danger"><strong id="recap-total-bottom"><?= number_format(($facture['montant']-$facture['reduction']),0,',',' ') ;?> Fcfa</strong></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="text-center">
                                                                                    <p>Personne habilitée</p>
                                                                                    <!-- <img src="<?= URL::base() ?>assets/app-assets/images/pages/signature-scan.png" alt="signature" class="height-100"/> -->
                                                                                    <h6 id="recap-signataire"><?= $signataire??"";?></h6>
                                                                                    <p class="text-muted" id="recap-funtion_signataire"><?= $funtion_signataire??"";?></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <hr />

                                                                    <!--/ Invoice Footer -->

                                                                </div>
                                                            </section>

                                                          </div>
                                                          <div class="modal-footer">
                                                            <button type="button" class="btn btn-info" style=" border: none;" data-dismiss="modal">Imprimer</button> &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <button type="button" class="btn btn-secondary" style="background: #f5a663; border: none;" data-dismiss="modal">Fermer</button>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>


                                                    <a href="<?php echo  URL::base().'versement/modification/'.$facture['id'] ?>" data-action="action-modifier" class="" title="modifier" style="color: green;"><i class="ft-edit-2"></i></a>&nbsp;&nbsp;&nbsp;


                                                    <a href="javascript:void(0)" data-action="action-supprimer" class="" title="supprimer" data-toggle="modal" data-target="#suppression_facture<?php echo $facture['id'] ?>" style="color: red;"><i class="ft-trash"></i></a>

                                                    <div class="modal fade" id="suppression_facture<?php echo $facture['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                      <div class="modal-dialog modal-dialog modal-lg modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                          <div class="modal-header" style="background: #f5a663;">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Suppression d'un versement</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">&times;</span>
                                                            </button>
                                                          </div>
                                                          <div class="modal-body">
                                                            <center> Voulez vous vraiment supprimer ce versement ?</center>
                                                          </div>
                                                          <div class="modal-footer">
                                                            <a href="<?php echo  URL::base().'versement/suppression/'.$facture['id'] ?>" class="btn btn-danger">oui</a>
                                                            <button type="button" class="btn btn-success" data-dismiss="modal">Non</button>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>

                                                  </td>
                                              </tr>
                                            <?php endforeach; ?>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                  <th>#</th>
                                                  <th>Libéllé</th>
                                                  <th>Montant</th>
                                                  <th>Réduction</th>
                                                  <th>Date</th>
                                                  <th>Elève concerné</th>
                                                  <th>Actions</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>


    </div>
</div>



<?php include 'versement_detail_modal.php' ?>
