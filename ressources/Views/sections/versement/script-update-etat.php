<?php

use App\Helpers\Helpers;

$signataire = "Charbonnier LaRose";
$funtion_signataire = "Le Sécrétariat";

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

        data_versement['reference'] = $('#reference').val()

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
                ++i
                let current = items[item]

                let _type_pension_code = current['type_pension_code']
            
                let  _est_mensuel    = parseInt(current['est_mensuel'])
                let _montant =  parseFloat(current['montant'])
                let _mensualite = parseFloat(current['mensualite'])

                let  msg = ''
                let  sub_total = 0
                let  tmp_montant = 0

                var _recapitulatif = parseFloat(current['recapitulatif'])
                _recapitulatif = (isNaN(_recapitulatif))? 0 : _recapitulatif
                if(_recapitulatif == 0) continue

                body += '<tr>'
                body += '   <th scope="row">'+i+'</th>'
                body += '       <td>'
                body += '           <p>Pension : '+current['type_pension']+'</p>'

                if(_est_mensuel === 1){

                        tmp_montant = _mensualite

                        let subdody = ''
                        let periode  = ' '
                        var size = current['multiplicateur'].length
                        let j = 0

                        for(var tranche in current['multiplicateur'])
                            periode += (current['multiplicateur'][tranche]['value'] + ((size = ++j)? '.' : ', '))

                        body += '           <em class="text-muted">Concernant les tranches suivantes : '+periode+'.</em>'

                    }else{
                        _recapitulatif = (isNaN(_recapitulatif))? 1 : _recapitulatif
                        tmp_montant = _montant
                }

                //Reste
                _montant_total -= current['remise']

                body += '       </td>'
                body += '       <td class="text-right">'+tmp_montant +' Fcfa</td>'
                body += '       <td class="text-right">'+ _recapitulatif +'</td>'
                sub_total = tmp_montant * _recapitulatif
                body += '       <td class="text-right">'+ sub_total +' Fcfa</td>'

                body += '</tr>'
                sous_total += sub_total

            }
        //Pension Scolaire

        //Cantines
            current = cantines 
            let _est_mensuel = parseInt(current['est_mensuel'])
            let _montant = parseFloat(current['montant'])
            let _mensualite = parseFloat(current['mensualite'])
            _multiplicateur = parseFloat(current['multiplicateur'])
            _multiplicateur = (isNaN(_multiplicateur))? 0 : _multiplicateur
            let _remise = parseFloat(current['remise'])
            _remise = (isNaN(_remise))? 0 : _remise
            if(_multiplicateur > 0){
                ++i
                body += '<tr>'
                body += '   <th scope="row">'+i+'</th>'
                body += '       <td>'
                body += '           <p>Pension : Cantine </p>'



                msg = ''
                sub_total = 0
                tmp_montant = 0
                tmp_montant = cantine_prix_mois
                sub_total = tmp_montant * _multiplicateur - _remise
                msg = _multiplicateur+"*"+tmp_montant+"-"+_remise+ " = " +sub_total

                _montant_total += sub_total
                let j = 0
                let periode = ''
     
                for(var tranche in current['recapitulatif'])
                    periode += (current['recapitulatif'][tranche]['value'] + ((size = ++j)? '.' : ', '))

                body += '           <em class="text-muted">Concernant les tranches suivantes : '+periode+'.</em>'

                body += '       </td>'
                body += '       <td class="text-right">'+tmp_montant +' Fcfa</td>'
                body += '       <td class="text-right">'+ _multiplicateur +'</td>'
                sub_total = tmp_montant * _multiplicateur
                body += '       <td class="text-right">'+ sub_total +' Fcfa</td>'

                    body += '</tr>'
                }
        //Cantines

        //Activite
            let activites_souscrits  = activites['activites']
            current = activites 
            _est_mensuel = parseInt(current['est_mensuel'])
            _montant = parseFloat(current['montant'])
            _mensualite = parseFloat(current['mensualite'])
            _remise = parseFloat(current['remise'])
            _remise = (isNaN(_remise))? 0 : _remise

            // console.log(current)
            // console.log(parseInt(current['recapitulatif']))

            let nbre_tranche = parseInt(current['recapitulatif'])
            nbre_tranche = (isNaN(nbre_tranche))? 0 : nbre_tranche
            // console.log(parseInt(nbre_tranche))

            sub_total = 0
            if(nbre_tranche != 0 ){
            // if(nbre_tranche != 0 && activites_souscrits != undefined && activites_souscrits.length !== 0){
                ++i
                body += '<tr>'
                body += '   <th scope="row">' + i + '</th>'
                body += '       <td>'


                let tmp_montant = 0
                let tmp_montant_txt = ''
                let msg = ''

                for (let j=0; j<activites_souscrits.length; j++) {

                    if (j == activites_souscrits.length - 1) {
                        msg += activites_souscrits[j]['value'] + '. '
                        tmp_montant_txt += activites_souscrits[j]['montant'] 
                    } else {
                        msg += activites_souscrits[j]['value'] + ', '
                        tmp_montant_txt += activites_souscrits[j]['montant'] + ' + '
                    }
                    
                    tmp_montant += parseFloat( activites_souscrits[j]['montant'] )
                }

                sub_total += (tmp_montant * nbre_tranche)
                tmp_montant = (tmp_montant * nbre_tranche)
                tmp_montant_txt = '(' + tmp_montant_txt+')*' + nbre_tranche

                body += '           <p>Pension des activités : ' + msg + '</p>'

                sub_total = sub_total - _remise

                _montant_total += sub_total
                let j = 0
                let periode = ''

                for (var tranche in current['multiplicateur'])
                    periode += (current['multiplicateur'][tranche]['value'] + ((size = ++j)? '.' : ', '))
        

                body += '           <em class="text-muted">Concernant les tranches suivantes : '+periode+'.</em>'
                body += '       </td>'
                body += '       <td class="text-right">'+tmp_montant_txt +' Fcfa</td>'
                body += '       <td class="text-right">'+ nbre_tranche +'</td>'

                body += '       <td class="text-right">'+ tmp_montant +' Fcfa</td>'
                body += '</tr>'
            }
        //Activite

        //Autres
            current = autres 
            _montant = parseFloat(current['montant'])
            _montant = (isNaN(_montant))? 0 : _montant
            _remise = parseFloat(current['remise'])
            _remise = (isNaN(_remise))? 0 : _remise
            _montant_total += _montant

            if(_montant !== 0){
                ++i
                body += '<tr>'
                body += '   <th scope="row">'+i+'</th>'
                body += '       <td>'
                body += '           <p>Pension : '+ current['type_pension']+'</p>'
                body += '       </td>'
                body += '       <td class="text-right">'+_montant +' Fcfa</td>'
                body += '       <td class="text-right">  1 </td>'
                body += '       <td class="text-right">'+ _montant +' Fcfa</td>'
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


        data_versement['reduction'] = reduction
        data_versement['sous_total'] = data_versement['montant_paye'] -  data_versement['reduction']


        $('#recap-total-top').text(   data_versement['montant_paye'] )
        $('#recap-total-bottom').text( data_versement['montant_paye'] )
        $('#recap-reduction').text( data_versement['reduction'] )
        $('#recap-sous_total').text( parseInt( data_versement['montant_paye'] ) -  data_versement['reduction'] )

        $('#recap-signataire').text( data_versement['signataire'] )
        $('#recap-funtion_signataire').text(  data_versement['funtion_signataire'] )

        $('#section_versement').hide()
        $('#section_recaputilatif').show()
    });

</script>
