<?php

use App\Helpers\S;
use App\Helpers\Helpers;
use App\Model\Technique\E;

$signataire = $this->session->get(S::PERS_NOM) . " " . $this->session->get(S::PERS_PRENOM);
$funtion_signataire = $this->session->get(S::PERS_TYPE_PERSONNEL);


?>

<script>

    var reference = '<?= Helpers::generateReference() ?>'

    $(document).on('click', '#btn_preview', function(e)
    {

        data_versement['pension_classe'] =  items
        data_versement['cantines'] =  cantines
        data_versement['autres'] =  autres
        data_versement['activites'] =  activites

        data_versement['signataire'] = '<?=  $signataire ?>'
        data_versement['funtion_signataire'] = '<?= $funtion_signataire ?>'

        data_versement['reference'] = reference

        data_versement['pension_classe'] = items
        data_versement['cantines'] = cantines
        data_versement['autres'] = autres
        data_versement['activites'] = activites

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
        data_versement['fonction_gestionnaire'] =  "<?= $this->session->get(S::PERS_TYPE_PERSONNEL) ?>"
        data_versement['gestionnaire'] =  "<?= $this->session->get(S::PERS_NOM) . " " . $this->session->get(S::PERS_PRENOM) ?>"

        let classe = $( "#classe option:selected" ).text()

        var body = ''
        var sous_total = 0
        var _montant_total = 0
        var i = 0
        data_versement['html_table_body'] = body

        $('#recap-body').html(data_versement['html_table_body'])
        $('#recap-reference').text(data_versement['reference'])

        //Pension Scolaire
            for(var item in items)
            {
                
                let current = items[''+item]

                let _type_pension_code = item

                let _montant =  parseFloat(current['montant'])

                let tmp_montant_txt = ''
                let tmp_multiplicateur_txt = ''
                if(current['montant_net'] == 0) continue

                body += '<tr>'
                body += '   <th scope="row">'+ (++i) +'</th>'
                body += '       <td>'
                body += '           <p>Pension : '+current['type_pension']+'</p>'

                if(current['paiement_en_tranche'] === '<?= E::OUI ?>' ){
                        let periode  = ' '
                        var size = current['tranche'].length

                        let j = 0
                        for (var tranche of current['tranche']) {
                            if (j == size - 1) {
                                periode += tranche['value'] + '. '
                                tmp_montant_txt += tranche['montant']
                            } else {
                                periode += tranche['value'] + ', '
                                tmp_montant_txt += tranche['montant'] + ' + '
                            }
                        }

                        body += '           <em class="text-muted">Concernant les tranches suivantes : '+periode+'.</em>'
                        tmp_multiplicateur_txt = current['multiplicateur'] + ' tranche(s)'

                }else{
                    tmp_montant_txt = current['montant_brut'] + ' * ' + current['multiplicateur']
                    tmp_multiplicateur_txt = current['multiplicateur']
                }

                body += '       </td>'
                body += '       <td class="text-right">'+ tmp_montant_txt +' Fcfa</td>'
                body += '       <td class="text-right">'+ tmp_multiplicateur_txt +'</td>'
                body += '       <td class="text-right">'+ current['montant_brut'] +' Fcfa</td>'

                body += '</tr>'
                
                _montant_total += current['montant_brut']

            }
        //Pension Scolaire

        //Cantines
            current = cantines
            if(current['multiplicateur'] > 0){
                
                body += '<tr>'
                body += '   <th scope="row">'+(++i)+'</th>'
                body += '       <td>'
                body += '           <p>Pension : Cantine </p>'

                tmp_montant_txt = '(' + prix_abonnement_cantine + ')*' + current['multiplicateur']

                let j = 0
                let periode = ''
                for(var tranche of current['tranche'])
                    periode += (tranche['value'] + ((size = ++j)? '.' : ', '))

                body += '           <em class="text-muted">Concernant les tranches suivantes : '+periode+'.</em>'

                body += '       </td>'
                body += '       <td class="text-right">'+  tmp_montant_txt  +' Fcfa</td>'
                body += '       <td class="text-right">'+  current['multiplicateur']  +'</td>'
                body += '       <td class="text-right">'+ (current['multiplicateur'] * current['montant_brut']) +' Fcfa</td>'

                body += '</tr>'

                _montant_total += current['montant_brut']

            }
        //Cantines

        //Activite
            current = activites
            if(current['montant_net'] > 0 ){
                body += '<tr>'
                body += '   <th scope="row">' + (++i) + '</th>'
                body += '       <td>'


                let tmp_montant_txt = ''
                let msg = ''
                for (let j=0; j<current['liste'].length; j++) {

                    if (j == current['liste'].length - 1) {
                        msg += current['liste'][j]['value'] + '. '
                        tmp_montant_txt += current['liste'][j]['montant']
                    } else {
                        msg += current['liste'][j]['value'] + ', '
                        tmp_montant_txt += current['liste'][j]['montant'] + ' + '
                    }
                }

                tmp_montant_txt = '(' + tmp_montant_txt + ')*' + current['multiplicateur']

                body += '           <p>Pension des activités : ' + msg + '</p>'

                let j = 0
                let periode = ''
                for (var tranche of current['tranche'])
                    periode += (tranche['value'] + ((size = ++j)? '.' : ', '))


                body += '           <em class="text-muted">Concernant les tranches suivantes : '+periode+'.</em>'
                body += '       </td>'
                body += '       <td class="text-right">'+ tmp_montant_txt  +' Fcfa</td>'
                body += '       <td class="text-right">'+ current['multiplicateur'] +'</td>'

                body += '       <td class="text-right">'+ current['montant_net'] +' Fcfa</td>'
                body += '</tr>'

                _montant_total += current['montant_brut']

            }
        //Activite

        //Autres
            current = autres

            if(current['montant_net'] > 0){
                _montant_total += current['montant_brut']
                body += '<tr>'
                body += '   <th scope="row">'+(++i)+'</th>'
                body += '       <td>'
                body += '           <p>Pension : '+ current['type_pension']+'</p>'
                body += '       </td>'
                body += '       <td class="text-right">'+ current['montant_brut']  +' Fcfa</td>'
                body += '       <td class="text-right">  1 </td>'
                body += '       <td class="text-right">'+ current['montant_brut'] +' Fcfa</td>'
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

        reduction = 0;//(isNaN($('#RF-reduction').val()) || !$('#RF-reduction').val()) ? 0 : $('#RF-reduction').val()


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
