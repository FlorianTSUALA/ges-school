<?php

    use App\Helpers\Helpers;

    $signataire = 'Charbonnier LaRose';
    $funtion_signataire = 'Le Sécrétariat';

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
    var items = []
    // var data_items = {}
    var data_facture = {}
    var date_debut
    var date_fin
    data_facture['long_date_facture']  = '<?= Helpers::getFullDate(date('Y-m-d')) ?>'
    data_facture['reference'] = "<?= Helpers::generateReference(); ?>";
    // Variable pour la generation des etats
    var reduction;
    var type_paiement;
    var eleve_nom_complet;
    var classe
    var montant_total
    var date_versement

    // DEFINITION DES ID des elements PHP

    var section_versement = $('#section_versement')
    var section_recaputilatif = $('#section_recaputilatif')

    var btn_preview = $('#btn_preview')
    var btn_save = $('#btn_save')
    var btn_home = $('#btn_home')
    var btn_back = $('#btn_back')
    var btn_print = $('#btn_print')
    var loading = $('#loading')

    var prix_abonnements = <?php echo Helpers::toJSON($prix_abonnements) ; ?>;
    
        //GESTION DE AJOUT DYNAMIQUE DE BLOCK
        function updateItem(parent, editPirx=true){
                let selected = parent.find(".periode").val()
                if(prix_abonnements.length === 0) return
                let tmp = prix_abonnements.filter((item)=>{
                    return String(item.periode) === String(selected)
                })
                let current = tmp[0]
                if(editPirx)
                    parent.find(".prix_unitaire").val( parseFloat(current.montant) )
                parent.find(".sous_total").val( parent.find(".prix_unitaire").val()* parent.find(".duree").val() )
                init()
        }

        function init(){
            items = $('.repeater').repeaterVal()

            let sum = 0
            if( items !== undefined && items.data != undefined ){
                console.log(items.data)
                items.data.forEach(function(item, index){
                let val = parseFloat(item.sous_total)
                    if (!isNaN(val))
                            sum += val
                })

                if((sum - $('#reduction').val()) < 1)
                    $('#reduction').val(0)
                $('#montant_total').val(sum - $('#reduction').val())
            }
        }

        function initItem(target){
            let selected = $(target).find('.periode').val()
            if(prix_abonnements.length === 0) return
            console.log("Periode "+selected)
            let tmp = prix_abonnements.filter((item)=>{
                return String(item.periode) === String(selected)
            })
           
            let current = tmp[0]
            $(target).find('.prix_unitaire').val( parseFloat(current.montant) )
            $(target).find('.duree').val( 1 )
            $(target).find('.sous_total').val( $(target).find(".prix_unitaire").val()* $(target).find(".duree").val() )
            init()
        }

        (function(window, document, $) {
            //'use strict'

            $('#section_versement').on('change', ".prix_unitaire", function(){
                let parent = $(this).parent().parent().parent().parent()
                updateItem(parent, false)
            })

            $('#section_versement').on('change', "select.periode, .duree", function(){
                let parent = $(this).parent().parent().parent().parent()
                updateItem(parent)
            })

            let target = $('.periode').parent().parent().parent().parent()
            initItem(target)

            //Gerer le cas ou le montant_total total peut etre negatif
            
            $('#section_versement').on('change', "#reduction", function(){
                init()
            })

            // Default
            $('.repeater').repeater({
                // (Optional)
                // start with an empty list of repeaters. Set your first (and only)
                // "data-repeater-item" with style="display:none;" and pass the
                // following configuration flag
                initEmpty: false,
                // (Optional)
                // "defaultValues" sets the values of added items.  The keys of
                // defaultValues refer to the value of the input's name attribute.
                // If a default value is not specified for an input, then it will
                // have its value cleared.
                defaultValues: {
                    'periode': 'JOUR',
                    'sous_total': '0',
                    //'text-input': 'foo',
                },
                // (Optional)
                // "show" is called just after an item is added.  The item is hidden
                // at this point.  If a show callback is not given the item will
                // have $(this).show() called on it.
                show: function () {
                    $(this).slideDown()

                    /**date_debut
                    duree
                    prix_unitaire
                    sous_total */

                    initItem(this)

                    $('#section_versement').on('change', '.prix_unitaire', function(){
                        let parent = $(this).parent().parent().parent().parent()
                        updateItem(parent, false)
                    })

                    $('#section_versement').on('change', "select.periode, .duree", function(){
                        let parent = $(this).parent().parent().parent().parent()
                        updateItem(parent)
                    })

                },
                // (Optional)
                // "hide" is called when a user clicks on a data-repeater-delete
                // element.  The item is still visible.  "hide" is passed a function
                // as its first argument which will properly remove the item.
                // "hide" allows for a confirmation step, to send a delete request
                // to the server, etc.  If a hide callback is not given the item
                // will be deleted.
                hide: function (deleteElement) {

                if(confirm('Voulez vous supprimer cet élément ?')) {
                        $(this).slideUp(deleteElement)
                    }
                    setTimeout(function(){ init() }, 500)

                },
                // (Optional)
                // You can use this if you need to manually re-index the list
                // for example if you are using a drag and drop library to reorder
                // list items.
                /*ready: function (setIndexes) {
                    $dragAndDrop.on('drop', setIndexes)
                },*/
                // (Optional)
                // Removes the delete button from the first list item,
                // defaults to false.
                isFirstItemUndeletable: true
            })
            init()

    })(window, document, jQuery)




