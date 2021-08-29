<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

?>

<!-- Modal -->
<div class="modal  animated zoomIn  text-left" id="eleve_modal_scolarite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17"></h4>
                
                <h4 class="modal-title" id="myModalLabel17" style="text-align:center">Informations relatives à la scolarité de l'élève</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="card-body">

                            <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                                <div >
                                    <!-- ETAPE 01 -->
                                    <div id="heading-etape-01" role="tab" class="card-header border-bottom-blue border-bottom-warning">
                                        <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion-etape-01"  aria-controls="accordion-etape-01" class="text-uppercase blue collapsed"><strong>Nom de l'élève concerné</strong></a>
                                    </div>

                                    <div class="content-detached content-left">
                                        <div class="content-body">
                                            <section class="row">
                                            
                                                    <div class="card">              
                                                    <div class="card-content my-0 py-0">
                                                        <div class="card-body">
                                                            <div class="table-responsive-sm">
                                                                <table id="table-eleve_scolarite" class="table table-white-space table-bordered  table-sm" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <!-- <th>id</th> -->
                                                                            <th>N°</th>
                                                                            <th>Tranches</th>
                                                                            <th>Date de versament</th>
                                                                            <th>Montant</th>
                                                                            <th>Montant1</th>
                                                                            <th>Actions</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <!-- <tr>
                                                                           <th>id</th> 
                                                                            <td>1</td>
                                                                            <td>premiere tranche</td>
                                                                            <td>23 fevrier 2014</td>
                                                                            <td>90 000</td>
                                                                            <td>Actions</td>
                                                                        </tr> -->
                                                                        
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

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fermer</button>
                    <button type="button" onclick="redirectTo()" class="btn btn-outline-secondary">Modifier</button>
                </div>
        </div>
    </div>
</div>