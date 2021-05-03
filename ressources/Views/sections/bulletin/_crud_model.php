<?php

use Core\Routing\URL;
use App\Helpers\HTMLHelper;
use Core\HTML\Form\FormModel;

	ob_start();
	echo '<script src="'.URL::base().'assets/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>';
	echo '<script src="'.URL::base().'assets/app-assets/js/scripts/tables/datatables-extensions/datatables-sources.js"></script>';
	echo '<script src="'.URL::base().'assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>';
	include dirname(__DIR__)."/_common/_crud_modal_script.php";
	include dirname(__DIR__)."/_common/_datatable_script.php";
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

		<div class="content-body">
			<section class="row">
				<div class="col-sm-12">
					<div id="kick-start" class="border-2 border-warning card box-shadow-2">
						<div class="card-header border-bottom-2 border-bottom-warning card-header-inverse ">
							<h4 class="card-title"><?= $title; ?></h4>
							<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
							<div class="heading-elements">
								<button type="button" class="btn btn-sm btn-warning btn-darken" data-toggle="modal"
									data-target="#modal-create"><?= $create_title; ?></button>
							</div>
						</div>
						<div class="card-content">
							
							<div class="card-content collapse show">
							<div class="card-body">

							<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label for="prenom_eleve" class="col-3 col-form-label"><strong>
													<h5>salle de classe :</h5>
												</strong></label>
											<div class="col-9">
												<span
													class="select2 select2-container select2-container--default select2-container--below select2-container--focus"
													dir="ltr" data-select2-id="27" style="width: 227.708px;"><span
														class="selection"><span
															class="select2-selection select2-selection--single"
															role="combobox" aria-haspopup="true" aria-expanded="false"
															tabindex="0"
															aria-labelledby="select2-classe-container"><span
																class="select2-selection__rendered"
																id="select2-classe-container" role="textbox"
																aria-readonly="true" title="Petite-section">
															</span><span class="select2-selection__arrow"
																role="presentation"><b
																	role="presentation"></b></span></span></span><span
														class="dropdown-wrapper" aria-hidden="true"></span></span>

											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label for="nom_eleve" class="col-3 col-form-label"><strong>
													<h5>Enseignant :</h5>
												</strong></label>
											<div class="col-9">
												<input placeholder="Nom de l'élève" type="text"
													class="form-control required" id="nom_eleve" name="nom_eleve"
													autofocus="" required="required">
											</div>
										</div>
									</div>

							 </div>
							 <hr class="border-warning">

								<div class="table-responsive">
									<table id="datatable" class="table table-bordered table-striped table-hover">
										<thead>
											<?= HTMLHelper::genHeaderTable( $this->fill(FormModel::LABEL, $fillables) ); ?>
										</thead>

										<tbody id="data-table">
											<?= HTMLHelper::genBodyTable($items, $class_name, $this->fill(['label','name', 'type', FormModel::EXTERNAL_TYPE], $fillables)); ?>
										</tbody>
									</table>
								</div>
					</div>
				</div>
			</div>
						

						<div class="card-footer border-top-2 border-top-warning">
							<span>
								<? App::SCHOOLL_NAME; ?></span>
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
