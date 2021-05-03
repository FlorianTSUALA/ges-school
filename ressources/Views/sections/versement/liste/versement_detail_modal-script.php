<?php 

use App\Helpers\Helpers;
    use Core\Routing\URL;
    // include dirname(__DIR__)."/_common_lib/_select2_script.php"; 
?>


<script>
    //Restreindre l'emprunt d'un meme livre
    var mustUpdateX = true
    var mustUpdateY = false
    var exemplaires = <?= Helpers::toJSON($exemplaires??[]); ?>;
   

    //Initialisation des composant de base
    (function(window, document, $) {
      

        $('#modal-emprunt').on('change', 'select.titre-livre', function(){
            let parent = $(this).parent().parent()
            updateItem(parent, false)
        })


        let target = $('.code-livre').parent().parent()
        initItem(target)

        // target = $('.titre-livre').parent().parent()
        // initItem(target)

        // target = $('.etat-livre').parent().parent()
        // initItem(target)

    })(window, document, jQuery)

    var items = []

    $(document).ready(function () {

        $(document).on('click', '#modal-emprunt-save', function(e) {
                e.preventDefault();
                saveEmprunt();
        })
        
        // Custom Show / Hide Configurations
        //-*- initRepeater()
        //-*- resetRepeater()
    })


 

    
    function initItem(target, isCode = true){
        let parent = $(target)
        //-*- updateItem(parent, isCode)
    }


    function updateSelectItem(){

    }

    function saveEmprunt(){
        let livres = {}

        items = $('.item-repeater').repeaterVal()['data']
        for (index = 0; index < items.length; index++){
            let tmp = {}
            tmp['code_livre'] = items[index].code_livre
            tmp['etat_livre'] = items[index].etat_livre
            livres[index] = tmp
        }
       
        data = {
                "nom":  $('#emprunt option:selected').text(),
                'id_eleve':  $('#emprunt option:selected').val(),
                'livres':  livres,
                'date_emprunt': $('#date_emprunt').val(),
                'date_retour': $('#date_retour').val()
        }

        console.log(data)

        $.blockUI({
            message: '<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Enregistrement en cours ...</div>',
            fadeIn: 1000,
            timeout: 10000, //unblock after 2 seconds
            overlayCSS: {
                backgroundColor: '#FFF',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: '10px 15px',
                color: '#fff',
                width: 'auto',
                left: '45%',
                backgroundColor: '#333'
            },
            onBlock: function() {
                $.ajax({
                    url: '<?= URL::link('biblio_api_emprunt_save');?>',
                    type: 'post',
                    data: data,
                    dataType: 'json',
                  
                    success:function(data){
                        
                        $("#form-emprunt").trigger("reset")
                        $('#form-emprunt')[0].reset()
                        $('#modal-emprunt').modal('hide')

                        resetRepeater()

                        flash_msg(data, 6)

                        console.log(data)

                    },
                    error: function (textStatus, errorThrown) {
                        Success = false;
                        console.log(textStatus, errorThrown);
                    }
                });               
            }
        });
    }

</script>