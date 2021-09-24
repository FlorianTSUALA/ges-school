
<?php

use Core\Routing\URL;
use Core\Session\Request;

$include_res_header = '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/css/plugins/forms/wizard.css">';
$include_res_header .= '';
$include_res_header .= '<style>
                            .error {
                                color: red;
                            }
                            img:hover {
                                cursor: pointer;
                            }
                        </style>';

$include_res_footer = '';
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/extensions/jquery.steps.min.js"></script>';
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>';
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>';
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>';

ob_start();
include "modifier_personnel-script.php";
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
                                Processus de mise à jour d'un personnel
                            </h4>
                        </div>

                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="card-text">
                                    <p >Renseigner toutes les nouvelles mises à jour concernant du personnel.</p>
                                </div>

                                <div class="">
                                    <section id="validation">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">

                                                    <div class="card-content collapse show">
                                                        <div class="card-body">
                                                            <form id="form-modifier_personnel" action="<?= URL::link('personnel-update') . '/' . Request::getSecParam('id') ?>" method="POST" class="steps-validation wizard-circle needs-validation" enctype="multipart/form-data" novalidate>
                                                                <?php
                                                                //ETAPE IDENTIFICATION PERSONNEL
                                                                    require_once "modifier_personnel_etape_01.php";

                                                                //ETAPE VERIFICATION DES INFORMATIONS
                                                                    require_once "modifier_personnel_etape_02.php";

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