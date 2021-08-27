
<?php

use Core\Routing\URL;
use App\Helpers\Helpers;    

    $include_res_header = '';
    $include_res_header = '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/extensions/rowReorder.dataTables.min.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/extensions/responsive.dataTables.min.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/ui/jquery-ui.min.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/forms/selects/select2.min.css">'. "\n";
    $include_res_header .= Helpers::dataTableResponsibleSearchBar() . "\n";
    $include_res_header .=  '<style>
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
                        
                        
                    ';
    
    $include_res_footer = ''. "\n";
    $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/jquery.dataTables.min.js"></script>'. "\n";
    $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>'. "\n";
    $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>'. "\n";
    $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/datatable/dataTables.rowReorder.min.js"></script>'. "\n";


    $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>';
    $include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/forms/repeater/jquery.input.js"></script>';

    
    // <!-- END DATE PICKER VENDOR JS-->
    
$include_res_footer .= "";

ob_start();
include 'index-script.php';

$include_footer_script = ob_get_clean();
?>
<!--
    ******  VARIABLES *****

    --- $title

-->

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12">
                <h3 class="content-header-title">Bibliothèque	</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= URL::link('accueil') ?>">Accueil</a> </li>
                            <li class="breadcrumb-item"><a href="<?= URL::link('biblio_accueil') ?>">Bibliothèque</a> </a> </li>
                            <li class="breadcrumb-item active">Emprunt de documents </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group"><a class="btn btn-outline-info" href="<?= URL::link('eleve') ?>"> 
                        <i class="fa fa-user-plus"> Nouvel Elève</i></a> 
                    </div>
                    <div class="btn-group" role="group"><a class="btn btn-outline-info" href="<?= URL::link('eleve_liste_inscrit') ?>"> 
                        <i class="fa fa-user"> Elèves Inscrits</i></a> 
                    </div>
                    <div class="btn-group" role="group"><a class="btn btn-outline-info" href="<?= URL::link('eleve_liste_non_inscrit') ?>"> 
                        <i class="fa fa-user-secret"> Elèves Non Inscrits</i></a> 
                    </div>
                    <div class="btn-group" role="group"><a class="btn btn-outline-info" href="<?= URL::link('eleve_liste') ?>"> 
                        <i class="fa fa-users"> Tous les élèves</i></a> 
                    </div>
                </div>
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

                            <div class="card-header my-0 pb-0">
                                <div class="d-flex">
                                    <div class="p-0  col-md-3 mr-auto ">
                                        <h4 class="card-title" id="heading-prev-next">Liste des livres empruntés</h4>
                                        <small class="text-muted">Emprunt, Consulatation, Restitution.</small>
                                    </div>
                                    
                                    <div class="p-0   ">
                                        <span class="dropdown">
                                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled><i class="icon-settings mr-1"></i>Rapport</button>
                                            <span class="dropdown-menu arrow  dropdown-menu-left">
                                                <a href="#" class="dropdown-item"><i class="fa fa-file-excel-o"></i> Excel </a>                       
                                                <a href="#" class="dropdown-item"><i class="fa fa-file-word-o"></i> Word</a>
                                                <a href="#" class="dropdown-item"><i class="fa fa-file-pdf-o"></i> PDF </a>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-content my-0 py-0">
                                <div class="card-body">
                                    <div class="table-responsive-sm">
                                        <table id="table-eleve" class="table table-white-space table-bordered  table-sm" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <!-- <th>id</th> -->
                                                    <th>N°</th>
                                                    <th>Nom Complet</th>
                                                    <!-- <th>Classe</th> -->
                                                    <th>Sexe</th>
                                                    <th>Age</th>
                                                    <!-- <th>photo</th> -->
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <!-- <th>id</th> -->
                                                    <th>N°</th>
                                                    <th>Nom Complet</th>
                                                    <!-- <th>Classe</th> -->
                                                    <th>Sexe</th>
                                                    <th>Age</th>
                                                    <!-- <th>photo</th> -->
                                                    <th>Actions</th>
                                                </tr>
                                            </tfoot>
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
                                        <?php foreach ($classes as $item) { ?>
                                            <a href="#" id="ID_<?= $item['classe_id'] ?>" 
                                                class="list-group-item" data-toggle="collapse" 
                                                data-parent="#menu">
                                                <?= $item['classe']; ?> 
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

