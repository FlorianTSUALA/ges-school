<?php

use Core\Routing\URL;

$include_res_header = '';
$include_res_header .= '<style>
                            button:hover {
                                background-color: #f5a663;

                            }
                        </style>';

$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css">'. "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/charts/morris.css">'. "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/extensions/unslider.css">'. "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/weather-icons/climacons.min.css">'. "\n";
$include_res_header .= ''. "\n";


$include_res_footer = ''. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/extensions/jquery.knob.min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/js/scripts/extensions/knob.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/charts/raphael-min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/charts/morris.min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/data/jvector/visitor-data.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/charts/chart.min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/extensions/unslider-min.js"></script>'. "\n";

$include_res_footer .= "";

ob_start();

 include 'accueil-script.php';

$include_footer_script = ob_get_clean();
?>
<!--
    ******  VARIABLES *****

    --- $title

-->

    <div class="app-content content">
        <div class="content-wrapper">
            <!-- Bounce Rate & Mobile Device View -->
            <div class="row match-height" style="display: none;">
                <div id="sessions-browser-donut-chart" class="height-200"></div>
                <div id="bounce-rate" class="height-250">
                    <canvas id="line-stacked-area" height="300" ></canvas>
                    <div id="area-chart" class="height-250"></div>
                    <div id="sp-tristate-bar-total-sales"></div>
                    <div id="sp-bar-total-sales"></div>
                    <div id="sp-line-total-sales"></div>
                </div>

            </div>
            <!--/ Bounce Rate & Mobile Device View -->

            <div class="row">
                <div class="col-9">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                        <div class="pb-1">
                                            <div class="clearfix mb-1">
                                                <i class="ft-users font-large-1 blue-grey float-left mt-1"></i>
                                                <span class="font-large-2 text-bold-300 info float-right">5,879</span>
                                            </div>
                                            <div class="clearfix">
                                                <span class="text-muted">Nombre d'élèves</span>
                                                <span class="info float-right"><i class="ft-arrow-up info"></i> 16.89%</span>
                                            </div>
                                        </div>
                                        <div class="progress mb-0" style="height: 7px;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                    <div class="pb-1">
                                        <div class="clearfix mb-1">
                                            <i class="icon-user-following font-large-1 blue-grey float-left mt-1"></i>
                                            <span class="font-large-2 text-bold-300 success float-right">61%</span>
                                        </div>
                                        <div class="clearfix">
                                            <span class="text-muted"> Nombres bulletins</span>
                                            <span class="success float-right"><i class="ft-arrow-down success"></i> 2.24%</span>
                                        </div>
                                    </div>
                                    <div class="progress mb-0" style="height: 7px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                    <div class="col-lg-3 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                        <div class="pb-1">
                                            <div class="clearfix mb-1">
                                                <i class="icon-user-unfollow font-large-1 blue-grey float-left mt-1"></i>
                                                <span class="font-large-2 text-bold-300 danger float-right">423</span>
                                            </div>
                                            <div class="clearfix">
                                                <span class="text-muted">Nombres restants </span>
                                                <span class="danger float-right"><i class="ft-arrow-up danger"></i> 5.14%</span>
                                            </div>
                                        </div>
                                        <div class="progress mb-0" style="height: 7px;">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3 col-sm-12">
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
                        <div class="card-content">
                        
                                <div id="monthly-sales" class="height-300"></div>
                    
                        <div class="card-footer">
                            <div class="chart-title my-2 text-center">
                                <span class="text-muted">Total monthly Sales.</span>
                            </div>
                            <div class="chart-stats text-center">
                                <a href="#" class="btn btn-sm btn-primary mr-1">Statistics <i class="ft-bar-chart"></i></a> <span class="text-muted">for the last year.</span>
                            </div>
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
                                <button type="button" class="btn mb-1  btn-lg btn-block"> Générer Bulletin</button>
                                <button type="button" class="btn mb-1  btn-lg btn-block"> Enregistrer Note</button>
                                <button type="button" class="btn mb-1  btn-lg btn-block"> Fiche de Note</button>
                                <button type="button" class="btn mb-1  btn-lg btn-block"> Modifier Note</button>
                                <button type="button" class="btn mb-1  btn-lg btn-block"> Consulter Note</button>
                            </div>
                    </div>
                </div>
            </div>
            <div  class="row">
            
            </div>
            </div>
        </div>
    </div>