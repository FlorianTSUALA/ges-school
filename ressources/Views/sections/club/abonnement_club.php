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
require 'abonnement_club-script.php';
// require 'script-update-etat.php';
require 'script-event.php';

// require "script-event.php";
// require "script-component-init.php";
// require "script-update-etat.php";
require "script-save.php";
// require "script-versement_scolarite.php";

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
                                Souscription à une activitée
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
                                       
                                        <p class="font-small-3">NB : Si toutes les dates de début sont identiques, alors la référence de tous les abonemments sera les dates cumullées des periodes de chaque abonnement.</p>
                                        <hr>

                                        <div class="row">
                                            <div class="card">

                                                <div class="card-content collapse show">
                                                    <div class="card-body">
                                                       
                                                            <form action="" class="repeater" enctype="multipart/form-data">

                                                            </form>

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

                                                   
                                                    </div>

                                                                      
                            <div class="row">

<div class="col-3 ">
    <fieldset class="mb-1">
        <h5>Activité</h5>
        <div class="form-group">
            <select class="select2 form-control" multiple="multiple"  id="SELECT-COL2-Activite"  name="SELECT-COL2-Activite"   required>
            <?php foreach($activites as $activite){?>
                    <option value="<?= $activite['id']; ?>" title="<?= $activite['montant']; ?>" ><?= $activite['libelle']; ?></option>
            <?php } ?>
            </select>
        </div>
    </fieldset>
</div>


<div id="" class="col-4">
        <fieldset class="mb-1">
            <h5>Multiplicateur</h5>
            <div class="form-group">
                <select class="select2 form-control" multiple="multiple"  id="SELECT-COL3-Activite"  name="SELECT-COL3-Activite"   required>
                <?php foreach($tranche_scolaires as $tranche_scolaire){?>
                        <option value="<?= $tranche_scolaire['id']; ?>" ><?= $tranche_scolaire['libelle']; ?></option>
                <?php } ?>
                </select>
            </div>
        </fieldset>
</div> 

<div class="col-2">
    <fieldset class="mb-1">
        <h5>Reduction</h5>
        <div class="form-group">
            <input type="number" class="form-control reduction"  id="COL5-Activite" value="0"  name="COL5-Activite"   placeholder="" />
        </div>
    </fieldset>
</div>


<div class="col-3">
    <fieldset class="mb-1">
        <h5>Recaputilatif</h5>
        <div class="form-group">
            <input type="text" class="form-control "  id="COL4-Activite" value="0"  name="COL4-Activite"   placeholder="" readonly/>
        </div>
    </fieldset>
</div>
</div>

                           <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                            <div class="col-1">
                                                                                   
                                                                                </div>
                                                                                <div class="col-3">
                                                                                    <button type="button" id="btn-abonnement_club_save" class="btn btn-warning btn-darken">Enregistrer</button>
                                                                                </div>
                                                                                <!-- <div class="col-8">

                                                                                        <input placeholder="Reduction" type="text" class="form-control reduction" id="RFT-reduction" name="RFT-reduction" readonly/>

                                                                                </div>
                                                                            </div>
                                                                        </div> -->
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

            <?php //include "cantine_abonnement_etat.php"; ?>

        </div>
    </div>
</div>
