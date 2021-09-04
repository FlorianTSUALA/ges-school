<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

?>

<!-- Modal -->
<div class="modal  animated zoomIn  text-left" id="eleve_modal_activite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #f5a663;">
                <h4 class="modal-title" id="myModalLabel17">Informations relatives aux activités de l'élève</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card-body">

            
                    <span id="recap-id" style="display: none;"></span>

                    <div class="col-12">
                        <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                            <div class="card collapse-icon panel mb-0 box-shadow-0 border-0">
                                <!-- ETAPE 01 -->
                                <div id="heading-etape-01" role="tab" class="card-header border-bottom-black border-bottom-warning">
                                <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion-etape-01"  aria-controls="accordion-etape-01" class="text-uppercase black collapsed"><strong id ="nom_complet_activite"></strong></a>
                             </div>

                                <div class="content-detached content-left">
                                        <div class="content-body">
                                            <section class="row">
                                            
                                                    <div class="card">              
                                                    <div class="card-content my-0 py-0">
                                                        <div class="card-body">
                                                            <div class="table-responsive-sm">
                                                                <table id="table-eleve_activite" class="table table-white-space table-bordered  table-sm" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <!-- <th>id</th> -->
                                                                            <th>N°</th>
                                                                            <th>Actiivité</th>
                                                                            <th>Période</th>
                                                                            <th>Date de versement</th>
                                                                            <th>Montant</th>
                                                                            <th>Actions</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                    
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                        
                                            </section>
                                        </div>

                                    </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fermer</button>
                        <button type="button" onclick="redirectTo()" class="btn btn-outline-secondary">Modifier</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>