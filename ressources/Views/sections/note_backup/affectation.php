<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

use function Core\Helper\dd;

$include_res_header = '';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/app-assets/vendors/css/forms/listbox/bootstrap-duallistbox.min.css">';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/app-assets/css/plugins/forms/dual-listbox.css">';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/app-assets/css/plugins/animate/animate.css">';
$include_res_header .= '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/app-assets/css/core/colors/palette-callout.css">';

$include_res_header .= '
                        <style>
                            #menu .list-group a.list-group-item:hover{
                                background-color: #3bafda;
                                color: white;
                            }
                        </style>

' . "\n";
$include_res_header .= '' . "\n";

$include_res_footer = '' . "\n";
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/forms/listbox/jquery.bootstrap-duallistbox.min.js"></script>';
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/tables/jsgrid/jsgrid.min.js"></script>';
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/animation/jquery.appear.js"></script>';
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/js/scripts/animation/animation.js"></script>';
$include_res_footer .= "";
$include_res_footer .= '' . "\n";

ob_start();
// include 'listener.php';
// include 'buiderHtml.php';
include 'index-script.php';

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
            <h3 class="content-header-title">Affectation Classe - Matiere	</h3>
            <div class="row breadcrumbs-top">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"> <a href="<?= URL::link('accueil') ?>">Accueil</a></li>
                  <li class="breadcrumb-item"> <a href="<?= URL::link('accueil') ?>">Affectation</a></li>
                  <li class="breadcrumb-item active"><a href="#">Salle - Eleve</a> </li>
                </ol>
              </div>
            </div>
          </div>
          <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <div class="btn-group" role="group">
                    <a class="btn btn-outline-info" href="<?= URL::link('eleve') ?>"> <i class="fa fa-slack"> Gestion Eleve</i></a> 
                    <a class="btn btn-outline-info" href="<?= URL::link('classe') ?>"> <i class="fa fa-book"> Gestion Classe</i></a> 
                    <a class="btn btn-outline-info" href="<?= URL::link('salle_classe') ?>"> <i class="fa fa-tags"> Gestion Salle de Classe</i></a> 
                </div>

            </div>
          </div>

          <div class="content-header-lead col-12 mt-2">
            <p class="lead"></p>
          </div>
        </div>

        <div class="content-detached content-right">
            <div class="content-body">
                <!-- Dual ListBox Custom Options start -->
                
                <?php foreach($data??[] as $item){?>
                    <section class="row with-custom-options">
                        <div class="col-12">
                            <div class="card"  data-appear="appear" data-animation="<?= Helpers::getRandomAnimation() ?>">
                                <div class="card-header">
                                    <h4 class="card-title">Affectation  <?= $item['classe']; ?> - <?= $item['salle_classe']; ?> </h4>
                                    <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <select multiple="multiple" size="10" class="duallistbox-dynamic">
                    
                                            <?php  foreach($item_items as $sub_item){ ?>
                                                    <option value="<?= $sub_item['code']; ?>" <?= is_null($sub_item['action'])? 'selected="selected"':''; ?>><?= $sub_item['value']; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        <div class="buttons block">
                                            <button type="button" class="btn btn-info duallistbox-add">Add options</button>
                                            <button type="button" class="btn btn-info duallistbox-add-clear">Add with clearing highlights</button>
                                        </div>
                                        <p class="mt-1"> Add an option to the Listbox Using <code>Add Options</code> button. Add an option and also clearing highlights of listbox option using <code>Add with clearing highlight</code> button</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php } ?>

                <!-- Dual ListBox Custom Options end -->
            </div>
        </div>

        <div class="sidebar-detached sidebar-left">
            <div class="sidebar">
                <div class="bug-list-sidebar-content">
                    <!-- Predefined Views -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Liste des classes</h4>
                            <small class="text-muted">Classe concernée par l'affectation.</small> 
                            <br><small class="text-muted"> <code>Avenir : </code> Indication du nombre de d'eleve nom affecté par salle dans le menu.</small>
                            <br><small class="text-muted"> <code>Avenir : </code> Information d'affectation pour un élève donné.</small>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div id="menu" class="navigation navigation-main">
                                    <div class="list-group">
                                        <a href="<?= "#"; ?>"  id="ID_ALL" class="list-group-item"> Voir tout</a>
                                        <?php
                                            foreach (json_decode($classes) as $item) { ?>
                                            <a href="#" id="ID_<?= $item->id ?>"  data-id="ID_<?= $item->id ?>" 
                                                class="list-group-item" data-toggle="collapse" 
                                                data-parent="#menu">
                                                <?= $item->value ?> 
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