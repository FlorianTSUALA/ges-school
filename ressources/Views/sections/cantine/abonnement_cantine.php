<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

$include_res_header = '<link rel="stylesheet" type="text/css" href="' . URL::base() . 'assets/app-assets/css/plugins/forms/wizard.css">';
$include_res_header .= '';
$include_res_header .= '<style>
                            .error {
                                color: red;
                            }
                        </style>';

$include_res_footer = '';
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/extensions/jquery.steps.min.js"></script>';
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>';
$include_res_footer .= '<script src="' . URL::base() . 'assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>';



ob_start();
//select2
echo '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>';
echo '<script src="' . URL::base() . 'assets/app-assets/vendors/js/forms/repeater/jquery.input.js"></script>';
// echo '<script src="' . URL::base() . 'assets/app-assets/vendors/js/forms/repeater/lib.js"></script>';
echo '<script src="' . URL::base() . 'assets/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>';
//switch bootstrap https://github.com/Bttstrp/bootstrap-switch [https://github.com/Bttstrp/bootstrap-switch/issues/343]
echo '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js"></script>';
echo '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js"></script>';
// echo '<script src="'.URL::base().'assets/"></script>';

require 'script-component-init.php';
require 'abonnement_cantine-script.php';
// require 'script-update-etat.php';
require 'script-save.php';

$include_footer_script = ob_get_clean();

$include_res_header .=  '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css">';
$include_res_header .=  '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/css/plugins/loaders/loaders.min.css">';

?>

