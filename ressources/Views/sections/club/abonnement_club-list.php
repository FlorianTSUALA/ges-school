<?php

use Core\Routing\URL;
use App\Helpers\Helpers;


$include_res_header = '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">'. "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/extensions/rowReorder.dataTables.min.css">'. "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/extensions/responsive.dataTables.min.css">'. "\n";
// $include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/forms/icheck/icheck.css">'. "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/app-assets/vendors/css/pickers/daterange/daterangepicker.css">'. "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/ui/jquery-ui.min.css">'. "\n";
$include_res_header .= '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/forms/selects/select2.min.css">'. "\n";
$include_res_header .= ''. "\n";


$include_res_footer = ''. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/jquery.dataTables.min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/datatable/dataTables.rowReorder.min.js"></script>'. "\n";
// $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/charts/echarts/echarts.js"></script>'. "\n";
// $include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/icheck/icheck.min.js"></script>'. "\n";

// <!-- BEGIN DATE PICKER VENDOR JS-->
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"></script>'. "\n";
$include_res_footer .= '<script src="'.URL::base().'assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>'. "\n";
// <!-- END DATE PICKER VENDOR JS-->

$include_res_footer .= "";

ob_start();


// include 'script-component-init.php';
// include 'abonnement_liste-script.php';
// include 'abonnement_cantine-script.php';
$include_footer_script = ob_get_clean();
?>
<!--
    ******  VARIABLES *****

    --- $title

