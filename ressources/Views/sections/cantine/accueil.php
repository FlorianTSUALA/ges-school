<?php

use Core\Routing\URL;
use App\Helpers\Helpers;


$include_res_header = '';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/charts/c3.css">'. "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/css/core/menu/menu-types/vertical-content-menu.css">'. "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/css/core/colors/palette-gradient.css">'. "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/css/plugins/charts/c3-chart.css">'. "\n";
$include_res_header .= ''. "\n";


$include_res_footer = ''. "\n";

// <!-- BEGIN DATE PICKER VENDOR JS-->
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/charts/d3.min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/charts/c3.min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/js/scripts/charts/c3/grid/grid-lines.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/js/scripts/charts/c3/grid/x-grid-lines.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/js/scripts/charts/c3/grid/y-grid-lines.js"></script>'. "\n";
// <!-- END DATE PICKER VENDOR JS-->

$include_res_footer .= "";

ob_start();
    include 'accueil-script.php';
$include_footer_script = ob_get_clean();
?>
<!--
    ******  VARIABLES *****

    --- $title

-->

    <div class="app-content content bg-warningcreated22">
        <div class="content-wrapper">
                <div class="content-body">
                    <!-- c3 axis charts section start -->
                    <section id="c3-grid-charts">

                        <!-- X axis timezone Chart -->
                        <div class="row">
                            <div class="col-9">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-4 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                                        <div class="pb-1">
                                                            <div class="clearfix mb-1">
                                                                <i class="ft-users font-large-1 blue-grey float-left mt-1"></i>
                                                                <span class="font-large-2 text-bold-300 info float-right">5,879</span>
                                                            </div>
                                                            <div class="clearfix">
                                                                <span class="text-muted">Inscription du mois</span>
                                                                <span class="info float-right"><i class="ft-arrow-up info"></i> 16.89%</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress mb-0" style="height: 7px;">
                                                            <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                                        <div class="pb-1">
                                                            <div class="clearfix mb-1">
                                                                <i class="icon-user-following font-large-1 blue-grey float-left mt-1"></i>
                                                                <span class="font-large-2 text-bold-300 success float-right">61%</span>
                                                            </div>
                                                            <div class="clearfix">
                                                                <span class="text-muted"> Inscription du jour</span>
                                                                <span class="success float-right"><i class="ft-arrow-down success"></i> 2.24%</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress mb-0" style="height: 7px;">
                                                            <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-4 col-sm-12">
                                                        <div class="pb-1">
                                                            <div class="clearfix mb-1">
                                                                <i class="icon-calendar font-large-1 blue-grey float-left mt-1"></i>
                                                                <span class="font-large-2 text-bold-150 warning float-right">Fév</span>
                                                            </div>
                                                            <div class="clearfix">
                                                                <span class="text-muted">Entrée Total</span>
                                                                <span class="warning float-right"><i class="ft-arrow-up warning"></i> 43.84%</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress mb-0" style="height: 7px;">
                                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Activités Cantine</h4>
                                        <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
                                        
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <div id="grid-lines"></div>
                                        </div>
                                    </div>
                                    </div>
                            </div>
                    
                            <div class="col-3">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                            
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <button type="button" class="btn mb-1  btn-lg btn-block"> Abonnement</button>
                                            <button type="button" class="btn mb-1  btn-lg btn-block"> Enregistrement Menus</button>
                                            <button type="button" class="btn mb-1  btn-lg btn-block"> Liste des Abonnées</button>
                                            <button type="button" class="btn mb-1  btn-lg btn-block">Consommation</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div  class="row"> </div>
                        </div>

                    </section>
                    <!-- // c3 axis charts section end -->
                </div>
        </div>
    </div>