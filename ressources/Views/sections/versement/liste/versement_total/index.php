
<?php

use Core\Routing\URL;
use App\Helpers\Helpers;
use App\Model\DBTable;
use App\Model\Facture;
use App\Model\Eleve;

    $include_res_header = '';
    $include_res_header = '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/extensions/rowReorder.dataTables.min.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/extensions/responsive.dataTables.min.css">'. "\n";
    // $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/forms/icheck/icheck.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/pickers/daterange/daterangepicker.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/ui/jquery-ui.min.css">'. "\n";
    $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/forms/selects/select2.min.css">'. "\n";
    $include_res_header .= Helpers::dataTableResponsibleSearchBar() . "\n";


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
// include 'versement_detail_modal-script.php';
// include 'versement_liste-script_new.php';
 //include 'index-script.php';
$include_footer_script = ob_get_clean();

$table_header = "
                    <tr>
                        <th style=\"width: 5px;\">N°</th>
                       
                        <th class=\"word-wrap;\">total</th>
                        <th style=\"width: 5px;\">Action</th>
                    </tr>
";

$table_header2 = "
                    <tr>
                        <th style=\"width: 5px;\">N°</th>
                       
                        <th class=\"word-wrap;\">Activité</th>
                        <th class=\"word-wrap;\">total</th>
                        <th style=\"width: 5px;\">Action</th>
                    </tr>
";
?>
<script>

   console.log('data_total')
    console.log(data_total)

</script>

<!--
    ******  VARIABLES *****

    --- $title

-->


<div class="app-content content">
<div class="content-wrapper">

  <div class="content-header row">
            <div class="content-header-left col-md-6 col-12">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <h3 class="content-header-title">Tableau de versements </h3>
                        <small class="text-muted">Consultation, Génération de reçus, filtré par période.</small>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= URL::link('accueil') ?>">Accueil</a>
                            </li>
                            
                            <li class="breadcrumb-item active">Versements
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                    </div>
                        <a class="btn btn-outline-info" href="<?= URL::link('versement_liste') ?>" title="gestion des salles de classes"><i class="fa fa-window-maximize"></i>&nbsp;&nbsp; Liste des versements</a>
                    <a class="btn btn-outline-info" href="<?= URL::link('facture_totale') ?>" title="gestion des classes"><i class="fa fa-window-restore"></i>&nbsp; &nbsp; Tous les Entrées</a>
                </div>
            </div>
            <div class="content-header-lead col-12 mt-2">
            </div>
        </div>
        <div>
        <!-- <div class="content-detached "> -->
        <div class="content-body">
            <section class="row card mb-0 pb-0">
            <div class="card">
                            <div class="card-content show mb-0 pb-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                            <div class="pb-1">
                                                <div class="clearfix mb-1">
                                                    <i class="ft-users font-large-1 blue-grey float-left mt-1"></i>
                                                    <span class="font-large-1 text-bold-100 info float-right"><?= number_format($data_inscription[0]->total) ?> FCFA</span>
                                                </div>
                                                <div class="clearfix">
                                                    <span class="text-muted">Total des Inscriptions Payées</span>
                                                    <!-- <span class="info float-right"><i class="ft-arrow-up info"></i> 16.89%</span> -->
                                                </div>
                                            </div>
                                            <div class="progress mb-0" style="height: 7px;">
                                                <!-- <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div> -->
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 border-right-blue-blue border-right-lighten-5">
                                            <div class="pb-1">
                                                <div class="clearfix mb-1">
                                                    <i class="icon-user-following font-large-1 blue-grey float-left mt-1"></i>
                                                    <span class="font-large-1 text-bold-100 blue float-right"><?= number_format($data_scolarite[0]->total) ?> FCFA</span>
                                                </div>
                                                <div class="clearfix">
                                                    <span class="text-muted"> Total des Scolartés Payées </span>
                                                    <!-- <span class="success float-right"><i class="ft-arrow-down success"></i> 2.24%</span> -->
                                                </div>
                                            </div>
                                            <div class="progress mb-0" style="height: 7px;">
                                                <!-- <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div> -->
                                            </div>
                                       </div>
                                        <div class="col-lg-3 col-sm-12 border-right-blue-blue border-right-lighten-5">
                                            <div class="pb-1">
                                                <div class="clearfix mb-1">
                                                    <i class="icon-user-unfollow font-large-1 blue-blue float-left mt-1"></i>
                                                    <span class="font-large-1 text-bold-100 blue float-right"><?= number_format($data_cantine[0]->total) ?> FCFA</span>
                                                </div>
                                                <div class="clearfix">
                                                    <span class="text-muted">Total Cantine Payée </span>
                                                    <!-- <span class="danger float-right"><i class="ft-arrow-up danger"></i> 5.14%</span> -->
                                                </div>
                                            </div>
                                            <div class="progress mb-0" style="height: 7px;">
                                                <!-- <div class="progress-bar bg-danger" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div> -->
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-3 col-sm-12">
                                            <div class="pb-1">
                                                <div class="clearfix mb-1">
                                                    <i class="icon-calendar font-large-1 blue-blue float-left mt-1"></i>
                                                    <span class="font-large-1 text-bold-100 blue float-right"><?= number_format($data_activite_total[0]->total) ?> FCFA</span>
                                                </div>
                                                <div class="clearfix">
                                                    <span class="text-muted">Total des Activités Payées</span>
                                                    <!-- <span class="warning float-right"><i class="ft-arrow-up warning"></i> 43.84%</span> -->
                                                </div>
                                            </div>
                                            <div class="progress mb-0" style="height: 7px;">
                                                <!-- <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                             -->
                                            </div>
                                        </div>
                                    </div>

                                  <div class="row">
                                    
                                        <div class="col-lg-6 col-sm-12">
                                            <table>
                                                <tr>
                                                <h3>
                                                    <td style="width:150px; font-size:160%;font-family:verdana;">Activité</td>
                                                    <td style="width:150px; font-size:160%;font-family:verdana;">Somme</td>
                                                </h3>
                                              
                                                    <?php foreach ($data_activite as $key => $data): ?> 
                                                     <tr>
                                                        <td><?= $data->libelle ?></td>
                                                        <td><?= number_format($data->total); ?>FCFA</td> 
                                                      </tr>
                                                    <?php endforeach;  ?>
                                               
                                            </table>
                                        </div>

                                  </div>

                                  <br><br><br>

                            <div id="heading-etape-04" role="tab" class="card-header border-bottom-black border-bottom-warning">
                               <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion-etape-04" aria-expanded="false" aria-controls="accordion-etape-04" class="text-uppercase black collapsed"><strong>Entrées Journalière</strong></a>
                            </div>
                                    <div class="row">
                                   

                                        <div class="col-lg-8 col-sm-12">
                                          
                                        </div>

                                        <div class="col-lg-4 col-sm-12">
                                                <div class="pb-1">
                                                    <div class="clearfix mb-1">
                                                        <span class="font-large-1 text-bold-100 blue float-right"><?= number_format($data_total[0]->total) ?> FCFA</span>
                                                    </div>
                                                    <div class="clearfix">
                                                        <span class="text-muted"></span>
                                                        <!-- <span class="warning float-right"><i class="ft-arrow-up warning"></i> 43.84%</span> -->
                                                    </div>
                                                </div>
                                                <div class="progress mb-0" style="height: 7px;">
                                                    <!-- <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                    -->
                                                </div>
                                        </div>
                                   </div>


                                </div>
                            
                            
                            </div>
                        </div>
            </section>
        </div>
      
          </div>


    </div>
    </div>
    </div>



