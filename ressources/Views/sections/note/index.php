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
                        <a class="btn btn-outline-info" href="<? URL::link('matiere')?>"><i class="fa fa-calendar"></i>&nbsp;&nbsp;Matiere</a>
                        <a class="btn btn-outline-info" href="<? URL::link('salle_classe')?>"><i class="fa fa-bar-chart"></i>&nbsp;&nbsp;Salle Classe</a>
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
                            <div class="col-xs-12 col-4">
                                <div class="form-group row">
                                    <label for="session" class="col-3 col-form-label">Session:</label>
                                    <div class="col-9">
                                        <select id="session" class="select2 form-control" name="session" required>
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

                            <div class="col-xs-12 col-4">
                                <div class="form-group row">
                                    <label for="periode" class="col-3 col-form-label">Periode:</label>
                                    <div class="col-9">
                                        <select id="periode" class="select2 form-control" name="periode" required>
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

                            <div class="col-xs-12 col-4">
                                <div class="form-group row">
                                    <label for="salle_classe" class="col-3 col-form-label">Salle de classe:</label>
                                    <div class="col-9">
                                        <select id="salle_classe" class="select2 form-control" name="salle_classe" required>
                                            <!-- <option value="-----------">---------------</option> -->
                                            <?php foreach($data_salle_classes as $item){?>
                                                    <option data-id="<?= $item['salle_classe_code']; ?>" value="<?= $item['salle_classe_code']; ?>" ><?= $item['salle_classe']; ?></option>
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
                        
                         <!-- <option value="-----------">---------------</option> -->
                         <?php foreach($data_salle_classes as $item){?>
                            <div id="table_bulletin_note<?= $item->code?>" class="table_bulletin_note <?= "active"?>"></div>
                        <?php } ?>
                    </div>
                </div>
            </section>
            <!--/ CSS Classes -->
            
        </div>
    </div>
    
</div>