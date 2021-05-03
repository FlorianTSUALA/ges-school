<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

$include_res_header = '';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/app-assets/vendors/css/tables/jsgrid/jsgrid-theme.min.css">';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/app-assets/vendors/css/tables/jsgrid/jsgrid.min.css">';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/app-assets/css/plugins/animate/animate.css">';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/app-assets/css/core/colors/palette-callout.css">';

$include_res_header .= '
                        <style>
                            #menu .list-group a.list-group-item:hover{
                                background-color: #3bafda;
                                color: white;
                            }
                        </style>

                        <style>
                            /* html, body {
                                height: 100%;
                                width: 100%;
                                position: absolute,
                            } */
                            /* #page-content-wrapper, .container-fluid, .row, .another-fluid { height: inherit; }
                            #page-content-wrapper, .principal {padding:0;}
                            #page-content-wrapper {padding-top:5px;}
                            .fill {
                                //height:95vh;
                                min-height: 100%;
                                height: 100%;
                            } */
                            .jsontotable table, .jsontotable th, .jsontotable td {
                                border: 1px solid black;
                                margin: 10px;
                            }
                            /* code {
                                white-space: normal;
                            } */
                            /* #jsGrid, #jsGrid2 {
                                margin: 0px;
                                width: 100%;
                                height: 95%;
                                min-height: 95%;
                                display: block;
                                font-size: 11.5px;
                            } */
                            .jsgrid-cell {padding:0 !important; }
                            /* .bg-green { background-color:#88A23D !important; border-color:#72843e; }
                            .bg-yellow { background-color:#f5c62b !important;  border-color:#b99315;  }
                            .bg-orange { background-color:#ef611a !important;  border-color:#bb450a; }
                            .bg-red { background-color:#ce2e2e !important;  border-color:#a91616; } */
                    
                            /* remove scrollbar */
                            .principal #jsGrid { margin-top:0px; }
                            /*
                            #jsGrid .jsgrid-grid-header,
                            #jsGrid .jsgrid-grid-body{
                                overflow: auto;
                            }
                            */
                            #jsGrid .jsgrid-grid-body{
                                
                                max-height: 80vh;
                                
                            }
                    
                            .jsgrid-selected-row>.jsgrid-cell {
                                background: #ddd !important;
                                border-color: #aaa !important;
                            }
                            .jsgrid-header-row>.jsgrid-header-cell {
                                white-space: nowrap;
                                transform: translate(0%,100%) rotate(-90deg);
                                transform-origin: 0 0;
                                height: 100px;
                                text-align: left !important;
                                padding: 0 !important;
                                margin: 0;
                            }
                    
                            /* .btn-config {padding:4px 12px; margin-top:8px;} */
                    
                            /* view-source:https://www.dapio.com.br/inet/dashboard/grid.html */
                        </style>

                        <style>
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

' . "\n";
$include_res_header .= '' . "\n";

$include_res_footer = '' . "\n";

$include_res_footer .= '<script src="' . URL::base().'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>';
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/tables/jsgrid/jsgrid.min.js"></script>';
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/tables/jsgrid/griddata.js"></script>';
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/js/scripts/tables/jsgrid/jsgrid.js"></script>';

$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/animation/jquery.appear.js"></script>';
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/js/scripts/animation/animation.js"></script>';
$include_res_footer .= "";

$include_res_footer .= '' . "\n";

ob_start();
include 'index-script.php';
// include 'buiderHtml.php';
// include 'affectation-script.php';
echo '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>';

$include_footer_script = ob_get_clean();


//TENIR COMPTE DU NOMBRE D'ELEVE NON AFFECTE PAR SALLE DANS LE MENU LATERALE

?>
<!--
    ******  VARIABLES *****

    --- $title

-->


