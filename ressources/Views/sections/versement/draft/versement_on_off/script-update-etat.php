<?php

use App\Helpers\S;
use App\Helpers\Helpers;

$signataire = "Charbonnier LaRose";
$funtion_signataire = "Le Sécrétariat";

?>

<script>
    
    $(document).on('click', '#btn_preview', function(e)
    {  
        $('#recap-body').html("");
        var sous_total = 0;
        $('#recap-reference').text(reference);
        $('#recap-somme').text( $('#somme').text() );
        
        var body = "";
        var i = 0;

        console.log(items);

        for(var item in items)
        {
            ++i;
            // console.log("########   "+i++);
            let current = items[item];

            let _state = current['state'];

            var _type_pension_code = current['type_pension_code'];
            if(_state){
                let  _est_mensuel    = parseInt(current['est_mensuel']);
                let _montant =  parseFloat(current['montant']);
                let _mensualite = parseFloat(current['mensualite']);

                let  msg = "";
                let  sub_total = 0;
                let  tmp_montant = 0;
        

                var _recapitulatif = parseFloat(current['recapitulatif']);


                body += "<tr>";
                body += '   <th scope="row">'+i+'</th>';
                body += '       <td>';
                body += '           <p>Pension : '+current['type_pension']+'</p>';

            
               if(_est_mensuel === 1){
                    _recapitulatif = (isNaN(_recapitulatif))? 0 : _recapitulatif;
                    tmp_montant = _mensualite;
                    
                    let subdody = '';
                    let periode  = ' ';
                    let size = current['multiplicateur'].length;
                    let i = 0;

                    for(var tranche in current['multiplicateur'])
                    {
                        if(size = ++i){
                            periode += current['multiplicateur'][tranche]['value']+'.';
                        }else{
                            periode += current['multiplicateur'][tranche]['value'] +', ';
                        }
                    }

                    console.log(periode);

                    body += '           <em class="text-muted">Concernant les tranches suivantes : '+periode+'.</em>';
                    
                }else{
                    _recapitulatif = (isNaN(_recapitulatif))? 1 : _recapitulatif;
                    tmp_montant = _montant;
               }
                
                body += '       </td>';
                body += '       <td class="text-right">'+tmp_montant +' Fcfa</td>';
                body += '       <td class="text-right">'+ _recapitulatif +'</td>';
                sub_total = tmp_montant * _recapitulatif;
                body += '       <td class="text-right">'+ sub_total +' Fcfa</td>';

                //msg = _recapitulatif+" * "+tmp_montant+ " = " +sub_total;
                
                //$('#COL4-'+_type_pension_code).val(msg);

               body += '</tr>';
               sous_total += sub_total;

            }
        }
        $('#recap-body').html(body);

        $('#recap-nom').text( $('#eleve_nom_complet option:selected').text() );
        $('#recap-classe').text( $('#classe option:selected').text() );
        
        let date_paiement = $( "#date_paiement" ).text();
        console.log('date_paiement');
        console.log(date_paiement);
        let classe = $( "#classe option:selected" ).text();
        let type_paiement = $( "#type_paiement option:selected" ).text();
        let date_facture = "<?= Helpers::getFullDate(date("Y-m-d H:i:s")); ?>";
        
        $('#recap-date').text( date_facture );
        
        $('#recap-description').text( $('#motif').text() );
        $('#recap-prix').text( $('#montant').text() );
        $('#recap-quantite').text( $('#quantite').text() );
        $('#recap-somme').text( $('#somme').text() );
 
        $('#recap-mode_paiement').text( $('#type_paiement option:selected').text() );

        //NON PRIS EN COMPTE
        $('#recap-banque').hide();
        $('#recap-cheque').hide();
        $('#recap-nom_banque').hide();
        $('#recap-numero_cheque').hide();
        
        $('#recap-total').text( $('#montant').val() );
        $('#recap-reduction').text( $('#reduction').val() );
        $('#recap-reste').text( $('#reste').val() );
        $('#recap-sous_total').text( sous_total );

        $('#recap-signataire').text( "<?=  $signataire; ?>" );
        $('#recap-funtion_signataire').text(  "<?= $funtion_signataire; ?>" );
        // $('#recap-numero_ligne').text( 1 );
 
        $('#section_versement').hide();
        $('#section_recaputilatif').show();
    });


</script>
