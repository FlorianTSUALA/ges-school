
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

                                    <?php 
                                  //echo Facture::get_retard_paie_scolarite(32);
                                 
                                 ?>

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
                                                    <th>Numéro</th>
                                                    <th>Elèves concernés</th>
                                                    <th>Salle de classe</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php $comp=0; $eleve_retards=Facture::get_retard_paie_scolarite(); 
                                                  foreach ($eleve_retards as $eleve_retard): ?>
                                              <tr>
                                                  <td><?php $comp++; echo $comp; ?></td>
                                                  <td>
                                                    <?php
                                                        $eleve_nom = $eleve_retard['nom_complet'];
                                                        $eleve_classe = $eleve_retard['salle_classe'];
                                                        
                                                          ?>

                                                          
                                                              <?= $eleve_nom; ?>
                                                  </td>
                                                  <td><?= $eleve_classe ?></td>
                                                  
                                              </tr>
                                            <?php endforeach; ?>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                  <th>Numéro</th>   
                                                  <th>Elèves concernés</th>
                                                  <th>Salle de classe</th>
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