/*
    //GESTION DE LA PREVISUALISATION

    var eleve_id;
    var eleve_matricule;
    var classe_id;
    var type_pension_id;
    var _montant_total = 0;
    var _est_mensuel = 0;
    var _mensualite = 0;
    var _reduction = 0;
    var _reste = 0;

    // var cantine_prix_mois = abonnement_cantine['montant_total'];
*/

    function update_etat(){
        console.log("WELCOME TO UPDATE FACTURE")

        //Cantines
        date_debut = $('#date_debut').val()
        date_fin = $('#date_debut').val()
        let current = []
        items = $('.repeater').repeaterVal()
        let data_items = []
        let sum = 0

        if( items !== undefined && items.data != undefined ){
            current = items.data
        }

        data_facture['eleve_id'] = $('#eleve_nom_complet option:selected').val()
        data_facture['classe_id'] = $('#classe option:selected').val()
        data_facture['eleve'] = $('#eleve_nom_complet option:selected').text()
        data_facture['classe'] = $('#classe option:selected').text()
        data_facture['montant_total'] = $( '#montant_total' ).val()
        console.log("# date_versement : "+$( "#date_versement" ).val())
        data_facture['date_paiement'] = ($( "#date_versement" ).val())
        data_facture['date_versement'] =  $( "#date_versement" ).val()
        data_facture['description'] = $('#motif').text()
        data_facture['quantite'] = $('#quantite').text()
        data_facture['somme'] = $('#somme').text()
        data_facture['reduction'] = $('#reduction').val()
        data_facture['nom_complet'] = $('#eleve_nom_complet option:selected').text()
        data_facture['mode_paiement'] = $('#type_paiement option:selected').text()


        let i = 0
        let body = ''
        let date_ref
        let total_day = 0
        let total = 0
        
        data_facture['montant_total'] = 0

        current.forEach( (item, index) =>{

            let tmp_item = {}

            function addDaysToStr(date, days){
                date = strToLocaleDateTime(date)

                console.log(date, days)
                let _date = new Date(date)
                _date.setDate(_date.getDate() + days)
                return  _date.toLocaleDateString()
            }
            ++i 

            console.log(item)
            let dayCount = 0
            switch(item.periode){
                case 'JOUR':
                    dayCount = 1
                    break
                case 'SEMAINE':
                    dayCount = 7
                    break
                case 'MOIS':
                    dayCount = 30
                    break
                case 'ANNEE':
                    dayCount = 365
                    break
                default:
                    dayCount = 1
            }
            console.log('item')
            console.log(item)
            tmp_item['date_debut'] = addDaysToStr(date_debut, total_day)
            total_day += ( dayCount * item.duree )
            tmp_item['date_fin'] = addDaysToStr(date_debut, total_day -1)
            tmp_item['quantite'] = item.duree
            tmp_item['periode'] = item.periode
            tmp_item['prix_unitaire'] = item.prix_unitaire
            tmp_item['sous_total'] = tmp_item['prix_unitaire'] * tmp_item['quantite']
            tmp_item['resume'] = 'Du : '+  tmp_item['date_debut'] +' au '+ tmp_item['date_fin']
         
            body += "<tr>"
            body += '   <th scope="row">'+i+'</th>'
            body += '       <td>'
            body += '           <p>Periode : '+ tmp_item['periode'] +' </p>'
            body += '           <em class="text-muted">'+ tmp_item['resume'] +'.</em>'
            body += '       </td>'
            body += '       <td class="text-right">'+ tmp_item['prix_unitaire'] +' Fcfa</td>'
            body += '       <td class="text-right">'+ tmp_item['quantite'] +'</td>'
            body += '       <td class="text-right">'+ tmp_item['sous_total'] +' Fcfa</td>'

            body += '</tr>'

            data_items.push(tmp_item) // = tmp_item
            // data_items += {i, tmp_item} // = tmp_item
            data_facture['montant_total'] += tmp_item['sous_total']
        })

        data_facture['data_items'] = data_items

        data_facture['total_day'] = total_day

        data_facture['date_debut'] = (addDaysToStr(date_debut, 0))
        data_facture['date_fin'] = addDaysToStr( data_facture['date_debut'], data_facture['total_day'] - 1) //retrait du jour actuel
        
        data_facture['montant_paye'] = data_facture['montant_total'] - data_facture['reduction']

        $('#recap-body').html('')

        body += "<tr>"
        body += '       <td colspan="2">'
        body += '           <B>Nombre de jours : '+ data_facture['total_day'] +' </B>'
        body += '       </td>'
        body += '       <td colspan="3">'
        body += '           <B><em class="text-muted">Du : '+ data_facture['date_debut'] +' au '+ data_facture['date_fin'] +'.</em> </B>'
        body += '       </td>'
        body += '</tr>'

        data_facture['html_body'] = body

        $('#recap-body').html(data_facture['html_body'])
        $('#recap-mode_paiement').text( data_facture['mode_paiement'] )
        $('#recap-nom').text( data_facture['nom_complet'] )
        $('#recap-classe').text( data_facture['classe'] )

        $('#recap-date').text( data_facture['long_date_facture'] )

        $('#recap-description').text( data_facture['description'] )
        $('#recap-prix').text( data_facture['prix'] )
        $('#recap-quantite').text( data_facture['quantite'] )
        $('#recap-somme').text( data_facture['somme'] )
        $('#recap-reference').text(data_facture['reference'])

        //NON PRIS EN COMPTE
        $('#recap-banque').hide()
        $('#recap-cheque').hide()
        $('#recap-nom_banque').hide()
        $('#recap-numero_cheque').hide()

        $('#recap-total-top').text( data_facture['montant_total'])
        $('#recap-total-bottom').text( data_facture['montant_paye'] )
        $('#recap-reduction').text( data_facture['reduction'] )
        
        $('#recap-sous_total').text( data_facture['montant_total'] )

        $('#recap-signataire').text( "<?=  $signataire; ?>" )
        $('#recap-funtion_signataire').text( "<?= $funtion_signataire; ?>" )

        $('#section_versement').hide()
        $('#section_recaputilatif').show()

    }

    $(document).ready(function(){

        $(btn_home).hide()
        $(btn_print).hide()

        $(btn_preview).click(function() {
            update_etat()
            reduction = $('#reduction').val()
            type_paiement = $('#type_paiement').val()
            eleve_nom_complet = $('#eleve_nom_complet').val()
            classe = $('#classe').val()
            montant_total = $('#montant_total').val()
            date_versement = $('#date_versement').val()
            $(section_versement).hide()
            $(section_recaputilatif).show()
            
        })

        $(btn_back).click(function() {
            $(section_recaputilatif).hide()
            $(section_versement).show()
        })

        $(btn_save).click(function() {
            sauvegarderVersement()
            //check file : script-save.js
        })

        $(btn_print).click(function() {
            imprimerRecuVersement()
        })

    })


</script>