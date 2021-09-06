<?php

use App\Helpers\S;
use App\Helpers\Helpers;
use App\Model\TypePension;

$signataire = $this->session->get(S::PERS_NOM) . " " . $this->session->get(S::PERS_PRENOM);
$funtion_signataire = $this->session->get(S::PERS_TYPE_PERSONNEL);

?>

<script>
    var data_versement = [] 
    var reference = '<?= Helpers::generateReference() ?>'

    $(document).on('click', '#btn_preview', function(e)
    {

        data_versement['signataire'] = '<?=  $signataire ?>'
        data_versement['funtion_signataire'] = '<?= $funtion_signataire ?>'

        data_versement['reference'] = reference

        data_versement['date_paiement'] = $('#date_paiement').val()

        data_versement['eleve'] = $('#eleve_nom_complet option:selected').text()
        data_versement['eleve_id'] = $('#eleve_nom_complet option:selected').val()

        data_versement['autres'] = $('#autres').text()

        data_versement['statut_apprenant'] = $('#statut_apprenant option:selected').val()
        data_versement['annee_scolaire'] = $('#annee_scolaire option:selected').val()

        data_versement['type_paiement'] = $('#type_paiement option:selected').text()
        data_versement['type_paiement_id'] = $('#type_paiement option:selected').val()

        data_versement['classe'] = $( "#classe option:selected" ).text()
        data_versement['classe_id'] = $('#classe option:selected').val()

        data_versement['long_date_facture'] = "<?= Helpers::getFullDate(date("Y-m-d H:i:s")) ?>"

        data_versement['montant_paye'] =  $('#montant').val()
        data_versement['pension_classe_id'] =  $("#classe").select2().find(':selected').data('pension_classe_id')
        data_versement['motif'] =  "Frais d'inscription"

        let classe = $( "#classe option:selected" ).text()

        //Pension Inscription
            var body = ''
            data_versement['html_table_body'] = body
            $('#recap-body').html(data_versement['html_table_body'])
            $('#recap-reference').text(data_versement['reference'])
            {
                let i = 0
                let current = []
                current['motif'] = data_versement['motif']
                current['montant'] = data_versement['montant_paye'] 
                current['quantite'] = "Année scolaire <?= $this->session->get(S::ANNEE_SCOLAIRE_LIBELLE); ?>"
                current['montant_total'] = data_versement['montant_paye']

                _montant_total = data_versement['montant_paye']

                body += '<tr>'
                body += '   <th scope="row">'+ (++i) +'</th>'
                body += '       <td>'
                body += '           <p>Pension : '+ current['motif'] + '</p>'
                body += '       </td>'
                body += '       <td class="text-right">'+ current['montant'] + ' Fcfa</td>'
                body += '       <td class="text-right">'+ current['quantite'] + '</td>'
                body += '       <td class="text-right">'+ current['montant_total'] + ' Fcfa</td>'
                body += '</tr>'
            }
        //Pension Inscription


        data_versement['html_table_body'] = body

        $('#recap-body').html(data_versement['html_table_body'])

        $('#recap-nom').text( data_versement['eleve'] )
        $('#recap-classe').text( data_versement['classe'] )
        $('#recap-date').text( data_versement['long_date_facture'] )
        $('#recap-description').text( data_versement['motif'] )
        $('#recap-prix').text( data_versement['montant_paye'] )
        $('#recap-quantite').text( data_versement['quantite'] )
        $('#recap-mode_paiement').text( data_versement['type_paiement'] )

        //NON PRIS EN COMPTE
        $('#recap-banque').hide()
        $('#recap-cheque').hide()
        $('#recap-nom_banque').hide()
        $('#recap-numero_cheque').hide()

        reduction = 0

        $('.reduction').each(function()
        {
            reduction += (isNaN(parseFloat($(this).val())))? 0 : parseFloat($(this).val())
        })


        data_versement['reduction'] = reduction
        data_versement['sous_total'] = data_versement['montant_paye'] -  data_versement['reduction']


        $('#recap-total-top').text(   data_versement['montant_paye'] )
        $('#recap-total-bottom').text( data_versement['montant_paye'] )
        $('#recap-reduction').text( data_versement['reduction'] )
        $('#recap-sous_total').text( parseInt( data_versement['montant_paye'] ) -  data_versement['reduction'] )

        $('#recap-signataire').text( data_versement['signataire'] )
        $('#recap-funtion_signataire').text(  data_versement['funtion_signataire'] )

        $('#section_versement').hide()
        $('#section_recapitulatif').show()
    }

    );

</script>
