<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

?>

<script>
    var reference = "<?= Helpers::generateReference(); ?>";
    var date_facture = "<?= Helpers::getFullDate(date("Y-m-d H:i:s")); ?>";

    function sauvegarderVersement(){
        console.log(items);
        data = {

                "pension_classe": items, 
                "eleve_id":  $('#eleve_nom_complet option:selected').val(),
                "classe_id":  $('#classe option:selected').val(),
                "statut_apprenant_id":  $('#statut_apprenant option:selected').val(),
                "annee_scolaire_id":  $('#annee_scolaire option:selected').val(),
                "type_paiement_id":  $('#type_paiement option:selected').val(),
                "motif":  $('#motif').val(),
                "reste":  $('#reste').val(),
                "autres":  $('#autres').val(),
                "reduction":  $('#reduction').val(),
                "reference": reference,
                "date_paiement":  $( "#date_paiement" ).text(),
                "date_facture":  date_facture,
         };

        $.ajax({
            url: '<?= URL::link('versement-create');?>'+$('#eleve_nom_complet option:selected').val(),
            type: 'post',
            data: data,
            dataType: 'json',
            beforeSend:function(){
                // $("#btn_save").hide();  
                // $("#btn_back").hide();
                $(loading).show();
            },
            success:function(data){ 
                $("#btn_save").hide();  
                $("#btn_home").show();  
                $("#btn_back").hide();
                $("#btn_print").show();
                $(loading).hide();

               console.log(data);

            },
            error: function (textStatus, errorThrown) {
                Success = false;
                console.log(textStatus, errorThrown);
            }
        });


    }

</script>