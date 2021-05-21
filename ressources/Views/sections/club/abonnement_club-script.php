<?php

    use App\Helpers\Helpers;

    $signataire = 'Charbonnier LaRose';
    $funtion_signataire = 'Le Sécrétariat';

?>


<script>
var btn_save = $('#btn-abonnement_club_save')



    $(document).ready(function(){
        
        console.log("Nous y sommes")
        // $(btn_home).hide()
        // $(btn_print).hide()

        // $(btn_preview).click(function() {
        //     update_etat()
        //     reduction = $('#reduction').val()
        //     type_paiement = $('#type_paiement').val()
        //     eleve_nom_complet = $('#eleve_nom_complet').val()
        //     classe = $('#classe').val()
        //     montant_total = $('#montant_total').val()
        //     date_versement = $('#date_versement').val()
        //     $(section_versement).hide()
        //     $(section_recaputilatif).show()
            
        // })

        // $(btn_back).click(function() {
        //     $(section_recaputilatif).hide()
        //     $(section_versement).show()
        // })

        $(btn_save).click(function() {
            // console.log("Gloire à Jesus")
            sauvegarderVersement()
            //check file : script-save.js
        })

        // $(btn_print).click(function() {
        //     imprimerRecuVersement()
        // })

    })


</script>