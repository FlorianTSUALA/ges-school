<?php ?>
<!-- 
    ******  VARIABLES *****

    $delete_title;
    $msg_delete;
    
-->


-->

<div class="modal animated fadeInDownBig text-left" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel40" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel40">  <?= $delete_title; ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

            <div id="modal-delete-body" class="modal-body">
                <h4> <?= $msg_delete; ?> </h4>
            </div>

            <div id="del-loading" class="spinner-grow text-warning" role="status"> <span class="sr-only">Loading...</span></div>
            <div class="modal-footer" id="button-form-delete">
                <input type="reset" class="btn btn-danger" data-dismiss="modal" value="Non">
                <input type="submit"  id="button-delete"  class="btn btn-warning btn-darken-2" value="Oui">
            </div>
    
        </div>
	</div>
</div>