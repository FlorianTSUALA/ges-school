<?php

use App\Helpers\S;

?>

<script>
    var tranches = [];
    var isFirstLoad = true;
    var fromInscription = <?= ($this->session->has(S::DATA_TRANSPORT))? 'true' : 'false' ;?>;

    var type_pension = $('#type_pension');
    var eleve_nom_complet = $('#eleve_nom_complet');
    var classe = $('#classe');
    var statut_apprenant = $('#statut_apprenant');
   
    var reduction = $('#reduction');
    var reste = $('#reste');
    var montant = $('#montant');

    var section_versement = $('#section_versement');
    var section_recaputilatif = $('#section_recaputilatif');

    var btn_preview = $('#btn_preview');
    var btn_save = $('#btn_save');
    var btn_home = $('#btn_home');
    var btn_back = $('#btn_back');
    var btn_print = $('#btn_print');
    var loading = $('#loading');
    
    var eleve_id;
    var eleve_matricule;
    var classe_id;
    var type_pension_id;
    var _montant = 0;
    var _est_mensuel = 0;
    var _mensualite = 0;
    var _reduction = 0;
    var _reste = 0;

    function init(){
        // var item = { "state" : '', "type_pension_code" : '', "multiplicateur": '', "recapitulatif": "", 
        //"montant": 0, "mensualite": 0, "est_mensuel": false};
      
        if(fromInscription){
            $(eleve_nom_complet).val("<?= $this->session->get(S::DATA_TRANSPORT, S::VERS_CODE_ELEVE);?>").trigger('change');
            $(classe).val("<?= $this->session->get(S::DATA_TRANSPORT, S::VERS_CODE_CLASSE);?>").trigger('change');
            $(statut_apprenant).val("<?= $this->session->get(S::DATA_TRANSPORT, S::VERS_CODE_STATUT_APPRENANT);?>").trigger('change');
            fromInscription = false;
        }

        if(isFirstLoad){
            trigger($(classe).select2().find(":selected").data("id"));
            isFirstLoad = false;
        }
        let _montant_total = 0;
        //console.log(items);
        let i = 0;
        for(var item in items)
        {
            // console.log("########   "+i++);
            let current = items[item];

            let _state = current['state'];
            
            // console.log("State : "+_state);

            var _type_pension_code = current['type_pension_code'];
            if(_state){
                let  _est_mensuel    = parseInt(current['est_mensuel']);
                let _montant =  parseFloat(current['montant']);
                let _mensualite = parseFloat(current['mensualite']);

                let  msg = "";
                let  sub_total = 0;
                let  tmp_montant = 0;
                
                // console.log("est_mensuel");
                // console.log(_est_mensuel);

                var _recapitulatif = parseFloat(current['recapitulatif']);
               if(_est_mensuel === 1){
                    _recapitulatif = (isNaN(_recapitulatif))? 0 : _recapitulatif;
                    tmp_montant = _mensualite;
               }else{
                    _recapitulatif = (isNaN(_recapitulatif))? 1 : _recapitulatif;
                    tmp_montant = _montant;
               }

                sub_total = tmp_montant*_recapitulatif;
                msg = _recapitulatif+" * "+tmp_montant+ " = " +sub_total;
                
                $('#COL4-'+_type_pension_code).val(msg);
                
                // console.log(_montant_total);
                // console.log("_montant_total");
                // console.log(_mensualite);
                // console.log("_mensualite");
                // console.log(_recapitulatif);
                // console.log("_recapitulatif");
                _montant_total += sub_total;
            }else{
                $('#COL4-'+_type_pension_code).val("");
            }
        }

        _reduction = parseFloat($(reduction).val());
        _reste = parseFloat($(reste).val());
        _montant_total -= _reduction;
        _montant_total -= _reste;

        // console.log(" reste : "+ _reste);
        // console.log(" reduction : "+ _reduction);
        // console.log(" montant total : "+ _montant_total);

        $(montant).val(_montant_total);
    }

$(document).ready(function(){    

    $(btn_home).hide();
    $(btn_print).hide();

    $(eleve_nom_complet).on("select2:select select2:unselecting", function () {
        $(eleve_nom_complet).select2('data');
        init();
    });

    $(classe).on("select2:select select2:unselecting", function () {
        trigger($(classe).select2().find(":selected").data("id"));
        init();
    });


    $(reduction).on("change paste keyup mouseup", function () {
        if($(reduction).val() < 0)
            $(reduction).val(0);
        init();
    });

    $(reste).on("change paste keyup mouseup", function () {
        if($(reste).val() < 0)
            $(reste).val(0);
        init();
    });

    $(btn_preview).click(function() {
        $(section_versement).hide();
        $(section_recaputilatif).show();
    });

    $(btn_back).click(function() {
        $(section_recaputilatif).hide();
        $(section_versement).show();
    });

    $(btn_save).click(function() { 
        sauvegarderVersement();
    });
    
    init();
    
});
</script>