<?php

use App\App;
use App\Helpers\S;
use Core\Routing\URL;
use App\Helpers\HTMLHelper;
use Core\HTML\Form\FormModel;

ob_start();
echo '<script src="' . URL::base() . 'assets/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>';
echo '<script src="' . URL::base() . 'assets/app-assets/js/scripts/tables/datatables-extensions/datatables-sources.js"></script>';
echo '<script src="' . URL::base() . 'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>';
include dirname(dirname(__DIR__)) . "/_common/_crud_modal_script.php";
include dirname(dirname(__DIR__)) . "/_common/_datatable_script.php";
$include_footer_script = ob_get_clean();
?>

<!-- 
    ******  VARIABLES *****
     $title;
     $create_title;
     $fillables
-->

<div class="app-content content ">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12">
				<h3 class="content-header-title">Groupe Familial </h3>
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"> <a href="<?= URL::link('accueil') ?>">Accueil</a></li>
							<li class="breadcrumb-item"> <a href="<?= URL::link('liste_eleve') ?>">Scolarité</a></li>
							<li class="breadcrumb-item active"><a href="#">Groupes familiaux</a> </li>
						</ol>
					</div>
				</div>
			</div>
			<div class="content-header-right col-md-6 col-12">
				<div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
					<div class="btn-group" role="group"><a class="btn btn-outline-info" href="<?= URL::link('groupe_familial') ?>">
							<i class="fa fa-user-plus"> Groupes Familiaux</i></a>
					</div>
					<div class="btn-group" role="group"><a class="btn btn-outline-info <?= ($menu_actif??"" == "liste_inscrit") ? "active" : "" ?>" href="<?= URL::link('groupe_familial') ?>" data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="élèves inscrits au compte de l'année scolaire <?= $this->session->get(S::ANNEE_SCOLAIRE_LIBELLE) ?>" data-bg-color="pink">
							<i class="fa fa-user"> Historique de reductions familiaux</i>
						</a>
					</div>
				</div>
			</div>

			<div class="content-header-lead col-12 mt-2">
				<p class="lead"></p>
			</div>
		</div>

		<div class="content-body">
			<section class="row">
				<div class="col-sm-12">
					<div id="kick-start" class="border-2 border-warning card box-shadow-2">
						<div class="card-header border-bottom-2 border-bottom-warning card-header-inverse ">
							<h4 class="card-title"><?= $title; ?></h4>
							<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
							<div class="heading-elements">
								<button type="button" class="btn btn-sm btn-warning btn-darken" data-toggle="modal" data-target="#modal-create"><?= $create_title; ?></button>
							</div>
						</div>

						<div class="card-content collapse show">
							<div class="card-body">
								<div class="table-responsive-sm">
									<table id="datatable" class="table table-bordered table-striped table-hover table-sm">
										<thead>
											<?= HTMLHelper::genHeaderTable($this->fill(FormModel::LABEL, $fillables)); ?>
										</thead>

										<tbody id="data-table">
											<?= HTMLHelper::genBodyTable($items, $class_name, $this->fill(['label', 'name', 'type', FormModel::EXTERNAL_TYPE], $fillables)); ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="card-footer border-top-2 border-top-warning">
							<span><? App::ORGANISATION; ?></span>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<?php require "modal/create.php" ?>
<?php require "modal/update.php" ?>
<?php require "modal/read.php" ?>
<?php require "modal/delete.php" ?>