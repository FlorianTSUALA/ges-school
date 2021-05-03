<?php

use Core\Routing\URL;
use App\Helpers\Helpers;
use App\Controller\PrinterController;

?>



<script>

/*
data_facture['classe_id']
data_facture['classe']
data_facture['data_items']
data_facture['date_debut']
data_facture['date_fin']
data_facture['date_paiement']
data_facture['date_versement']
data_facture['description']
data_facture['eleve_id']
data_facture['eleve']
data_facture['html_body']
data_facture['long_date_facture']
data_facture['mode_paiement']
data_facture['montant_paye']
data_facture['montant_total']
data_facture['montant_total']
data_facture['nom_complet']
data_facture['prix']
data_facture['quantite']
data_facture['reduction']
data_facture['reference']
data_facture['somme']
data_facture['total_day']

*/


    function sauvegarderVersement(){
        
        data = {
                'data_facture': data_facture,
                'cantines': items,
                'eleve_id':  data_facture['eleve_id'],
                'classe_id':  data_facture['classe_id'],
                'nom_eleve':  data_facture['nom_complet'],
                // 'annee_scolaire_id':  $('#annee_scolaire option:selected').val(),
                'type_paiement_id':  data_facture['type_paiement'],
                // 'motif':  $('#motif').val(),
                // 'reste':  $('#reste').val(),
                // 'autre':  $('#autres').val(),
                'reduction':  data_facture['reduction'],
                'reference': data_facture['reference'],
                'montant_total': data_facture['montant_total'],
                'date_paiement':  (data_facture['date_paiement']),
                'date_debut':   toSQLDateTime(data_facture['date_debut']),
                'date_fin':  toSQLDateTime(data_facture['date_fin']),
        };

        console.log(data);
        $.blockUI({
            // message: '<div class="ft-refresh-cw icon-spin font-medium-2">Enregsitrement en cours</div>',
            message: '<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Chargement ...</div>',
            fadeIn: 1000,
            timeout: 2000, //unblock after 2 seconds
            overlayCSS: {
                backgroundColor: '#FFF',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: '10px 15px',
                color: '#fff',
                width: 'auto',
                left: '45%',
                backgroundColor: '#333'
            },
            onBlock: function() {
                $.ajax({
                    url: '<?= URL::link('enregistrement_cantine');?>'+$('#eleve_nom_complet option:selected').val(),
                    type: 'post',
                    data: data,
                    dataType: 'json',
                    beforeSend:function(){
                        // $('#btn_save').hide()
                        // $('#btn_back').hide()
                        $(loading).show()
                    },
                    success:function(data){
                        $('#btn_save').hide()
                        $('#btn_back').hide()

                        $('#btn_home').show()
                        $('#btn_print').show()

                        $(loading).hide()
                        // message de notification
                        flash_msg(data)

                        console.log(data)

                    },
                    error: function (textStatus, errorThrown) {
                        $('#btn_save').show()
                        $('#btn_back').show()
                        Success = false
                        console.log(textStatus, errorThrown)
                    }
                });
            }
        });
        
    }


    function imprimerRecuVersement(){
 
        gotoUrl('<?= URL::link('facture_cantine');?>'+$('#eleve_nom_complet option:selected').val(), data_facture);
        console.log(data_facture);

        /*$.ajax({
            url: '<?= URL::link('facture_cantine');?>'+$('#eleve_nom_complet option:selected').val(),
            type: 'post',
            data: data_facture,
            dataType: 'json',
            beforeSend:function(){
                // $('#btn_save').hide()
                // $('#btn_back').hide()
                $(loading).show()
            },
            success:function(data){
                //$('#btn_save').hide()
                // $('#btn_home').show()
                //$('#btn_back').hide()
                // $('#btn_print').show()
                // $(loading).hide()
                // location.href='<?= URL::link('print').PrinterController::SCOLARITE?>';
               console.log(data)

            },
            error: function (textStatus, errorThrown) {
                // $('#btn_save').show()
                // $('#btn_back').show()
                Success = false
                console.log(textStatus, errorThrown)
            }
        });*/

    }

</script>