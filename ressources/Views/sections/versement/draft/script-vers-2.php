<?php
    use App\Helpers\HTMLHelper;
?>

<script>
     var type_pension_classe = <?= $pension_classe; ?>;
    console.log(type_pension_classe);

    function formateleve (eleve) {
        console.log(eleve);
        if (!eleve.id) {
            return eleve.text;
        }
        var matricule = eleve.matricule;
        var nom = eleve.nom;
        var prenom = eleve.prenom;
        var date_naissance = eleve.date_naissance;
        var lieu_naissance = eleve.lieu_naissance;
        //
        var $eleve = $(
            '<span> ' + nom.toUpperCase() + ' ' + prenom + ' : ' + date_naissance + ' : ' + matricule + '</span>'
        );
        return $eleve;
    };

    $(".js-example-templating").select2({
    
    });

    $(document).ready(function(){
        $(".select2-selection span").attr('title', '');

         $('.select2').each(function() { 
              $(this).select2({ dropdownParent: $(this).parent()});
         });

    });
</script>

<script>
   var prix_unitaire = $_provide_mensualite;
    var tranches = [];

    var mensualite = $_provide_mensualite;

    var tranche_sco = $('#tranche_scolaire');
    var quantite = $('#quantite');
    var remise = $('#remise');
    var reduction = $('#reduction');
    var reste = $('#reste');
    var qte = $('#qte');
    var mois = $('#mois');
    var total_mensualite = $('#total_mensualite');
    var nbre_mensualite = $('#nbre_mensualite');
    var montant = $('#montant');

    var section_versement = $('#section_versement');
    var section_recaputilatif = $('#section_recaputilatif');
    
    var label_type = $('#label_type');
    var type = $('#type');

    var btn_preview = $('#btn_preview');
    var btn_save = $('#btn_save');
    var btn_home = $('#btn_home');
    var btn_back = $('#btn_back');
    var btn_print = $('#btn_print');
    
    var live_search_card_detail = $('#live_search_card_detail');
    var live_search_card_result = $('#live_search_card_result');

    $(section_recaputilatif).hide();

    function updateTotal(){
        var size = tranches.length;
        //if(type.val == )
        var size = tranches.length;
        $(total_mensualite).text(size*mensualite);
        $(nbre_mensualite).text(size);
        $(montant).val(size*mensualite);

    }

    $(tranche_sco).change(function() {
        $(tranche_sco).select2('data');
        var elements = JSON.parse( JSON.stringify($(tranche_sco).select2('data')));
        tranches = [];
        elements.forEach(function(element){
            var row = [];
            row['id'] = element.id;
            row['value'] = element.text;
            tranches.push(row);
        });
        console.log(tranches);
        updateTotal();
    });

    $(remise).change(function() {
        var size = tranches.length;
        $(total_mensualite).text(size*mensualite);
        $(nbre_mensualite).text(size);
        $(montant).val(size*mensualite);
    });
    

    $(reduction).change(function() {
        var size = tranches.length;
        $(total_mensualite).text(size*mensualite);
        $(nbre_mensualite).text(size);
        $(montant).val(size*mensualite);
    });

    $(btn_preview).click(function() {
        $().hide();
        $().show();
    });

    $(btn_back).click(function() {
        $().hide();
        $().show();
    });

    $(btn_print).click(function() {
        $().hide();
        $().show();
    });

    $(btn_save).click(function() {
        $().hide();
        $().show();
    });

</script>


<script>
    $(document).ready(function(){
        // Show form
        //var form = $("#form-inscription").show();

        form.validate({
            rules: {
                nom_eleve: "required",
                lieu_naissance_eleve: "required",
                date_naissance_eleve: "required",
                sexe_eleve: "required",
                pays_eleve: "required",
                classe_eleve: "required",
                statut_apprenant_eleve: "required",
            },
            messages: {
                nom_eleve: {
                    required: "Ce champs est obligatoire !",
                },
                lieu_naissance_eleve: {
                    required: "Ce champs est obligatoire !",
                },
                date_naissance_eleve: {
                    required: "Ce champs est obligatoire !",
                },
                sexe_eleve: {
                    required: "Ce champs est obligatoire !",
                },
                pays_eleve: {
                    required: "Ce champs est obligatoire !",
                },
                classe_eleve: {
                    required: "Ce champs est obligatoire !",
                },
                statut_apprenant_eleve: {
                    required: "Ce champs est obligatoire !",
                },
            },
        });
    
    
        $('#recap-email').text($('#email').val()? $('#email').val():'<?= HTMLHelper::repeatChar();?>');
                
        
        $('#recap-pays_eleve').text($('#pays_eleve :selected').val()? $('#pays_eleve :selected').val() : '<?= HTMLHelper::repeatChar();?>');
        $('#recap-groupe_sanguin').text($('#groupe_sanguin :selected').val()? $('#groupe_sanguin :selected').val() : '<?= HTMLHelper::repeatChar();?>');
        
        $('#recap-sexe_eleve').text($('input[type=radio][name=sexe_eleve]:checked').val()? $('input[type=radio][name=sexe_eleve]:checked').val() : '<?= HTMLHelper::repeatChar();?>');
        
        form.validate().settings.ignore = ":disabled,:hidden";
    });

</script>