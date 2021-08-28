<?php

use Core\HTML\Form\FormModel;

?>

<!-- 
    ******  VARIABLES *****
     $create_title;
     $fillables
-->


<div class="modal animated fadeInDownBig text-left" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel40" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel40"> <?= $create_title; ?> </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form  class="needs-validation" id="create-form" method="POST"  action="" novalidate>
				<div class="modal-body">
				<?php
						foreach($fillables as $key => $fillable){
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
								]);
							
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
				<div id="loading" class="spinner-grow text-warning" role="status"> <span class="sr-only">Loading...</span></div>
				<div class="modal-footer" id="button-form-create">
					<input type="reset" class="btn btn-danger" data-dismiss="modal" value="Annuler">
					<input type="submit"  id="button-create"  class="btn btn-warning " value="Sauvegarder">
				</div>
			</form>
		</div>
	</div>
</div>
