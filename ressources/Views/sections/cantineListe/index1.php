<?php

use Core\Routing\URL;
use App\Helpers\Helpers;


$include_res_header = '<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">';
$include_res_header .= '
<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/extensions/rowReorder.dataTables.min.css">';
$include_res_header .= '
<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/tables/extensions/responsive.dataTables.min.css">';
$include_res_header .= '
<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/forms/icheck/icheck.css">';
$include_res_header .= '
<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/forms/icheck/custom.css">';
$include_res_header .= '
<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/ui/jquery-ui.min.css">';
$include_res_header .= '
<link rel="stylesheet" type="text/css" href="'.URL::base().'assets/vendors/css/forms/selects/select2.min.css">';
$include_res_header .= '';


$include_res_footer = '';
$include_res_footer .= '
<script src="'.URL::base().'assets/app-assets/vendors/js/tables/jquery.dataTables.min.js"></script>';
$include_res_footer .= '
<script src="'.URL::base().'assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>';
$include_res_footer .= '
<script src="'.URL::base().'assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>';
$include_res_footer .= '
<script src="'.URL::base().'assets/app-assets/vendors/js/tables/datatable/dataTables.rowReorder.min.js"></script>';
$include_res_footer .= '
<script src="'.URL::base().'assets/app-assets/vendors/js/charts/echarts/echarts.js"></script>';
$include_res_footer .= '
<script src="'.URL::base().'assets/app-assets/vendors/js/forms/icheck/icheck.min.js"></script>';
$include_res_footer .= "
";

ob_start();
include "index-script.php";
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
            <h3 class="content-header-title mb-0 d-inline-block">Gestion des Eleves</h3>
            <div class="row breadcrumbs-top d-inline-block">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= URL::link('accueil') ?>">Scolarité</a>
                  </li>
                  <li class="breadcrumb-item"><a href="#">Eleves</a>
                  </li>
                  <li class="breadcrumb-item"><a href="#">Inscrits</a>
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
            	<h4 class="card-title">Eleves</h4>
            	<a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
        		<div class="heading-elements">
                    <button class="btn btn-primary btn-sm"><i class="ft-plus white"></i> Enregistrer </button>
        			<span class="dropdown">
                        <button id="btnSearchDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-warning btn-sm dropdown-toggle dropdown-menu-right"><i class="ft-download white"></i></button>
                        <span aria-labelledby="btnSearchDrop1" class="dropdown-menu mt-1 dropdown-menu-right">
                            <a href="#" class="dropdown-item"><i class="fa fa-file-excel-o"></i> Excel </a>                       <a href="#" class="dropdown-item"><i class="fa fa-file-word-o"></i> Word</a>
                            <a href="#" class="dropdown-item"><i class="fa fa-file-pdf-o"></i> PDF </a>


                        </span>
                    </span>
        			<button class="btn btn-success btn-sm"><i class="ft-settings white"></i></button>
            	</div>
            </div>
            <div class="card-content">
                <div class="card-body">
	                <!-- Task List table -->
	                <div class="table-responsive">
		                <table id="class-list" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
					        <thead>
					            <tr>
					                <th style="width: 7%;">N°</th>
					                <!-- <th>Matricule</th> -->
					                <th>Informations générales</th>
					                <th>Photo</th>
					                <!-- <th>Statut</th> -->
					                <th>Actions</th>
					            </tr>
					        </thead>
					        <tbody>

                                <?php $i = 0;
                                foreach($eleves as $eleve){
                                    ?>
                                    <tr>
                                        <td style="width: 30px;"><a href="#" class="text-bold-600"><?= ++$i;?></a></td>
                                        <!-- <td><a href="#" class="text-bold-600"><?= $eleve->matricule_eleve?></a></td> -->
                                        <td>
                                            <ul class="list-inline clearfix mt-1" align="center">
                                                <li class="mr-3"><a href="#" class="text-bold-600"> <?= $eleve->nom_eleve ." ".$eleve->prenom_eleve ;?> </a></li><br>
                                                <!-- <li class="mr-3"><?= $eleve->classe_parcours ;?></li><br> -->
                                                <!-- <li class="mr-3"><?= Helpers::getYearOld($eleve->date_naissance_eleve) ." ans" ;?></li><br> -->
                                                <!-- <li class="mr-3"><?= ($eleve->sexe_eleve == 'H')? "Genre : Masculin": "Genre : Feminin";?> </li><br> -->
                                                <!-- <li class="mr-3"><span class="badge badge-info"><?= $eleve->statut_apprenant?></span> </li> -->
                                            </ul>
                                        </td>
                                        <td class="text-center">
                                            <span class="avatar avatar-busy">
                                                <img src="../ressources/uploads/img/eleve/<?= $eleve->photo_eleve ;?>" alt="avatar" data-toggle="tooltip" data-placement="right" title=" <?= $eleve->nom_eleve ." ".$eleve->prenom_eleve ;?> "><i class=""></i>
                                            </span>
                                        </td>
                                        <!-- <td><span class="badge badge-info"><?= $eleve->statut_apprenant?></span></td> -->

                                        <td>
                                            <span class="dropdown">
                                                <button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="fa fa-cog"></i></button>
                                                <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">
                                                    <a href="#<?= $eleve->classe; ?>" class="dropdown-item"  data-toggle="modal" data-target="#modal-voir"><i class="ft-eye"></i> Voir +</a>
                                                    <a href="#<?= $eleve->classe; ?>" class="dropdown-item"  data-toggle="modal" data-target="#modal-modifier"><i class="ft-edit-2"></i> Modifier</a>
                                                    <a href="#<?= $eleve->classe; ?>" class="dropdown-item"  data-toggle="modal" data-target="#modal-abonnement-cantine"><i class="ft-check"></i> Abonement Cantine</a>
                                                    <a href="#<?= $eleve->classe; ?>" class="dropdown-item"  data-toggle="modal" data-target="#modal-abonnement-club"><i class="ft-upload"></i> Abonement Club</a>
                                                    <a href="#<?= $eleve->classe; ?>" class="dropdown-item"  data-toggle="modal" data-target="#modal-supprimer"><i class="ft-trash"></i> Supprimer</a>
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                <?php } ?>


					        </tbody>
					        <tfoot>
					            <tr>
                                    <th style="width: 7%;">N°</th>
					                <!-- <th>Matricule</th> -->
					                <th>Informations générales</th>
					                <th>Photo</th>
					                <!-- <th>Statut</th> -->
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
          <div class="sidebar"><div class="bug-list-sidebar-content">
    <!-- Predefined Views -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Liste des Classes</h4>
            <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-plus"></i></a></li>

                </ul>
            </div>
        </div>
        <!-- bug-list search -->
        <div class="card-content">
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
            <div class="card-body ">
                <div class="list-group">
                    <a href="<?= URL::link('eleve-list-all')?>" class="list-group-item active">Voir tout</a>
                   <?php
                    foreach($classes as $classe){
                        ?>
                     <a href="<?= URL::link('eleve-list-class')?><?= $classe['id']?>" class="list-group-item "><?= $classe['value']; ?></a>
                   <?php } ?>
                </div>
            </div>
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

