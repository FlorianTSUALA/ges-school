
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
// include 'versement_liste-script_new.php';
// include 'index-script.php';
$include_footer_script = ob_get_clean();

$table_header = "
                    <tr>
                        <th style=\"width: 5px;\">N°</th>
                       
                        <th class=\"word-wrap;\">total</th>
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
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <h3 class="content-header-title">Tableau de versements </h3>
                        <small class="text-muted">Consultation, Génération de reçus, filtré par période.</small>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= URL::link('accueil') ?>">Accueil</a>
                            </li>
                            
                            <li class="breadcrumb-item active">Versements
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                    </div>
                        <a class="btn btn-outline-info" href="<?= URL::link('versement_liste') ?>" title="gestion des salles de classes"><i class="fa fa-window-maximize"></i>&nbsp;&nbsp; Liste des versements</a>
                    <a class="btn btn-outline-info" href="<?= URL::link('versement_totale') ?>" title="gestion des classes"><i class="fa fa-window-restore"></i>&nbsp; &nbsp; Tous les Entrées</a>
                </div>
            </div>
            <div class="content-header-lead col-12 mt-2">
            </div>
        </div>
        <div>
        <!-- <div class="content-detached "> -->
        <div class="content-body">
            <section class="row card mb-0 pb-0">
                <div class="card-content collapse show mb-0 pb-0" >
                    <div class="card-body">
                        <!-- Task List table -->
                        <div class="table-responsive-sm" >
                            <table id="table-versement1"  class="table table-white-space table-bordered  table-sm" style="width: 100%;">
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
    </div>
    </div>



