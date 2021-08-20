
<?php

use Core\Routing\URL;

$include_res_header = '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/css/plugins/forms/wizard.css">';
$include_res_header .= '';
$include_res_header .= '<style>
                            .error {
                                color: red;
                            }
                        </style>';

$include_res_footer = '';
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/extensions/jquery.steps.min.js"></script>';
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>';
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>';

$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>';

ob_start();
include "inscription-script.php";
$include_footer_script = ob_get_clean();

?>

<div class="app-content content bg-warningcreated22">
    <div class="content-wrapper">
        <div class="content-body">
            <section class="row">
                <div class="col-sm-12">
                    <!-- ESPACE DE TRAVAIL -->
                    <div id="kick-start" class="border-2 border-warning card box-shadow-2">
                        <div class="card-header border-bottom-2 border-bottom-warning card-header-inverse ">
                            <h4 class="card-title center text-uppercase">
                                Processus d'inscription
                            </h4>
                        </div>

                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="card-text">
                                    <p >Renseigner toutes les informations concernant l'élève.</p>
                                </div>

                                <div class="">
                                    <section id="validation">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">

                                                    <div class="card-content collapse show">
                                                        <div class="card-body">
                                                            <form id="form-inscription" action="<?= URL::link('inscrire-create'); ?>" method="POST" class="steps-validation wizard-circle needs-validation" enctype="multipart/form-data" novalidate>
                                                                <?php
                                                                //ETAPE IDENTIFICATION ELEVE
                                                                    require_once "inscription_etape_01.php";

                                                                //ETAPE DOSSIER PARENTAL - PERE,MERE et ANTECEDENT SCOLAIRE
                                                                    require_once "inscription_etape_02.php";

                                                                //ETAPE DOSSIER MEDICAL

                                                                    require_once "inscription_etape_03.php";


                                                                //ETAPE VERIFICATION DES INFORMATIONS
                                                                    require_once "inscription_etape_04.php";
                                                                ?>
                                                            </form>
                                                        </div>
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
        </div>
    </div>
</div>