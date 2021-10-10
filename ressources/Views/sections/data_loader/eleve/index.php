<?php

use Core\Routing\URL;
use App\Helpers\Helpers;


$include_res_header = '';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css">';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/app-assets/vendors/css/tables/jsgrid/jsgrid.min.css">';

$include_res_footer = '';
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>';
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/tables/jsgrid/jsgrid.min.js"></script>';
// $include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/tables/jsgrid/griddata.js"></script>';



ob_start();

require 'script.php';

$include_footer_script = ob_get_clean();


?>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <h3 class="content-header-title">Chargement des élèves </h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= URL::link('accueil') ?>">Accueil</a>
                            </li>
                            <li class="breadcrumb-item"><a href="<?= URL::link('loader') ?>">Chargment des données</a>
                            </li>
                            <li class="breadcrumb-item active"> Eleves
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                    </div>
                        <a class="btn btn-outline-info" href="<?= URL::link('loader_eleve') ?>" title="Chargement des élèves"><i class="fa fa-window-maximize"></i>&nbsp;&nbsp; Chargement des élèves</a>
                    <a class="btn btn-outline-info" href="<?= "#" ?>" title="Chargement des notes"><i class="fa fa-window-restore"></i>&nbsp; &nbsp; Chargement des notes</a>
                </div>
            </div>
            <div class="content-header-lead col-12 mt-2">
            </div>
        </div>

        <div class="content-body">
                <section class="row">
                    <div class="col-12">
                        <div class="card">
    
                            <div class="card-header pb-0 mb-0">
                                <div class="d-flex">
                                    <div class="p-0  col-md-6 mr-auto ">
                                        <h4 class="card-title" id="heading-prev-next">Chargement des données</h4>
                                        <small class="text-muted">Chargement, prévisualisation et sauvegarde .</small>
                                    </div>
                                    <div class="p-0 mr-1   ">
                                        <span class="btn btn-success input_file_upload mr-1" data-target="excel_file">
                                            <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" style="display: none;" name="excel_file" id="excel_file" onchange="load_jsgrid(this, '.excel_file');" /> 
                                            <i class="icon-plus"></i>
                                            <span>charger le fichier...</span>
                                        </span>
                                    </div>

                                    <div class="p-0 mr-1   ">
                                        <a class="btn btn-warning btn-block "  href="<?= URL::link('download_template_loader_eleve') ?>"><i class="ft-plus white"></i> Télécharger un modèle</a>
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

                            <div class="card-content collapse show pt-0 mt-1" >
                                <div class="card-body card-dashboard mt-0 pt-0">
                                <div id="table_affectation_personnel_salle_classe"></div>
                            </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
    </div>
</div>

<!-- 

salle_classes
personnels
affection_personnel_salle_classes

-->