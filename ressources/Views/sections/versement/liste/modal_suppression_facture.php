<?php

use App\App;

    use Core\Routing\URL;

?>

<div class="modal fade" id="suppression_facture" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #f5a663;">
                <h5 class="modal-title" id="exampleModalLongTitle">Suppression d'un versement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <center> Voulez vous vraiment annuler la prise enc compte de ce versement ?</center>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="delete-eleve_id" value="">
                <a href="#" onclick="delete_facture()"  class="btn btn-danger">oui</a>
                <button type="button" class="btn btn-success" data-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>