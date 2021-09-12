<?php

use Core\HTML\Form\FormModel;

?>

<!--
    ******  VARIABLES *****
     $update_title;
     $fillables;
-->

<div class="modal animated fadeInDownBig text-left" id="modal-update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel41" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel41"><?= $update_title; ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form  class="needs-validation" id="update-form" method="POST"  action="" novalidate>
				<div class="modal-body">
					<div id="notification-update" style="display:none" class="alert alert-icon-right alert-info alert-dismissible mb-2" role="alert">
						<span class="alert-icon"><i class="fa fa-info"></i></span>
						<button type="button" class="close" data-dismiss="alert" >
						<!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"> -->
							<span aria-hidden="true">×</span>
						</button>
						<strong id="notification_msg-update"> Message de notification.</strong>
					</div>
				<?php
						foreach($fillables as $key => $fillable){
							$internal =  $fillable->{FormModel::INTERNAL};
							$fieldType =  $fillable->{FormModel::FIELDTYPE};
							$name =  $fillable->{FormModel::NAME};
							$id =  $fillable->{FormModel::ID};
							$label = $fillable->{FormModel::LABEL};
							$placeholder = $fillable->{FormModel::PLACEHOLDER};
							$required = $fillable->{FormModel::REQUIRED};
							$type = $fillable->{FormModel::TYPE};
							$data = $fillable->{FormModel::DATA};
							$class_css = $fillable->{FormModel::CLASS_CSS};
							$icon = $fillable->{FormModel::ICON};
							$warning_msg = $fillable->{FormModel::WARNING_MSG};


							$field = $this->field->{$fieldType}($id, $name, $label,
								[
									'type'=> $type, 'data'=>$data, 'class' =>$class_css, 'placeholder' =>$placeholder,
									'required' => $required ,'hasSubClass' => false
								], 'upd-');

							if($required)
									$field = $field->controlValidation($warning_msg);

							$class_ico_pos = '';
							if($icon !== ''){
								$field = $field->withIcon($icon.' font-medium-5 line-height-1 text-muted icon-align');
								$class_css = 'position-relative has-icon-left';
							}

							end($fillables);//reset for fist element or array_key_first
							if ($key === key($fillables)){
								$field = $field->InFormGroup($class_ico_pos, 'margin-bottom: 0rem;');
							}else{
								$field = $field->InFormGroup($class_ico_pos);
							}
							$field->show();
						}

					?>
				</div>
				<div id="upt-loading" class="spinner-grow text-warning" role="status"> <span class="sr-only">Loading...</span></div>
				<div class="modal-footer" id="button-form-update">
					<input type="reset" class="btn btn-danger" data-dismiss="modal" value="Annuler">
					<input type="submit"  id="button-update"  class="btn btn-warning btn-darken-2" value="Sauvegarder">
				</div>
				<input type="hidden" name="code" id="upd-code" />
			</form>
		</div>
	</div>
</div>
