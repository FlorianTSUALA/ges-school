<?php

use App\Helpers\Helpers;
use App\Helpers\S;

$signataire = $this->session->get(S::PERS_NOM) . " " . $this->session->get(S::PERS_PRENOM);
$funtion_signataire = $this->session->get(S::PERS_TYPE_PERSONNEL);

?>

<script>
    var data_versement = []
    var reference = '<?= Helpers::generateReference() ?>'

    $(document).on('click', '#btn_preview', function(e)
    {
        data_versement['autres'] =  autres
        data_versement['activites'] =  scolarites

        data_versement['signataire'] = '<?=  $signataire ?>'
        data_versement['funtion_signataire'] = '<?= $funtion_signataire ?>'

        data_versement['reference'] = reference


        data_versement['date_paiement'] = $('#date_paiement').val()

        data_versement['eleve'] = $('#eleve_nom_complet option:selected').text()
        data_versement['eleve_id'] = $('#eleve_nom_complet option:selected').val()


        data_versement['annee_scolaire'] = $('#annee_scolaire option:selected').val()

        data_versement['type_paiement'] = $('#type_paiement option:selected').text()
        data_versement['type_paiement_id'] = $('#type_paiement option:selected').val()

        data_versement['classe'] = $( "#classe option:selected" ).text()
        data_versement['classe_id'] = $('#classe option:selected').val()

        data_versement['long_date_facture'] = "<?= Helpers::getFullDate(date("Y-m-d H:i:s")) ?>"

        data_versement['montant_paye'] =  $('#montant').val()

        let classe = $( "#classe option:selected" ).text()

        var body = ''
        var sous_total = 0
        var _montant_total = 0
        var i = 0
        data_versement['html_table_body'] = body

        $('#recap-body').html(data_versement['html_table_body'])
        $('#recap-reference').text(data_versement['reference'])

        //Pension Scolaire
            {

                body += '<tr>'
                body += '   <th scope="row">'+ 1 +'</th>'
                body += '       <td>'
                body += '           <p>Pension : '+scolarites['libelle']+'</p>'

                let j = 0
                let size = $(tranche).select2('data').length
                let periode = ''
                for(var _tranche of ($(tranche).select2('data')) )
                    periode += _tranche.text + ((size == ++j)? '.' : ', ')  

                body += '           <em class="text-muted">Concernant les tranches suivantes : '+periode+'.</em>'

                body += '       </td>'
                body += '       <td class="text-right">'+ scolarites['montant'] +' Fcfa</td>'
                body += '       <td class="text-right">'+ size +' tranches(s)</td>'
                body += '       <td class="text-right">'+ scolarites['montant'] +' Fcfa</td>'

                body += '</tr>'

            }
        //Pension Scolaire


        //Autres

            if(autres['montant_net'] !== 0){
                body += '<tr>'
                body += '   <th scope="row">'+ 2 +'</th>'
                body += '       <td>'
                body += '           <p>Pension : '+ autres['libelle'] +'</p>'
                body += '       </td>'
                body += '       <td class="text-right">'+ autres['montant'] +' Fcfa</td>'
                body += '       <td class="text-right">  1 </td>'
                body += '       <td class="text-right">'+  autres['montant']  +' Fcfa</td>'
                body += '</tr>'
            }
        //Autres

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


        data_versement['reduction'] =  parseFloat(autres['reduction']) +  parseFloat(scolarites['reduction'])
        data_versement['sous_total'] = parseFloat(autres['montant']) +  parseFloat(scolarites['montant'])
        data_versement['montant_paye'] = data_versement['sous_total'] - data_versement['reduction']

        $('#recap-total-top').text(  parseInt( data_versement['montant_paye'] ) )
        $('#recap-total-bottom').text( data_versement['montant_paye'] )
        $('#recap-reduction').text( data_versement['reduction'] )
        $('#recap-sous_total').text(   data_versement['sous_total'])

        $('#recap-signataire').text( data_versement['signataire'] )
        $('#recap-funtion_signataire').text(  data_versement['funtion_signataire'] )

        $('#section_versement').hide()
        $('#section_recapitulatif').show()
    }

    );

</script>
