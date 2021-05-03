<?php

use Core\Routing\URL;
    use App\Helpers\HTMLHelper;
?>

<script>
    var type_pension_classe = <?= $pension_classe; ?>;
    console.log(type_pension_classe);

    $(document).ready(function(){
        // $(".select2-selection span").attr('title', '');

        $('.select2').each(function() { 
            $(this).select2({ dropdownParent: $(this).parent()});
        });

    });

</script>

<script>
    var tranches = [];


    var tranche_sco = $('#tranche_scolaire');
    var type_pension = $('#type_pension');
    var eleve_nom_complet = $('#eleve_nom_complet');
    var classe = $('#classe');
   
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
    
    var eleve_id;
    var eleve_matricule;
    var classe_id;
    var type_pension_id;
    var _montant = 0;
    var _est_mensuel = 0;
    var _mensualite = 0;
    var _reduction = 0;
    var _reste = 0;
    var _nbre_unite = 0;
    var _montant_final = 0;
    
    $(section_recaputilatif).hide();
    $(btn_home).hide();
    $(btn_print).hide();

    function updateTotal(){
        var _nbre_unite = tranches.length;
        __reduction = $(reduction).val();

        $(total_mensualite).text(_montant);
        $(nbre_mensualite).text(_nbre_unite);
        $(montant).val(_montant_final);
    }

    function init(){
        eleve_matricule = $(eleve_nom_complet).select2().find(":selected").data("matricule");
        eleve_id = $(eleve_nom_complet).select2().find(":selected").data("id");
        classe_id = $(classe).select2().find(":selected").data("id");
        type_pension_id = $(type_pension).select2().find(":selected").data("id");
        
        _reduction = $(reduction).val();

        console.log(eleve_matricule);
        console.log(eleve_id);
        console.log(classe_id);
        // updateTotal();
        retrieveMoreInfo();
    }

    $(tranche_sco).on("select2:select select2:unselecting", function () {
        $(tranche_sco).select2('data');
        var elements = JSON.parse( JSON.stringify($(tranche_sco).select2('data')));
        tranches = [];
        elements.forEach(function(element){
            var row = [];
            row['id'] = element.id;
            row['value'] = element.text;
            tranches.push(row);
        });
        
        _nbre_unite = tranches.length;
        init();
    });

    $(eleve_nom_complet).on("select2:select select2:unselecting", function () {
        $(eleve_nom_complet).select2('data');
        init();
    });

    $(classe).on("select2:select select2:unselecting", function () {
        $(classe).select2('data');
        init();
    });

    $(type_pension).on("select2:select select2:unselecting", function () {
        $(type_pension).select2('data');
        init();
    });
   

    $(reduction).on("select2:select select2:unselecting", function () {
        $(reduction).select2('data');
        init();
    });

    
    function retrieveMoreInfo(){
        type_pension_classe.forEach(function(item){
            
            if(item.type_pension == type_pension_id && item.classe == classe_id){
                _montant = item.montant;
                _est_mensuel = item.est_mensuel;
                _mensualite = item.mensualite;
                console.log(" est_mensualite : "+ _est_mensuel);
                console.log(_montant);

                return item;
            }else{
                // $('#qte').show();
                // $('#mois').hide();
                document.getElementById('mois').style.display = 'none';
                document.getElementById('qte').style.display = 'block';
            }
        });

        if(_est_mensuel == 1)
        {
            // $('#qte').show();
            // $('#mois').hide();
            console.log(" EEEEEE : "+ _est_mensuel);

            document.getElementById('qte').style.display = 'none';
            document.getElementById('mois').style.display = 'block';
        }
        else
        {
            // $('#qte').hide();
            // $('#mois').show();
            console.log(" est_mensualite : "+ _est_mensuel);
            document.getElementById('mois').style.display = 'none';
            document.getElementById('qte').style.display = 'block';
            console.log(" mensualite : "+ _mensualite);
            
        }
    }


    
    $(btn_preview).click(function() {
        $(section_versement).hide();
        $(section_recaputilatif).show();
    });

    $(btn_back).click(function() {
        $(section_recaputilatif).hide();
        $(section_versement).show();
    });

    // $(btn_print).click(function() {
    //     $().hide();
    //     $().show();
    // });

    // $(btn_save).click(function() {
    //     $().hide();
    //     $().show();
    // });
    init();
</script>


<script>
    $(document).on('click', '#btn_save', function(e)
    {  
        e.preventDefault();
        form = $('#form_versement')[0];
        if (form.checkValidity() === true) {
            form = $('#form_versement');
            $.ajax({  
                    url: "<?= URL::link('accueil'); ?>",  
                    method: "POST",  
                    data: form.serialize(),  
                    beforeSend:function(){
                        $('#button-form-create').hide();  
                        $('#loading').show();
                    },  
                    success:function(data){ 
                        form[0].reset();  
                        $('#button-form-create').show();  
                        $('#upt-loading').hide();

                        $('#modal-create').modal('hide');  
                        $('#data-table').html(data);  
                    }, 
                    error: function (textStatus, errorThrown) {
                        Success = false;
                    }
            });  
        }else{
            e.stopPropagation();
            form.classList.add('was-validated'); 
        }
    });
    
    function sauvegarderVersement(){
        $.ajax({
            url: '<?= URL::link('eleve_search_info');?>',
            type: 'post',
            data: {search:search},
            dataType: 'json',
            success:function(response){
            
                var len = response.length;
                $("#live_search_card_result").empty();
                for( var i = 0; i<len; i++){
                    var id = response[i]['id'];
                    var nom = response[i]['nom'];
                    var classe = response[i]['classe'];
                    var date_naissance = response[i]['date_naissance'];
                    var lieu_naissance = response[i]['lieu_naissance'];

                    $("#live_search_card_result").append("<li value='"+id+"'>"+name+"</li>");

                }

                // binding click event to li
                $("#live_search_card_result li").bind("click",function(){
                    setText(this);
                });

            }
        });
    }


    $(document).ready(function(){
        // Show form
        //var form = $("#form-inscription").show();
    /*
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
    */
    
        // $('#recap-email').text($('#email').val()? $('#email').val():'<?= HTMLHelper::repeatChar();?>');
                
        
        // $('#recap-pays_eleve').text($('#pays_eleve :selected').val()? $('#pays_eleve :selected').val() : '<?= HTMLHelper::repeatChar();?>');
        // $('#recap-groupe_sanguin').text($('#groupe_sanguin :selected').val()? $('#groupe_sanguin :selected').val() : '<?= HTMLHelper::repeatChar();?>');
        
        // $('#recap-sexe_eleve').text($('input[type=radio][name=sexe_eleve]:checked').val()? $('input[type=radio][name=sexe_eleve]:checked').val() : '<?= HTMLHelper::repeatChar();?>');
        
        //form.validate().settings.ignore = ":disabled,:hidden";
    });

</script>