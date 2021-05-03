<?php

use Core\Routing\URL;
use App\Helpers\Helpers;


$include_res_header = '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">' . "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/vendors/css/tables/extensions/rowReorder.dataTables.min.css">' . "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/vendors/css/tables/extensions/responsive.dataTables.min.css">' . "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/app-assets/vendors/css/pickers/daterange/daterangepicker.css">' . "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/vendors/css/ui/jquery-ui.min.css">' . "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/vendors/css/forms/selects/select2.min.css">' . "\n";
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
// $include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>' . "\n";
// $include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/tables/datatable/dataTables.rowReorder.min.js"></script>' . "\n";
$include_res_footer .= "";

ob_start();
    include 'personnel_liste-script.php';
    include 'personnel_info_modal-script.php';
    include 'personnel_info_modal.php';
$include_footer_script = ob_get_clean();


$table_header = "
                    <tr>
                        <th style=\"width: 5px;\">N°</th>
                        <th class=\"word-wrap;\">Nom des enseignants</th>
                        <th>Fonction</th>
                        <th>Téléphone</th>
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
            <h3 class="content-header-title">Gestion du personnel	</h3>
            <div class="row breadcrumbs-top">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"> <a href="<?= URL::link('accueil') ?>">Accueil</a></li>
                  <li class="breadcrumb-item"> <a href="<?= URL::link('personnel_accueil') ?>">Personnel</a></li>
                  <li class="breadcrumb-item active"><a href="#">En service</a> </li>
                </ol>
              </div>
            </div>
          </div>
          <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <div class="btn-group" role="group"><a class="btn btn-outline-info" href="<?= URL::link('type_personnel') ?>"> 
                    <i class="fa fa-users"> Gestion Type Personnel</i></a> 
                </div>
                <!-- <div class="btn-group" role="group"><a class="btn btn-outline-info" href="<?= URL::link('accueil') ?>"> 
                    <i class="fa fa-home"> Accueil</i></a> 
                </div> -->
            </div>
          </div>

          <div class="content-header-lead col-12 mt-2">
            <p class="lead"></p>
          </div>
        </div>

        <div class="content-detached content-right">
            <div class="content-body">
                <section class="row">
                    <div class="col-12">
                        <div class="card">
    
                            <div class="card-header pb-0 mb-0">
                                <div class="d-flex">
                                    <div class="p-0  col-md-6 mr-auto ">
                                        <h4 class="card-title" id="heading-prev-next">Enregistrement personnel</h4><small class="text-muted">Consultation, modification et suppression du personnel.</small>
                                    </div>
                                    <div class="p-0 mr-1   ">
                                        <a class="btn btn-primary"  href="<?= URL::link('ajout_personnel') ?>"><i class="ft-plus white"></i> Nouveau Personnel</a>
                                    </div>
                                    <div class="p-0   ">
                                        <span class="dropdown">
                                            <button disabled class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-settings mr-1"></i>Rapport</button>
                                            <span class="dropdown-menu arrow  dropdown-menu-left">
                                                <a href="#" class="dropdown-item"><i class="fa fa-file-excel-o"></i> Excel </a>
                                                <a href="#" class="dropdown-item"><i class="fa fa-file-word-o"></i> Word</a>
                                                <a href="#" class="dropdown-item"><i class="fa fa-file-pdf-o"></i> PDF </a>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <!-- <div class="d-flex  mt-1">
                                    <div class="alert bg-success alert-icon-left" role="alert">
                                        <span class="alert-icon"><i class="fa fa-pencil-square"></i></span>
                                        <span class="alert-icon"><i class="fa fa-pencil-square"></i></span>
                                        <span id='resume_filtre'> listes des enseignants.</span>
                                    </div>
                                </div> -->
                            </div>

                            <div class="card-content collapse show pt-0" >
                                <div class="card-body">
                                    <!-- Task List table -->
                                    <div class="table-responsive-sm" >
                                        <table id="table-personnel"  class="table table-white-space table-bordered  table-sm" style="width: 100%;">

                                        <!-- <table id="table-personnel" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle"> -->
                                            <thead> <?= $table_header ?> </thead>
                                            <tbody> </tbody>
                                            <tfoot> <?= $table_header ?> </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="sidebar-detached sidebar-left">
            <div class="sidebar">
                <div class="bug-list-sidebar-content">
                    <!-- Predefined Views -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">TYPE DE PERSONNEL</h4>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <!-- <li><a data-action="collapse"><i class="ft-plus"></i></a></li> -->
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div id="menu" class="navigation navigation-main">
                                    <div class="list-group">
                                        <a href="<?= "#"; ?>" class="list-group-item active"> Voir tout</a>
                                        <?php foreach ($type_personnels as $item) { ?>
                                            <a href="#" id="ID_<?= $item['type_personnel_id'] ?>" 
                                                class="list-group-item" data-toggle="collapse" 
                                                data-parent="#menu">
                                                <?= $item['type_personnel']; ?> 
                                                <span class="badge  badge-pill bg-<?= Helpers::getRandomBootstrapColor() ?> float-right mr-2 badge-glow">
                                                    <?= count($item['personnels']) ?>
                                                </span>
                                            </a>
                                      <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Predefined Views -->
                </div>
            </div>
        </div>
    </div>
</div>