-->

    <div class="app-content content bg-warningcreated22">
    <!-- <div class="app-content content"> -->
      <div class="content-wrapper">

        <div class="content-header row">
          <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Gestion des Abonnements</h3>
            <div class="row breadcrumbs-top d-inline-block">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= URL::link('accueil') ?>">Scolarité</a>
                  </li>
                  <li class="breadcrumb-item"><a href="#">Abonnements</a>
                  </li>
                  <li class="breadcrumb-item"><a href="#">Abonnés</a>
                  </li>
                </ol>
              </div>
            </div>
          </div>
          <div class="content-header-right col-md-4 col-12">
            <div class="btn-group float-md-right">
              <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-settings mr-1"></i>Action</button>
              <div class="dropdown-menu arrow"><a class="dropdown-item" href="#"><i class="fa fa-calendar mr-1"></i> Calender</a><a class="dropdown-item" href="#"><i class="fa fa-cart-plus mr-1"></i> Cart</a><a class="dropdown-item" href="#"><i class="fa fa-life-ring mr-1"></i> Support</a>
                <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="fa fa-cog mr-1"></i> Settings</a>
              </div>
            </div>
          </div>
        </div>

        <div class="content-detached content-right">
          <div class="content-body"><section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <div class="p-0  col-md-3 mr-auto "><h4 class="card-title" id="heading-prev-next">Abonnement Cantines</h4><small class="text-muted">Allows you to provide.</small></div>
                    
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
                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-settings mr-1"></i>Rapport</button>
                            <span class="dropdown-menu arrow  dropdown-menu-left">
                                <a href="#" class="dropdown-item"><i class="fa fa-file-excel-o"></i> Excel </a>                       
                                <a href="#" class="dropdown-item"><i class="fa fa-file-word-o"></i> Word</a>
                                <a href="#" class="dropdown-item"><i class="fa fa-file-pdf-o"></i> PDF </a>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="d-flex  mt-1">
                        <div class="alert bg-success alert-icon-left" role="alert">
                            <span class="alert-icon"><i class="fa fa-pencil-square"></i></span>
                            <span class="alert-icon"><i class="fa fa-pencil-square"></i></span>
                            <span id='resume_filtre' >Robust Admin Template default layout is 2 columns. If you do not define pageConfig block on padefault.</span>
                        </div>
                </div>
            	<!-- <h4 class="card-title">Abonnements</h4> -->
            	<!-- <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
        		<div class="heading-elements">
                    <div class="input-group input-group-sm">

                        <div class="d-inline-block custom-control  mr-1">
                            <input  id="datepicker" type='text' class="form-control localeRange" />
                        </div>

                        

                    </div>

                </div> -->
            </div>

            <div class="card-content">
                <div class="card-body">
	                <!-- Task List table -->
	                <div class="table-responsive">
		                <table id="table-cantine" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
					        <thead>
					            <tr>
					                <th style="width: 7%;">N°</th>
					                <th>nom_eleve</th>
					                <!-- <th>date_debut</th> -->
					                <!-- <th>date_fin</th> -->
					                <!-- <th>montant_total</th> -->
					                <th>Montant</th>
                                    <th>Date debut</th>
                                    <th>Date fin</th>
					            </tr>
					        </thead>
					        <tbody>

                            <!-- <span class="badge badge-info">In Progress</span> -->
                            <!-- <span class="badge badge-danger">Reopen</span> -->
                            <!-- <span class="badge badge-warning">Reopen</span> -->

                                <?php $i = 0;
                                foreach($abonnements as $abonnement){
                                    ?>
                                    <tr>
                                        <td style="width: 30px;"><a href="#" class="text-bold-600"><?= ++$i;?></a></td>
                                        <td>
                                            <ul class="list-inline clearfix mt-1" style="align:  center;">
                                                <li class="mr-3"><a href="#" class="text-bold-600"> <?= $abonnement['nom_eleve']  ;?> </a></li><br>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul class="list-inline clearfix mt-1" style="align:  center;">
                                                <li class="mr-3"><a href="#" class="text-bold-600"> <?= $abonnement['montant_total']  ;?> </a></li><br>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul class="list-inline clearfix mt-1" style="align:  center;">
                                                <li class="mr-3"><a href="#" class="text-bold-600"> <?= $abonnement['date_debut']  ;?> </a></li><br>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul class="list-inline clearfix mt-1" style="align:  center;">
                                                <li class="mr-3"><a href="#" class="text-bold-600"> <?= $abonnement['date_fin']  ;?> </a></li><br>
                                            </ul>
                                        </td>
                                  
                                    </tr>
                                <?php } ?>


					        </tbody>
					        <tfoot>
					            <tr>
                                <th style="width: 7%;">N°</th>
					                <th>nom_eleve</th>
					                <!-- <th>date_debut</th> -->
					                <!-- <th>date_fin</th> -->
					                <!-- <th>montant_total</th> -->
					                <th>Montant</th>
                                    <th>Date debut</th>
                                    <th>Date fin</th>
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
          <div class="sidebar"><div class="bug-list-sidebar-content">
    <!-- Predefined Views -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Liste des Classes</h4>
            <!-- <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a> -->
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-plus"></i></a></li>
                </ul>
            </div>
        </div>
        <!-- bug-list search -->
                                                                       
        <div class="card-content">


            
            <div class="card-body">
              <div id="menu" class="navigation navigation-main">
                <div class="list-group">
                <a href="<?= "#" ;?>" class="list-group-item active"> Voir tout</a>
                   <?php foreach($classes as $classe){ ?>
                        <a href="#" id="ID_<?= $classe['classe_id']?>" class="list-group-item" data-toggle="collapse" data-target="#ID_<?= $classe['classe_id']?>" data-parent="#menu"><?= $classe['classe']; ?> <span class="badge  badge-pill bg-<?= Helpers::getRandomBootstrapColor() ?> float-right mr-2 badge-glow"><?= count($classe['salles']); ?></span></a>
                        <div id="ID_<?= $classe['classe_id']?>" class=" collapse">
                            <?php foreach($classe['salles'] as $salle){ ?>
                                <a id="ID_<?= $salle['salle_classe_id']?>" class="list-group-item small "><span class="glyphicon glyphicon-chevron-right"></span> <?= $salle['salle_classe']; ?></a>
                            <?php } ?>
                        </div>
                   <?php } ?>

                </div>
              </div>
            </div>
            <!-- <div class="card-body border-top-blue-grey border-top-lighten-5">
                <div class="bug-list-search">
                    <div class="bug-list-search-content">
                        <form action="#">
                            <div class="position-relative">
                                <input type="search" class="form-control" placeholder="Search project bugs...">
                                <div class="form-control-position">
                                    <i class="ft-search text-size-base text-muted"></i>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->
            <!-- /bug-list search -->

            <!-- bug-list view -->
            
        </div>
    </div>
    <!--/ Predefined Views -->

    <!-- Bug Progress -->
                  <!-- <div class="card">
                      <div class="card-header">
                          <h4 class="card-title">Bug Progress</h4>
                          <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
                          <div class="heading-elements">
                              <ul class="list-inline mb-0">
                                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                  <li><a data-action="close"><i class="ft-x"></i></a></li>
                              </ul>
                          </div>
                      </div>
                      <div class="card-content">
                          <div class="card-body ">
                              <div id="bug-pie-chart" class="height-400 echart-container"></div>
                          </div>
                      </div>
                  </div>
                  Bug Progress -->
	

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Bug Progress</h4>
            <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body ">
            	<div id="bug-pie-chart" class="height-400 echart-container"></div>
            </div>
        </div>
    </div>
	<!--/ Bug Progress -->

	<!-- QA Team -->
    <!-- <div class="card">
        <div class="card-header mb-0">
            <h4 class="card-title">QA Team</h4>
            <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div class="card-body  py-0 px-0">
                <div class="list-group">
                    <a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                            <div class="media-left pr-1"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"><i></i></span></div>
                            <div class="media-body">
                                <h6 class="media-heading mb-0">Margaret Govan</h6>
                                <p class="font-small-2 mb-0">QA Analyst</p>
                            </div>
                        </div>
                    </a>
                    <a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                            <div class="media-left pr-1"><span class="avatar avatar-sm avatar-busy rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-2.png" alt="avatar"><i></i></span></div>
                            <div class="media-body">
                                <h6 class="media-heading mb-0">Bret Lezama</h6>
                                <p class="font-small-2 mb-0">QA Person</p>
                            </div>
                        </div>
                    </a>
                    <a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                            <div class="media-left pr-1"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-3.png" alt="avatar"><i></i></span></div>
                            <div class="media-body">
                                <h6 class="media-heading mb-0">Carie Berra</h6>
                                <p class="font-small-2 mb-0">QA Manager</p>
                            </div>
                        </div>
                    </a>
                    <a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                            <div class="media-left pr-1"><span class="avatar avatar-sm avatar-away rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-6.png" alt="avatar"><i></i></span></div>
                            <div class="media-body">
                                <h6 class="media-heading mb-0">Eric Alsobrook</h6>
                                <p class="font-small-2 mb-0">QA Lead</p>
                            </div>
                        </div>
                    </a>
                    <a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                            <div class="media-left pr-1"><span class="avatar avatar-sm avatar-away rounded-circle"><img src="../../../app-assets/images/portrait/small/avatar-s-8.png" alt="avatar"><i></i></span></div>
                            <div class="media-body">
                                <h6 class="media-heading mb-0">John Alsobrook</h6>
                                <p class="font-small-2 mb-0">QA Person</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div> -->
    <!--/ QA Team -->
</div> 
          </div>
        </div>
      </div>
    </div>
    </div>