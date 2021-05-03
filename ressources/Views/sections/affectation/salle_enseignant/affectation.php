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

require 'affectation-script.php';

$include_footer_script = ob_get_clean();


?>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <h3 class="content-header-title">Affectation  Salle  Enseignant </h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= URL::link('accueil') ?>">Accueil</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Affectation</a>
                            </li>
                            <li class="breadcrumb-item active">Salle - Enseignant
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                    </div>
                        <a class="btn btn-outline-info" href="<?= URL::link('classe') ?>" title="gestion des salles de classes"><i class="fa fa-window-maximize"></i>&nbsp;&nbsp; Gesiton classes</a>
                    <a class="btn btn-outline-info" href="<?= URL::link('salle_classe') ?>" title="gestion des classes"><i class="fa fa-window-restore"></i>&nbsp; &nbsp; Gestion salles de classes</a>
                </div>
            </div>
            <div class="content-header-lead col-12 mt-2">
            </div>
        </div>
        <div class="content-body">
            <!-- Basic scenario start -->
            <section id="basic">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div class="p-0">
                                        <h4 class="card-title" id="heading-prev-next">Tableau d'affectation des enseignants aux salles de classe.</h4>
                                        <small class="text-muted">Cette grille vous permet d'affecter un personnel à une salle de classe.</small>
                                       <br> <small class="text-muted">Cliquer sur les champs d'en-tete de la grille pour trier la colonne ciblée.</small>
                                    </div>
      
                                    <div class="p-0">
                                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                        <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                                <!-- <li><a data-action="collapse"><i class="ft-minus"></i></a></li> -->
                                                <!-- <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li> -->
                                                <!-- <li><a data-action="expand"><i class="ft-maximize"></i></a></li> -->
                                                <!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
                                            </ul>
                                        </div>
                                    </div>

                                    
                                   
                                </div>
                                <p class="lead"></p>
                                <!-- <h4 class="card-title">Basic Scenario</h4> -->
                                
                            </div>
                            <div class="card-content collapse show">
                                <?php if(false){ //inutile car la génération se fera automatiquement si ce n'est pas encore existant?>
                                    <div class="card-header">
                                        <button class="btn btn-primary "  data-toggle="modal" data-target="#modal-emprunt"><i class="ft-plus white"></i> Initialiser les affectations pour cette année scolaire</button>
                                    </div>
                                <?php }?>
                                <div class="card-body card-dashboard mt-0 pt-0">
                                    <!-- <p>Cette grille vous permet d'affecter un personnel à une salle de classe.</p> -->
                                    <div id="table_affectation_personnel_salle_classe"></div>
                                </div>
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