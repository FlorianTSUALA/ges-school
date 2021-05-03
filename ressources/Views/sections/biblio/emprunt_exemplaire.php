
<?php

use Core\Routing\URL;
use App\Helpers\Helpers;    

    $include_res_header = '';
    $include_res_header = '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/extensions/rowReorder.dataTables.min.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/extensions/responsive.dataTables.min.css">'. "\n";
    // $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/forms/icheck/icheck.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/pickers/daterange/daterangepicker.css">'. "\n";
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
    $include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/forms/repeater/lib.js"></script>';
    $include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>';


    // $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>'. "\n";
    // $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>'. "\n";
    // $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/repeater/jquery.input.js"></script>'. "\n";
    // $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/icheck/icheck.min.js"></script>'. "\n";
    
    // <!-- BEGIN DATE PICKER VENDOR JS-->
    $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"></script>'. "\n";
    $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>'. "\n";
    // <!-- END DATE PICKER VENDOR JS-->
    
$include_res_footer .= "";

ob_start();
include 'emprunt_exemplaire-script.php';
include 'restitution_modal-script.php';
include 'emprunt_modal-script.php';
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
                    <div class="btn-group" role="group">
                        <a class="btn btn-outline-info" href='<?= URL::link('domaine') ?>'><i class="fa fa-folder-open"></i>&nbsp; Gerer les Domaines</a>
                        <a class="btn btn-outline-info" href='<?= URL::link('document') ?>'><i class="fa fa-book"></i>&nbsp; Gerer les livres</a>
                        <a class="btn btn-outline-info" href='<?= URL::link('accueil') ?>'><i class="fa fa-bookmark"></i>&nbsp; Gerer les exemplaires</a>
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
                                    <div class="p-0 mr-1   ">
                                        <button class="btn btn-primary "  data-toggle="modal" data-target="#modal-emprunt"><i class="ft-plus white"></i> Emprunter un livre</button>
                                    </div>
                                    <div class="p-0 mr-1 ">
                                        <fieldset class="input-group">
                                            <!-- <div class="input-group-prepend">
                                            <span class="input-group-text">L &nbsp; <span class="fa fa-calendar"></span></span>
                                            </div> -->
                                            <input id="localization" type='text' class="form-control form-control-sm localeRange" />
                                            <div class="input-group-append">
                                            <span class="input-group-text">Date &nbsp; <span class="fa fa-calendar"></span></span>
                                            </div>
                                            <!-- <small class="text-muted">Allows you to provide.</small> -->
                                        </fieldset>
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
                                <div class="d-flex  mt-1 ">
                                        <div class="alert bg-success alert-icon-left" role="alert">
                                            <span class="alert-icon"><i class="fa fa-pencil-square"></i></span>
            
                                            <span class="alert-icon"><i class="fa fa-pencil-square"></i></span>
                                            <span id='resume_filtre' >Liste des documents empruntés.</span>
                                        </div>
                                </div>
                            
                            </div>
                            
                            <div class="card-content my-0 py-0">
                                <div class="card-body">
                                    <div class="table-responsive-sm">
                                        <table id="table-emprunt" class="table table-white-space table-bordered  table-sm" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>N°</th>
                                                    <th>Code</th>
                                                    <th>Livre</th>
                                                    <th>Elève</th>				                
                                                    <th>Date Emprunt</th>
                                                    <th>Date Retour</th>
                                                    <th>Classe</th>				                
                                                    <th>Etat</th>				                
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>id</th>
                                                    <th>N°</th>
                                                    <th>Code</th>
                                                    <th>Livre</th>
                                                    <th>Elève</th>				                
                                                    <th>Date Emprunt</th>
                                                    <th>Date Retour</th>
                                                    <th>Classe</th>				                
                                                    <th>Etat</th>				                
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
                    <div class="card m-0">
                        <div class="card-header">
                            <h4 class="card-title">Recherche par livre</h4>
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
                                                <input type="search" class="form-control menu-search"  placeholder="Liste des livres...">
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
                                        <li><a href="#" class="list-group-item blockquote pl-1 border-left-primary border-left-3  active" data-toggle="collapse" data-target="#sm" data-parent="#menu">Voir tout <span class="badge badge-pill badge-primary float-right"><?= count($domaines); ?></span></a> </li>
                                        <?php foreach($domaines as $domaine){ ?>
                                                <li><a href="#" class="list-group-item blockquote pl-1 border-left-primary border-left-3  " data-toggle="collapse" data-target="#ID_<?= $domaine['domaine_id']?>" data-parent="#menu"><?= $domaine['domaine']; ?> <span class="badge  badge-pill bg-<?= Helpers::getRandomBootstrapColor() ?> float-right mr-2 badge-glow"><?= count($domaine['documents']); ?></span> </a> </li>
                                                <div id="ID_<?= $domaine['domaine_id']?>" class="collapse ">
                                                    <?php foreach($domaine['documents'] as $document){ ?>
                                                        <li><a id="ID_<?= $document['document_id']?>"  class="list-group-item "><i class="fa fa-chevron-circle-right"></i>  <?= $document['document']; ?> </a></li>
                                                    <?php } ?>
                                                </div>
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



<?php include 'emprunt_modal.php' ?>
<?php include 'restitution_modal.php' ?>