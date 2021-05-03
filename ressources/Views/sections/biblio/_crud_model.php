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
								<button type="button" class="btn btn-sm btn-warning btn-darken" data-toggle="modal" data-target="#modal-create"><?= $create_title; ?></button>
							</div>
						</div>

						<div class="card-content collapse show">
							<div class="card-body">
								<div class="table-responsive">
									<table  id="datatable" class="table table-bordered table-striped table-hover">
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

						<div class="card-footer border-top-2 border-top-warning">
							<span><? App::SCHOOLL_NAME; ?></span>
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
