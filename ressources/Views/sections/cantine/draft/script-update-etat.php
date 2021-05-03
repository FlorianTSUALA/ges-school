<?php

use App\Helpers\S;
use App\Helpers\Helpers;

$signataire = "Charbonnier LaRose";
$funtion_signataire = "Le Sécrétariat";

?>

<script>

    $(document).on('click', '#btn_preview', function(e)
    {
        $('#recap-body').html("")
        $('#recap-reference').text(reference)
        $('#recap-somme').text( $('#somme').text() )

       console.log("items")
       console.log(items)

        for(var item in items)
        {
            ++i;
            let current = items[item];

            let _state = current['state'];

            var _type_pension_code = current['type_pension_code'];
            if(_state){
                let  _est_mensuel    = parseInt(current['est_mensuel'])
                let _montant =  parseFloat(current['montant'])
                let _mensualite = parseFloat(current['mensualite'])

                let  msg = "";
                let  sub_total = 0;
                let  tmp_montant = 0;

                var _recapitulatif = parseFloat(current['recapitulatif'])
                _recapitulatif = (isNaN(_recapitulatif))? 0 : _recapitulatif;
                if(_recapitulatif == 0) continue;

                body += "<tr>";
                body += '   <th scope="row">'+i+'</th>'
                body += '       <td>'
                body += '           <p>Pension : '+current['type_pension']+'</p>'

                if(_est_mensuel === 1){

                        tmp_montant = _mensualite;

                        let subdody = ''
                        let periode  = ' '
                        var size = current['multiplicateur'].length;
                        let j = 0;

                        for(var tranche in current['multiplicateur'])
                        {
                            if(size = ++j){
                                periode += current['multiplicateur'][tranche]['value']+'.'
                            }else{
                                periode += current['multiplicateur'][tranche]['value'] +', '
                            }
                        }

                        console.log(periode)

                        body += '           <em class="text-muted">Concernant les tranches suivantes : '+periode+'.</em>'

                    }else{
                        _recapitulatif = (isNaN(_recapitulatif))? 1 : _recapitulatif;
                        tmp_montant = _montant;
                }

                //Reste
                _reduction = parseFloat($(reduction).val())
                _reste = parseFloat($(reste).val())
                _montant_total -= _reduction;
                _montant_total -= _reste;

                body += '       </td>'
                body += '       <td class="text-right">'+tmp_montant +' Fcfa</td>'
                body += '       <td class="text-right">'+ _recapitulatif +'</td>'
                sub_total = tmp_montant * _recapitulatif;
                body += '       <td class="text-right">'+ sub_total +' Fcfa</td>'

                body += '</tr>'
                sous_total += sub_total;

            }
        }


            //Cantines
            current = cantines

            console.log("La cantine")
            console.log(cantines)

            console.log("Item")
            console.log(items)

            let _est_mensuel = parseInt(current['est_mensuel'])
            let _montant = parseFloat(current['montant'])
            let _mensualite = parseFloat(current['mensualite'])
            _recapitulatif = parseFloat(current['recapitulatif'])
            _recapitulatif = (isNaN(_recapitulatif))? 0 : _recapitulatif;
            let _remise = parseFloat(current['remise'])
            _remise = (isNaN(_remise))? 0 : _remise;
            if(_recapitulatif !== 0){
                ++i;
                body += "<tr>";
                body += '   <th scope="row">'+i+'</th>'
                body += '       <td>'
                body += '           <p>Pension : Cantine </p>'



                msg = "";
                sub_total = 0;
                tmp_montant = 0;
                tmp_montant = cantine_prix_mois;
                sub_total = tmp_montant*_recapitulatif - _remise;
                msg = _recapitulatif+"*"+tmp_montant+"-"+_remise+ " = " +sub_total;


                let j = 0;
                let periode = ''
                for(var tranche in current['multiplicateur'])
                {
                    if(size = ++j){
                        periode += current['multiplicateur'][tranche]['value']+'.'
                    }else{
                        periode += current['multiplicateur'][tranche]['value'] +', '
                    }
                }
                body += '           <em class="text-muted">Concernant les tranches suivantes : '+periode+'.</em>'

                body += '       </td>'
                body += '       <td class="text-right">'+tmp_montant +' Fcfa</td>'
                body += '       <td class="text-right">'+ _recapitulatif +'</td>'
                sub_total = tmp_montant * _recapitulatif;
                body += '       <td class="text-right">'+ sub_total +' Fcfa</td>'

                body += '</tr>'
            }

            //Activite
            let activites_souscrits  = activites['activites'];
            current = activites ;
            _est_mensuel = parseInt(current['est_mensuel'])
            _montant = parseFloat(current['montant'])
            _mensualite = parseFloat(current['mensualite'])
            _remise = parseFloat(current['remise'])
            _remise = (isNaN(_remise))? 0 : _remise;


            let nbre_tranche = parseInt(current['recapitulatif'])
            nbre_tranche = (isNaN(nbre_tranche))? 0 : nbre_tranche;

            sub_total = 0;
            tmp_montant = 0;
            if(nbre_tranche != 0 && activites_souscrits != undefined && activites_souscrits.length !== 0){
                ++i;
                body += "<tr>";
                body += '   <th scope="row">'+i+'</th>'
                body += '       <td>'

                let msg = ''
                for(let j=0; j<activites_souscrits.length; j++){
                    tmp_montant = activites_souscrits[j]['montant'];
                    sub_total += (tmp_montant*nbre_tranche)
                    if(j == activites_souscrits.length - 1){
                        msg += activites_souscrits[j]['value']+". ";
                    }else{
                        msg += activites_souscrits[j]['value']+", ";
                    }
                }
                body += '           <p>Pension des activités : '+msg+'</p>'


                sub_total = sub_total - _remise;

                _montant_total += sub_total;
                let j = 0;
                let periode = ''
                for(var tranche in current['multiplicateur'])
                {
                    if(size = ++j){
                        periode += current['multiplicateur'][tranche]['value']+'.'
                    }else{
                        periode += current['multiplicateur'][tranche]['value'] +', '
                    }
                }
                body += '           <em class="text-muted">Concernant les tranches suivantes : '+periode+'.</em>'

                body += '       </td>'
                body += '       <td class="text-right">'+tmp_montant +' Fcfa</td>'
                body += '       <td class="text-right">'+ _recapitulatif +'</td>'
                sub_total = tmp_montant * _recapitulatif * nbre_tranche;
                body += '       <td class="text-right">'+ sub_total +' Fcfa</td>'
                body += '</tr>'
            }


            //Autres
            current = autres ;
            _montant = parseFloat(current['multiplicateur'])
            _montant = (isNaN(_montant))? 0 : _montant;
            _remise = parseFloat(current['remise'])
            _remise = (isNaN(_remise))? 0 : _remise;
            if(_montant !== 0){
                ++i;
                body += "<tr>";
                body += '   <th scope="row">'+i+'</th>'
                body += '       <td>'
                body += '           <p>Pension : '+current['type_pension']+'</p>'

                let  sub_total = 0;
                let  tmp_montant = _montant;

                _montant_total += _montant;

                body += '       </td>'
                body += '       <td class="text-right">'+tmp_montant +' Fcfa</td>'
                body += '       <td class="text-right">  1 </td>'
                sub_total = tmp_montant ;
                body += '       <td class="text-right">'+ sub_total +' Fcfa</td>'

                body += '</tr>'
            }



        $('#recap-body').html(body)

        $('#recap-nom').text( $('#eleve_nom_complet option:selected').text() )
        $('#recap-classe').text( $('#classe option:selected').text() )

        let date_paiement = $( "#date_paiement" ).text()
        console.log('date_paiement')
        console.log(date_paiement)
        
        let classe = $( "#classe option:selected" ).text()

        let type_paiement = $( "#type_paiement option:selected" ).text()

        let date_facture = "<?= Helpers::getFullDate(date("Y-m-d H:i:s")) ?>";

        $('#recap-date').text( date_facture )

        $('#recap-description').text( $('#motif').text() )
        $('#recap-prix').text( $('#montant').text() )
        console.log()
        $('#recap-quantite').text( $('#quantite').text() )
        $('#recap-somme').text( $('#somme').text() )

        $('#recap-mode_paiement').text( $('#type_paiement option:selected').text() )

        //NON PRIS EN COMPTE
        $('#recap-banque').hide()
        $('#recap-cheque').hide()
        $('#recap-nom_banque').hide()
        $('#recap-numero_cheque').hide()

        $('#recap-total-top').text( $('#montant_total').val())
        $('#recap-total-bottom').text( $('#montant_total').val())
        $('#recap-reduction').text( $('#reduction').val() )
        console.log("La reduction "+$('#reduction').val())
        $('#recap-reste').text( $('#reste').val() )
        $('#recap-sous_total').text( parseInt($('#montant_total').val() -  $('#reste').val()) )

        $('#recap-signataire').text( "<?=  $signataire; ?>" )
        $('#recap-funtion_signataire').text(  "<?= $funtion_signataire; ?>" )
        // $('#recap-numero_ligne').text( 1 )

        $('#section_versement').hide()
        $('#section_recaputilatif').show()
    })

</script>
