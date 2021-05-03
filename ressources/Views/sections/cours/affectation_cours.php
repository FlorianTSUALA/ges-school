<?php

use Core\Routing\URL;

$include_res_header = '';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/forms/selects/select2.min.css">';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css">';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/tables/jsgrid/jsgrid.min.css">';

$include_res_footer = '';
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>';
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/jsgrid/jsgrid.min.js"></script>';
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/jsgrid/griddata.js"></script>';
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>';

ob_start();
include "affectation_cours-script.php";
$include_footer_script = ob_get_clean();

?>

<div class="app-content content bg-warningcreated22">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block"><?= $title; ?></h3>
                <div class="row breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= URL::link('accueil') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active"><?= $title; ?>
                        </li>
                    </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-4 col-12">
            <div class="btn-group float-md-right">
                <a class="btn btn-outline-info" href="calendars-clndr.html"><i class="fa fa-calendar"></i> Matiere </a>
                <a class="btn btn-outline-info" href="timeline-center.html"><i class="fa fa-bar-chart"></i> Classe </a>
                <button class="btn btn-outline-info dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-settings icon-left"></i> Autres
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item" href="card-bootstrap.html">Planning</a>
                    <a class="dropdown-item" href="component-buttons-extended.html">Personnel</a>
                </div>
            </div>
            </div>
        </div>
        <div class="content-body">
            <section id="basic-examples">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Default</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard ">
                                    <p>Affectation des cours aux matieres d'une salle de classe à un enseignants.</p>
                                    
                                    <div id="multi-data-select"></div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>