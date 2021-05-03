<?php ?>
<!-- 
    ******  VARIABLES *****
     $view_title;
-->


<div class="modal animated fadeInDownBig text-left" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel40" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel40"> <?= $view_title; ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form  class="needs-validation" id="view-form" method="POST"  action="" novalidate>
				<div id="modal-view-body" class="modal-body">
                </div>
                <div class="modal-footer">
					<input type="reset" class="btn btn-danger" data-dismiss="modal" value="Fermer">
				</div>
			</form>
		</div>
	</div>
</div>
