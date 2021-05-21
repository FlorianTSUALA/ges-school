<?php

use App\Helpers\S;

?>

<script>
    var tranches = []
    var isFirstLoad = true
    var fromInscription = <?= ($this->session->has(S::DATA_TRANSPORT))? 'true' : 'false' ;?>

    var type_pension = $('#type_pension')
    var eleve_nom_complet = $('#eleve_nom_complet')
    var classe = $('#classe')
    var statut_apprenant = $('#statut_apprenant')

    var reduction = $('.reduction')
    // var reste = $('#reste')
    var montant = $('#montant')

    var section_versement = $('#section_versement')
    var section_recaputilatif = $('#section_recaputilatif')

    var btn_preview = $('#btn_preview')
    var btn_save = $('#btn_save')
    var btn_home = $('#btn_home')
    var btn_back = $('#btn_back')
    var btn_print = $('#btn_print')
    var loading = $('#loading')

    var eleve_id
    var eleve_matricule
    var classe_id
    var type_pension_id
    var _montant = 0
    var _est_mensuel = 0
    var _mensualite = 0
    // var _reduction = 0
    var _reste = 0

    var cantine_prix_mois = <?= $prix_abonnement_cantine;?>

    function init(){

        if(fromInscription){
            $(eleve_nom_complet).val("<?= $this->session->get(S::DATA_TRANSPORT, S::VERS_CODE_ELEVE);?>").trigger('change')
            $(classe).val("<?= $this->session->get(S::DATA_TRANSPORT, S::VERS_CODE_CLASSE);?>").trigger('change')
            $(statut_apprenant).val("<?= $this->session->get(S::DATA_TRANSPORT, S::VERS_CODE_STATUT_APPRENANT);?>").trigger('change')
            fromInscription = false;
        }

        if(isFirstLoad){
            trigger($(classe).select2().find(':selected').data('id'))
            isFirstLoad = false;
        }

        let _montant_total = 0;
        let i = 0;

        for(var item in items)
        {
            let current = items[item];
            var _type_pension_code = current['type_pension_code'];
            
            let  _est_mensuel    = parseInt(current['est_mensuel'])
            let _montant =  parseFloat(current['montant'])
            let _mensualite = parseFloat(current['mensualite'])

            let  msg = "";
            let  sub_total = 0;
            let  tmp_montant = 0;

            let _recapitulatif = parseFloat(current['recapitulatif'])
            if(_est_mensuel === 1){
                _recapitulatif = (isNaN(_recapitulatif))? 0 : _recapitulatif;
                tmp_montant = _mensualite;
            }else{
                _recapitulatif = (isNaN(_recapitulatif))? 0 : _recapitulatif;
                tmp_montant = _montant;
            }

            let _remise = parseFloat(current['remise'])
            _remise = (isNaN(_remise))? 0 : _remise;

            sub_total = tmp_montant*_recapitulatif - _remise;
            msg = _recapitulatif+"*"+tmp_montant+"-"+_remise+ " = " +sub_total;

            $('#COL4-'+_type_pension_code).val(msg)

            _montant_total += sub_total;
            
        }


        //Autres
            let current = autres
            let  msg = ''
            let  sub_total = 0
            let _montant = parseFloat(current['montant'])
            _montant = (isNaN(_montant))? 0 : _montant
            let _remise = parseFloat(current['remise'])
            _remise = (isNaN(_remise))? 0 : _remise

            sub_total = _montant - _remise
            msg = _montant+'-'+_remise+ ' = ' +sub_total
            _montant_total += sub_total

            $('#COL4-Autres').val(msg)
        //Autres
        
        //Cantines
            cantines['montant'] = cantine_prix_mois
            current = cantines 
            _montant = cantine_prix_mois
            msg = ''
            sub_total = 0

            _multiplicateur = parseFloat(current['multiplicateur'])
            _multiplicateur = (isNaN(_multiplicateur))? 0 : _multiplicateur

            _remise = parseFloat(current['remise'])
            _remise = (isNaN(_remise))? 0 : _remise
            
            // console.log('MES MES MES '+_remise)

            sub_total = _montant*_multiplicateur - _remise
            msg = _multiplicateur+'*'+_montant+'-'+_remise+ ' = ' +sub_total

            $('#COL4-Cantine').val(msg)
            _montant_total += sub_total
        //Cantine

        //Activite
            let activites_souscrits  = activites['activites']
            current = activites
            _est_mensuel = parseInt(current['est_mensuel'])
            _montant = parseFloat(current['montant'])
            _mensualite = parseFloat(current['mensualite'])
            msg = ''
            sub_total = 0
            tmp_montant = 0

            let nbre_tranche = parseInt(current['recapitulatif'])
            nbre_tranche = (isNaN(nbre_tranche))? 0 : nbre_tranche

            if(activites_souscrits != undefined){
                for(let i=0; i<activites_souscrits.length; i++){
                    tmp_montant = activites_souscrits[i]['montant']
                    sub_total += (tmp_montant*nbre_tranche)
                    if(i == activites_souscrits.length - 1){
                        msg += nbre_tranche+"*"+tmp_montant
                    }else{
                        msg += nbre_tranche+"*"+tmp_montant+"+"
                    }
                }
            }
            _remise = parseFloat(current['remise'])
            _remise = (isNaN(_remise))? 0 : _remise
            sub_total = sub_total - _remise

            msg += "-"+_remise+ " = " +sub_total
            $('#COL4-Activite').val(msg)
            _montant_total += sub_total
        //Activite

        // //Reste
            // _reduction = parseFloat($(reduction).val())
            // _reste = parseFloat($(reste).val())
            // _montant_total -= _reduction
            _montant_total -= _reste
            let reduction_familiale = (isNaN($('#RF-reduction').val()))? 0 : $('#RF-reduction').val()
            _montant_total = _montant_total - reduction_familiale
            $(montant).val(_montant_total)
        // //Reste

    }

    $(document).ready(function(){

        $(btn_home).hide()
        $(btn_print).hide()

        $(eleve_nom_complet).on("select2:select select2:unselecting", function () {
            $(eleve_nom_complet).select2('data')
            init()
        })

        $(classe).on("select2:select select2:unselecting", function () {
            trigger($(classe).select2().find(":selected").data("id"))
            init()
        })


        $(reduction).on("change paste keyup mouseup", function () {
            if($(reduction).val() < 0)
                $(reduction).val(0)
            init()
        })

        // $(reste).on("change paste keyup mouseup", function () {
        //     if($(reste).val() < 0)
        //         $(reste).val(0)
        //     init()
        // })

        $(btn_preview).click(function() {
            $(section_versement).hide()
            $(section_recaputilatif).show()
        })

        $(btn_back).click(function() {
            $(section_recaputilatif).hide()
            $(section_versement).show()
        })

        $(btn_save).click(function() {
            sauvegarderVersement()
        })
        
        $(btn_print).click(function() {
            imprimerRecuVersement()
        })
        
        init()

    })


</script>