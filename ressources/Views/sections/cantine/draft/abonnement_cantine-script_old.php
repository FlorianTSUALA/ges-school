<?php

    use App\Helpers\Helpers;
    use App\Helpers\S;

    $signataire = "Charbonnier LaRose";
    $funtion_signataire = "Le Sécrétariat";

?>


<script>
    var items = []
    var date_facture = "<?= Helpers::getFullDate(date("y-M-d")) ?>"

    // Variable pour la generation des etats
    var remise;
    var type_paiement;
    var eleve_nom_complet;
    var classe
    var montant
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
    (function(window, document, $) {
        //'use strict'


        function addDays(date, days){
            const _date = new Date(date)
            _date.setDate(_date.getDate() + days)
            return  _date
        }

        function updateItem(parent, editPirx=true){
            let selected = parent.find(".periode").val()
            // console.log(selected)
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
                    if (!isNaN(val)) {
                            sum += val
                    }
                })

                if((sum - $('#remise').val()) < 1)
                    $('#remise').val(0)
                $('#montant').val(sum - $('#remise').val())

            }


        }


        


        function initItem(target){
            let selected = $(target).find(".periode").val()
            let tmp = prix_abonnements.filter((item)=>{
                return String(item.periode) === String(selected)
            })
            let current = tmp[0]
            $(target).find(".prix_unitaire").val( parseFloat(current.montant) )
            $(target).find(".duree").val( 1 )
            // $(target).find("._date_debut").val( '<?= date("Y-m-d")?>')
            // $(target).find(".date_debut").val( '<?= date("Y-m-d")?>')
            $(target).find(".sous_total").val( $(target).find(".prix_unitaire").val()* $(target).find(".duree").val() )
            init()
        }


        $('#section_versement').on("change", ".prix_unitaire", function(){
            let parent = $(this).parent().parent().parent().parent()
            updateItem(parent, false)
        })

        $('#section_versement').on("change", "select.periode, .duree", function(){
            let parent = $(this).parent().parent().parent().parent()
            updateItem(parent)
        })

        let target = $('.periode').parent().parent().parent().parent()
        initItem(target)


        //Gerer le cas ou le montant total peut etre negatif
        $('#section_versement').on("change", "#remise", function(){
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

                $('#section_versement').on("change", ".prix_unitaire", function(){
                    let parent = $(this).parent().parent().parent().parent()
                    updateItem(parent, false)
                })

                $('#section_versement').on("change", "._date_debut", function(){
                    let parent = $(this).parent().parent().parent().parent()
                    parent.find('.date_debut').val($(this).val())
                })


                $('#section_versement').on("change", ".date_debut", function(){
                    let parent = $(this).parent().parent().parent().parent()
                    parent.find('._date_debut').val($(this).val())
                })

                $('#section_versement').on("change", "select.periode, .duree", function(){
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


    })(window, document, jQuery)




/*

    //GESTION DE LA PREVISUALISATION




    var eleve_id;
    var eleve_matricule;
    var classe_id;
    var type_pension_id;
    var _montant = 0;
    var _est_mensuel = 0;
    var _mensualite = 0;
    var _remise = 0;
    var _reste = 0;

// var cantine_prix_mois = abonnement_cantine['montant'];
*/

    $(document).ready(function(){


        function update_etat(){

            $('#recap-body').html("")
            $('#recap-reference').text(reference)
            $('#recap-somme').text( $('#somme').text() )

            console.log("items")



            //Cantines
            let current = []
            items = $('.repeater').repeaterVal()
            let sum = 0
            if( items !== undefined && items.data != undefined ){
                current = items.data
            }
            let body = ''
            let i = 0

            // console.log(current)
            let isSameBeginDay = true

            for(let i = 1; i < current.length; i++)
            {
                if(current[i - 1].date_debut !== current[i].date_debut)
                {
                    isSameBeginDay = false
                    break
                }
            }

            let date_ref
            let tmp_sub_total_day = 0
            let total = 0
            let date_fin 
            //console.log(current)

            current.forEach( (item, index) =>{
                ++i
                let dayCount = 0

                let duree = item.duree
                let periode = item.periode
                switch(periode){
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
                }

                
                function addDays(date, days){
                    console.log('H')
                    console.log(date)
                    const _date = new Date(date)
                    _date.setDate(_date.getDate() + days)
                    return  _date
                }

                console.log(item, isSameBeginDay)

                let date_debut = ( i === 1  && !isSameBeginDay )? item.date_debut : addDays(date_fin, 1)
                //let date_debut = ( i === 1  )? item.date_debut : ( isSameBeginDay ) addDays(item.date_fin, 1) : item.date_debut
                let prix_unitaire = item.prix_unitaire
               
                let sub_total = prix_unitaire * duree

                tmp_sub_total_day = dayCount * duree

                date_fin = addDays(date_debut, tmp_sub_total_day)

                body += "<tr>"
                body += '   <th scope="row">'+i+'</th>'
                body += '       <td>'
                body += '           <p>Periode : '+ periode +' </p>'
                body += '           <em class="text-muted">A compter du  : '+ date_debut +'.</em>'
                body += '       </td>'
                body += '       <td class="text-right">'+ prix_unitaire +' Fcfa</td>'
                body += '       <td class="text-right">'+ duree +'</td>'
                body += '       <td class="text-right">'+ sub_total +' Fcfa</td>'

                body += '</tr>'
                date_ref =
                date_debut = date_fin
                

                console.log(date_debut)
                console.log(date_fin)

            })


            $('#recap-body').html(body)

            $('#recap-nom').text( $('#eleve_nom_complet option:selected').text() )
            $('#recap-classe').text( $('#classe option:selected').text() )

            let date_versement = $( "#date_versement" ).text()

            let classe = $( "#classe option:selected" ).text()
            let type_paiement = $( "#type_paiement option:selected" ).text()
            let date_facture = "<?= Helpers::getFullDate(date("Y-m-d H:i:s")) ?>"

            $('#recap-date').text( date_facture )

            $('#recap-description').text( $('#motif').text() )
            $('#recap-prix').text( $('#montant').text() )
            $('#recap-quantite').text( $('#quantite').text() )
            $('#recap-somme').text( $('#somme').text() )

            $('#recap-mode_paiement').text( $('#type_paiement option:selected').text() )

            //NON PRIS EN COMPTE
            $('#recap-banque').hide()
            $('#recap-cheque').hide()
            $('#recap-nom_banque').hide()
            $('#recap-numero_cheque').hide()

            $('#recap-total-top').text( $('#montant').val())
            $('#recap-total-bottom').text( $('#montant').val())
            $('#recap-reduction').text( $('#remise').val() )
            $('#recap-sous_total').text( parseInt($('#montant').val() ) )

            $('#recap-signataire').text( "<?=  $signataire; ?>" )
            $('#recap-funtion_signataire').text(  "<?= $funtion_signataire; ?>" )
            // $('#recap-numero_ligne').text( 1 )

            $('#section_versement').hide()
            $('#section_recaputilatif').show()



            }

        
        $(btn_home).hide()
        $(btn_print).hide()


        $(btn_preview).click(function() {
            remise = $('.remise').val()
            type_paiement = $('#type_paiement').val()
            eleve_nom_complet = $('#eleve_nom_complet').val()
            classe = $('#classe').val()
            montant = $('#montant').val()
            date_versement = $('#date_versement').val()
            $(section_versement).hide()
            $(section_recaputilatif).show()
            update_etat()

        })

        $(btn_back).click(function() {
            $(section_recaputilatif).hide()
            $(section_versement).show()
        })

        $(btn_save).click(function() {
            sauvegarderVersement()
        })

    })


</script>





