<?php

use App\Helpers\S;
use Core\Routing\URL;
use App\Helpers\Helpers;


$include_res_header = '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">' . "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/vendors/css/tables/extensions/rowReorder.dataTables.min.css">' . "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/vendors/css/tables/extensions/responsive.dataTables.min.css">' . "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/app-assets/vendors/css/pickers/daterange/daterangepicker.css">' . "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/vendors/css/ui/jquery-ui.min.css">' . "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/vendors/css/forms/selects/select2.min.css">' . "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/app-assets/css/core/colors/palette-tooltip.css">' . "\n";
// $include_res_header .= Helpers::dataTableResponsibleSearchBar() . "\n";

$include_res_header .= '
                        <style>
                            #menu .list-group a.list-group-item:hover{
                                background-color: #3bafda;
                                color: white;
                            }
                        </style>

' . "\n";
$include_res_header .= '' . "\n";

$include_res_footer = '' . "\n";
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/tables/jquery.dataTables.min.js"></script>' . "\n";
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>' . "\n";
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/filesaver/FileSaver.min.js"></script>' . "\n";
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/js/scripts/tooltip/tooltip.js"></script>' . "\n";
// $include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>' . "\n";
// $include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/tables/datatable/dataTables.rowReorder.min.js"></script>' . "\n";
$include_res_footer .= "";

ob_start();
    include 'index-script.php';
    include 'eleve_info_modal-script.php';
$include_footer_script = ob_get_clean();


$table_header = "
                    <tr>
                        <th style=\"width: 5px;\">N°</th>
                        <th>Nom(s) et Prénom(s)</th>
                        <th class=\"word-wrap;\">Sexe</th>
                        <th class=\"word-wrap;\">salle de classe</th>
                        <th>Date de Naissance</th>
                        <th>Age</th>
                        <th style=\"width: 5px;\">Action</th>
                    </tr>
";
?>
<!--
    ******  VARIABLES *****

    --- $title

-->

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12">
            <h3 class="content-header-title">Scolarité	</h3>
            <div class="row breadcrumbs-top">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"> <a href="<?= URL::link('accueil') ?>">Accueil</a></li>
                  <li class="breadcrumb-item"> <a href="<?= URL::link('liste_eleve') ?>">Eleves</a></li>
                  <li class="breadcrumb-item active"><a href="#">Tous les élèves</a> </li>
                </ol>
              </div>
            </div>
          </div>

          <div class="content-header-lead col-12 mt-2">
            <p class="lead"></p>
          </div>
        </div>

        <div class="content-body">
            <section class="row card mb-0 pb-0">
                <div class="card-content collapse show mb-0 pb-0" >
                    <div class="card-body">
                        <!-- Task List table -->
                        <div class="table-responsive-sm" >
                            <table id="table-eleve"  class="table table-white-space table-bordered  table-sm" style="width: 100%;">
                            <!-- <table id="table-eleve" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle"> -->
                                <thead> <?= $table_header ?> </thead>
                                <tbody> </tbody>
                                <tfoot> <?= $table_header ?> </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        
    </div>
</div>

<?php
    include 'eleve_info_modal.php';
?>