<div class="app-content content bg-warningcreated22">
    <div class="content-wrapper">

        <div class="content-body">

            <section class="row" id="section_versement">
                <div class="col-sm-12">
                    <!-- ESPACE DE TRAVAIL -->
                    <div id="kick-start" class="border-2 border-warning card box-shadow-2">
                        <div
                            class="card-header border-bottom-2 border-bottom-warning card-header-inverse ">
                            <h4 class="card-title center text-uppercase">
                                Versement de frais de cantine
                            </h4>
                        </div>

                        <div class="card-content collapse show">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="card-text">
                                            <p class="text-warning font-medium-3">
                                                <strong>Renseigner toutes les informations utiles.</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="">
                                    <section id="validation">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="eleve_nom_complet" class="col-4 col-form-label">Nom Complet<?= Helpers::required_input(); ?>:</label>
                                                    <div class="col-8">
                                                        <select id="eleve_nom_complet" class="select2 form-control" name="eleve_nom_complet" required>
                                                            <?php foreach ($eleves as $item) { ?>
                                                                <option data-matricule="<?= $item['matricule']; ?>" data-id="<?= $item['id']; ?>" title="<?= "Né " . $item['date_naissance'] . " à " . $item['lieu_naissance']; ?>" value="<?= $item['id']; ?>"><?= $item['libelle']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="valid-feedback">Valider.</div>
                                                <div class="invalid-feedback">
                                                    Veuillez remplir ce champ.
                                                </div>
                                            </div>
 
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="classe" class="col-1 col-form-label"></label>
                                                    <label for="classe" class="col-3 col-form-label">Classe<?= Helpers::required_input(); ?>:</label>
                                                    <div class="col-8">

                                                        <select id="classe" class="select2 form-control" name="classe" required>
                                                            <!-- <option value="-----------">---------------</option> -->
                                                            <?php foreach ($classes as $item) { ?>
                                                                <option data-id="<?= $item['id']; ?>" value="<?= $item['id']; ?>"><?= $item['libelle']; ?></option>
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
                                        <p class="font-small-3">NB : Si toutes les dates de début sont identiques, alors la référence de tous les abonemments sera les dates cumullées des periodes de chaque abonnement.</p>
                                        <hr>

                                        <div class="row">
                                            <div class="card">

                                                <div class="card-content collapse show">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <form action="" class="repeater" enctype="multipart/form-data">
                                                                <div data-repeater-list="data">
                                                                    <div data-repeater-item class="row ml-3">
                                                                        <!-- <div class=" col-sm-12 col-md-3"> 
                                                                            <fieldset class="mb-1">
                                                                                <h5>Date debut </h5>
                                                                                <div class="form-group">
                                                                                    <input type="hidden" class="date_debut form-control" value="<?= date("Y-m-d");?>" name="date_debut">
                                                                                    <input type="date" class="_date_debut form-control" min="<?= date("Y-m-d");?>" value="<?= date("Y-m-d");?>" name="_date_debut">
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>-->
                                                                        <div class=" col-sm-12 col-md-3">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Période </h5>
                                                                                <div class="periode-item form-group">
                                                                                    <select class="periode form-control" name="periode">
                                                                                        <option value="JOUR"> Jour </option>
                                                                                        <option value="SEMAINE"> semaine </option>
                                                                                        <option value="MOIS"> Mois </option>
                                                                                        <option value="ANNEE"> Année </option>
                                                                                    </select>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <div class=" col-sm-12 col-md-3">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Durée </h5>
                                                                                <div class="form-group">
                                                                                    <input type="number" class="duree form-control " min="1" value="1" name="duree" />
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>


                                                                        <div class=" col-sm-12 col-md-3 ">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Prix Unitaire </h5>
                                                                                <div class="form-group">
                                                                                    <input type="number" class="prix_unitaire form-control " min="0" step="any" value="" name="prix_unitaire" />
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>


                                                                        <div class=" col-sm-12 col-md-2">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Total
                                                                                </h5>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="sous_total form-control " value="0" name="sous_total" placeholder="" readonly />
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                        <div class=" col-sm-12 col-md-1">
                                                                            <fieldset class="mb-1">
                                                                                <h5>&nbsp
                                                                                </h5>
                                                                                <div class="form-group">
                                                                                    <button type="button" class="btn btn-danger" data-repeater-delete><i class="ft-trash-2"></i> </button>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="row ml-2">
                                                                        <div class="col-md-3">
                                                                            <fieldset class="mb-1">
                                                                                <h5>&nbsp; </h5>
                                                                                <div class="form-group">
                                                                                    <input data-repeater-create class="btn btn-primary" type="button" value="Ajouter"/>
                                                                                </div>
                                                                            </fieldset>

                                                                        </div>


                                                                         <div class=" col-sm-12 col-md-4">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Remise </h5>
                                                                                <div class="form-group">
                                                                                    <input type="number" class="form-control " id="reduction" min="0" value="0" name="reduction" placeholder="" />
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <fieldset class="mb-1">
                                                                                <h5>Montant à payer </h5>
                                                                                <div class="form-group">
                                                                                    <input readonly  placeholder="" value="0" type="text" class="form-control" id="montant_total" name="montant_total" />
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>
                                                                </div>

                                                                <!-- <i class="ft-plus"></i> -->
                                                            </form>

                                                        </div>

                                                        <hr>

                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <div class="form-group row">
                                                                    <label for="date_debut" class="col-4 col-form-label">Date de debut:</label>
                                                                    <div class="col-8">
                                                                        <input type="date" class="form-control" value="<?= date("Y-m-d");?>" id="date_debut" name="date_debut" />
                                                                    </div>
                                                                </div>

                                                                <div class="valid-feedback">Valider.</div>
                                                                <div class="invalid-feedback">
                                                                    Veuillez remplir ce champ.
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group row">
                                                                    <label for="type_paiement" class="col-4 col-form-label">Type de paiement:</label>
                                                                    <div class="col-8">
                                                                        <select id="type_paiement" class="select2 form-control" name="type_paiement" required>
                                                                            <?php
                                                                            foreach ($type_paiements as $item) {
                                                                                ?>
                                                                                <option value="<?= $item['id']; ?>"><?= $item['libelle']; ?></option>
                                                                            <?php
                                                                            } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="valid-feedback">Valider.</div>
                                                                <div class="invalid-feedback">
                                                                    Veuillez remplir ce champ.
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group row">
                                                                    <label for="date_versement" class="col-4 col-form-label">Date de versement&nbsp;:</label>
                                                                    <div class="col-8">
                                                                        <input type="date" class="form-control" value="<?= date("Y-m-d");?>" id="date_versement" name="date_versement" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Invoice Footer -->
                                                        <hr>

                                                        <div id="invoice-footer" class=" col-12" >
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-12">
                                                                    <h6>Conditions générales</h6>
                                                                    <p>Après debut, votre argent est non-remboursable.</p>
                                                                </div>
                                                                <div class="col-md-6 col-sm-12 text-right">

                                                                    <div class="loader-container">
                                                                        <div id="loading" class="line-scale-party loader-warning" style="display:  none;">
                                                                            <div></div>
                                                                            <div></div>
                                                                            <div></div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>


                                                                    <a href="<?= URL::link('accueil') ?>" id="btn_accueil" class="btn btn-danger my-1">
                                                                        accueil</a>
                                                                    <a href="#" id="btn_preview" class="btn btn-warning my-1">Prévisualiser</a>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/ Invoice Footer -->

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer border-top-2 border-top-warning">
                            <span>Ges-School</span>
                        </div>
                    </div>
                </div>
            </section>

            <?php include "cantine_abonnement_etat.php"; ?>

        </div>
    </div>
</div>
