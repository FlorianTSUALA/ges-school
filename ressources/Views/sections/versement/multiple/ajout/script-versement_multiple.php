<?php

use App\Helpers\S;
use App\Model\Technique\E;

?>

<script>
    var tranches = []
    var isFirstLoad = true
    var fromInscription = <?= ($this->session->has(S::DATA_TRANSPORT)) ? 'true' : 'false'; ?>

    var type_pension = $('#type_pension')
    var eleve_nom_complet = $('#eleve_nom_complet')
    var classe = $('#classe')
    var statut_apprenant = $('#statut_apprenant')

    var reduction = $('.reduction')
    // var reste = $('#reste')
    var montant = $('#montant')

    var section_versement = $('#section_versement')
    var section_recapitulatif = $('#section_recapitulatif')

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
    var paiement_en_tranche = 0
    var _mensualite = 0
    // var _reduction = 0
    var _reste = 0

    var prix_scolarite_tranche_classe = <?= json_encode($prix_scolarite_tranche_classe) ?>;
    var prix_inscription_tranche_classe = <?= json_encode($prix_inscription_tranche_classe) ?>;
    var prix_abonnement_cantine = <?= json_encode($prix_abonnement_cantine) ?>;
    var prix_abonnement_activite = <?= json_encode($prix_abonnement_activite) ?>;
    var pension_classe = <?= json_encode($pension_classe); ?>;

    console.log('prix_scolarite_tranche_classe')
    console.log(prix_scolarite_tranche_classe)
    console.log('prix_inscription_tranche_classe')
    console.log(prix_inscription_tranche_classe)
    console.log('prix_abonnement_cantine')
    console.log(prix_abonnement_cantine)
    console.log('prix_abonnement_activite')
    console.log(prix_abonnement_activite)
    console.log('pension_classe')
    console.log(pension_classe)
</script>

<script>
    
    function init() {

        if (fromInscription) {
            $(eleve_nom_complet).val("<?= $this->session->get(S::DATA_TRANSPORT, S::VERS_CODE_ELEVE); ?>").trigger('change')
            fromInscription = false;
        }

        if (isFirstLoad) {
            trigger_classe($(classe).select2().find(':selected').data('id'))
            isFirstLoad = false;
        }

        let _montant_total = 0;
        // Pension scolaire
            let i = 0;
            for (var item of items) {
                let _type_pension_id = item['type_pension_code'];
                let _recapitulatif = (isNaN(parseFloat(item['montant_net']))) ? 0 : parseFloat(item['montant_net']);
                $('#COL_RECAPITULATIF_' + _type_pension_id).val(_recapitulatif)
                _montant_total += _recapitulatif;
            }
        // Pension scolaire

        //Autres
            _montant_total += parseFloat(autres['montant_net'])
            $('#COL_RECAPITULATIF_AUTRE').val(autres['montant_net'])
            console.log(_montant_total)
        //Autres

        //Cantines
            cantines['montant'] = prix_abonnement_cantine
            cantines['montant_brut'] = prix_abonnement_cantine
            $('#COL_RECAPITULATIF_CANTINE').val(cantines['montant_net'])
            _montant_total += parseFloat(cantines['montant_net'])
            console.log(_montant_total)

        //Cantines

        //Activite
            $('#COL_RECAPITULATIF_ACTIVITE').val(activites['montant_net'])
            _montant_total += (parseFloat(activites['montant_net']) - parseFloat(_reste))
            console.log(_montant_total)
        //Activite

        //Reuction familiale
            let reduction_familiale = (isNaN($('#RF-reduction').val()) || !$('#RF-reduction').val()) ? 0 : $('#RF-reduction').val()
            _montant_total -= parseFloat(reduction_familiale)
            console.log((reduction_familiale))
            console.log(_montant_total)
            $(montant).val(_montant_total)
        //Reuction familiale

    }

    $(document).ready(function() {

        $(eleve_nom_complet).on("select2:select select2:unselecting", function() {
            $(eleve_nom_complet).select2('data')
            init()
        })

        $(classe).on("select2:select select2:unselecting", function() {
            trigger_classe($(classe).select2().find(":selected").data("id"))
            init()
        })


        // $(reduction).on("change paste keyup mouseup", function() {
        //     if ($(reduction).val() < 0)
        //         $(reduction).val(0)
        //     init()
        // })

        // $(reste).on("change paste keyup mouseup", function () {
        //     if($(reste).val() < 0)
        //         $(reste).val(0)
        //     init()
        // })

        $(btn_preview).click(function() {
            $(section_versement).hide()
            $(section_recapitulatif).show()
        })

        $(btn_back).click(function() {
            $(section_recapitulatif).hide()
            $(section_versement).show()
        })

        $(btn_save).click(function() {
            sauvegarderVersement()
        })

        $(btn_print).click(function() {
            imprimerRecuVersement()
        })
        $(btn_home).hide()
        $(btn_print).hide()

        init()

    })
</script>