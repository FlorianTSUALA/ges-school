<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

$include_res_header = '<style>
                            button:hover {
                                background-color: #f5a663;

                            }                            
                        </style>';

$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/charts/c3.css">'. "\n";

$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/core/menu/menu-types/vertical-content-menu.css">'. "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/core/colors/palette-gradient.css">'. "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/plugins/charts/c3-chart.css">'. "\n";

// $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/...........">'. "\n";
$include_res_header .= ''. "\n";


$include_res_footer = ''. "\n";

$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/app-assets/vendors/js/vendors.min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/app-assets/vendors/js/charts/d3.min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/app-assets/vendors/js/charts/c3.min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/app-assets/js/scripts/charts/c3/grid/grid-lines.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/app-assets/js/scripts/charts/c3/grid/x-grid-lines.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/app-assets/js/scripts/charts/c3/grid/y-grid-lines.js"></script>'. "\n";

// $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/....."></script>'. "\n";


$include_res_footer .= "";

ob_start();

// include 'template-script.php';

$include_footer_script = ob_get_clean();
?>
<!--
    ******  VARIABLES *****

    --- $title

-->

    <div class="app-content content bg-warningcreated22">
        <div class="content-wrapper">
        
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12">
                    <h3 class="content-header-title">Advance Statistics Cards	</h3>
                    <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= URL::link('accueil') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Components</a>
                        </li>
                        <li class="breadcrumb-item active">Statistics Cards
                        </li>
                        </ol>
                    </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group"><a class="btn btn-outline-info" href="calendars-clndr.html"><i class="fa fa-calendar"></i></a><a class="btn btn-outline-info" href="timeline-center.html"><i class="fa fa-bar-chart"></i></a>
                        <button class="btn btn-outline-info dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-settings icon-left"></i> Settings</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div>
                    </div>
                    </div>
                </div>
                <div class="content-header-lead col-12 mt-2">
                    <p class="lead">Exteding default bootstrap card functionality.</p>
                </div>
            </div>

            <div class="content-body">
            </div>

        </div>

    </div>