<div class="app-content content">
    <div class="sidebar-right sidebar-sticky">
        <div class="sidebar">
            <div class="sidebar-content card d-none d-lg-block">
                <div class="card-body">
                    <div class="category-title pb-1">
                        <h6>Liste des Salles de Classes</h6>
                    </div>
                    <!-- Card sample -->
                   
                    <!-- Predefined Views -->
                        <div class="card m-0">
                            <div class="card-header">
                                <h4 class="card-title"> Salle de classe Concernée</h4>
                                <!-- <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div> -->
                            </div>
                            <!-- bug-list search -->
                            <div class="card-content ">
                                <div class="card-body border-top-blue-grey border-top-lighten-5 m-0 pt-1 pb-0 ">
                                    <div class="bug-list-search">
                                        <div class="bug-list-search-content">
                                            <form action="#">
                                                <div class="position-relative">
                                                    <input type="search" class="form-control menu-search"  placeholder="rechercher salles de classes...">
                                                    <div class="form-control-position">
                                                        <i class="ft-search text-size-base text-muted"></i>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /bug-list search -->

                                <div class="card-body mt-1 pt-0">
                                    <div id="menu">
                                        <div class="list-group">
                                            <!-- <li><a href="#" class="list-group-item blockquote pl-1 border-left-primary border-left-3  active" data-toggle="collapse" data-target="#sm" data-parent="#menu">Voir tout <span class="badge badge-pill badge-primary float-right"><?= count($classes??[]); ?></span></a> </li> -->
                                            <?php foreach($data_classes??[] as $key => $item){ ?>
                                                    <li><a href="#" class="list-group-item blockquote pl-1 border-left-primary border-left-3  " data-toggle="collapse" data-target="#ID_<?= $item['classe_code']?>" data-parent="#menu"><?= $item['classe']; ?> <span class="badge  badge-pill bg-<?= "secondary" ?> float-right mr-2 badge-glow"><?= count($item['salle_classes']); ?></span> </a> </li>
                                                    <div id="ID_<?= $item['classe_code']?>" class="collapse ">
                                                        <?php foreach($item['salle_classes'] as $sub_key => $sub_item){ ?>
                                                            <li><a data-classe="ID_<?= $item['classe_code']?>" data-salle_classe="ID_<?= $sub_item['salle_classe_code']?>" id="ID_<?= $sub_item['salle_classe_code']?>"  class="list-group-item "><i class="fa fa-chevron-circle-right"> &nbsp;&nbsp;&nbsp;<?= $sub_item['salle_classe']; ?></i>   <span class="badge  badge-pill bg-<?= "warning" ?> float-right mr-0 badge-glow"><?= count($sub_item['eleves']); ?></span></a></li>
                                                        <?php } ?>
                                                    </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                        
                            </div>
                        </div>
                    <!--/ Predefined Views -->
                    
                    <!-- /Card sample -->
                    <hr>
                    <!-- Striped Progress sample -->
                        <div class="category-title pb-1">
                            <h6>Tendance des notes</h6>
                        </div>
                        <div>
                            <div class="progress progress-sm mt-1 mb-0">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress progress-sm mt-1 mb-0">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 60%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress progress-sm mt-1 mb-0">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    <!-- /Striped Progress sample -->
                    
                    <hr>
                    <!-- /Ratings sample -->
                        <div class="category-title pb-1">
                            <h6>Ratings example</h6>
                        </div>
                        <div class="">
                            <p class="card-text">This is the most basic example of ratings.</p>
                            <div id="score-rating"></div>
                            <a href="#" class="btn btn-primary ">Actualisaiton</a>
                        </div>
                    <!-- /Ratings sample -->
                </div>
            </div>
        </div>
    </div>

    <div class="content-left">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12">
                    <h3 class="content-header-title">Bulletin de note </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= URL::link('accueil') ?>">Accueil</a>
                                </li>
                                <li class="breadcrumb-item"><a href="<?= URL::link('enseignement_accueil') ?>">Enseignement</a>
                                </li>
                                <li class="breadcrumb-item active">Bulletin de notes
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <a class="btn btn-outline-info" href="calendars-clndr.html"><i class="fa fa-calendar"></i>&nbsp;&nbsp;Matiere</a>
                            <a class="btn btn-outline-info" href="timeline-center.html"><i class="fa fa-bar-chart"></i>&nbsp;&nbsp;SalleClasse</a>
                        </div>
                    </div>
                </div>
                <div class="content-header-lead col-12 mt-2">
                    <p class="">Cette page vous permet de d'enregistrer et de mettre à jour les notes des élèves obtenues dans differentes matieres par salle de classe.</p>
                </div>
            </div>

            <div class="content-body">
                <!-- Description -->
                <section id="description" class="card">
                    <div class="card-header">
                        <h4 class="card-title">Opion d'enregistrement</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="card-text">
                                <!-- Année scolaire -->
                                
                                <p>Tout ce qui concerne les outils de selection de la salle ou bien encore de la classe.</p>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-6">
                                    <div class="form-group row">
                                        <label for="eleve_nom_complet" class="col-3 col-form-label">Session:</label>
                                        <div class="col-9">
                                            <select id="eleve_nom_complet" class="select2 form-control" name="eleve_nom_complet" required>
                                                <?php foreach($periodeOfSession??[] as $key => $item){?>
                                                        <option data-code="<?= $item['session_code']; ?>" data-id="<?= $item['session_code']; ?>"  value="<?= $item['session_code']; ?>" ><?= $item['session']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="valid-feedback">Valider.</div>
                                    <div class="invalid-feedback">
                                        Veuillez remplir ce champ.
                                    </div>
                                </div>

                                <div class="col-xs-12 col-6">
                                    <div class="form-group row">
                                        <label for="classe" class="col-3 col-form-label">Periode:</label>
                                        <div class="col-9">
                                            <select id="classe" class="select2 form-control" name="classe" required>
                                                <!-- <option value="-----------">---------------</option> -->
                                                <?php foreach($periodes as $item){?>
                                                        <option data-id="<?= $item['periode_code']; ?>" value="<?= $item['periode_code']; ?>" ><?= $item['periode']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="valid-feedback">Valider.</div>
                                    <div class="invalid-feedback">
                                        Veuillez remplir ce champ.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Description -->
                <!-- CSS Classes -->
                <section id="css-classes" class="card">
                    <div class="card-header">
                        <h4 class="card-title">Bulletin de note de la salle de classe</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard ">
                            <p>Grid with filtering, editing, inserting, deleting, sorting and paging. Data provided by controller.</p>
                            <div id="basicScenario"></div>
                        </div>
                    </div>
                </section>
                <!--/ CSS Classes -->
                
            </div>
        </div>
    </div>
</div>