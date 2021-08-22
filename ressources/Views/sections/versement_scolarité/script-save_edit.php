<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

echo '<script src="'.URL::base().'assets/app-assets/vendors/js/jquery-print/jQuery.print.js"></script>';
?>

<script>
// depoter ces variables dans le controller


    function sauvegarderVersement(){
        // console.log(cantines);
        // console.log(activites);
        // console.log(autres);
        
        data = {

                'pension_classe': items,
                'cantines': cantines,
                'autres': autres,
                'activites': activites,
                'eleve_id':  data_versement['eleve_id'],
                'classe_id':  data_versement['classe_id'],
                'statut_apprenant_id':  data_versement['statut_apprenant'],
                'annee_scolaire_id':  data_versement['annee_scolaire'],
                'type_paiement_id':  data_versement['type_paiement_id'],
                'motif':  data_versement['motif'],
                // "reste":  $('#reste').val(),
                'autre':  data_versement['autres'],
                'montant_paye':  data_versement['montant_paye'],
                'sous_total':  data_versement['sous_total'],
                'reduction':  data_versement['reduction'],
                'nom_eleve':  data_versement['eleve_nom_complet'],
                'reference':  data_versement['reference'],
                'date_paiement':  data_versement['date_paiement'],
         };


        $.blockUI({
            message: '<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Enregistrement en cours ...</div>',
            fadeIn: 1000,
            timeout: 10000, //unblock after 2 seconds
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
                    url: '<?= URL::link('versement-create');?>'+$('#eleve_nom_complet option:selected').val(),
                    type: 'post',
                    data: data,
                    dataType: 'json',
                    beforeSend:function(){
                        $(loading).show();
                    },
                    success:function(data){
                        $('#btn_save').hide()
                        $('#btn_back').hide()

                        $('#btn_home').show()
                        $('#btn_print').show()

                        $(loading).hide()
                        // message de notification

                        flash_msg(data)

                        console.log('Ici ya erreu demandé', data)
                        const printB = document.getElementById("invoice-items-details")
                        $("invoice-items-details").printArea([]);
                    },
                    error: function (textStatus, errorThrown) {
                        
                        const printB = document.getElementById("invoice-items-details")
                        $("invoice-items-details").printArea([]);
                        console.log('Ici ya erreu demandé 1', data)
                        Success = false;
                        console.log(textStatus, errorThrown);
                    }
                });               
            }
        });

    }


    function imprimerRecuVersement(){
        gotoUrl('<?= URL::link('versement_facture');?>'+$('#eleve_nom_complet option:selected').val(), data_versement);
        console.log(data_versement);
    }

</script>