<?php 

use App\Helpers\Helpers;
    use Core\Routing\URL;
    include dirname(__DIR__)."/_common_lib/_select2_script.php";
?>


<script>
    //Restreindre l'emprunt d'un meme livre
    var mustUpdateX = true
    var mustUpdateY = false
    var exemplaire_disponibles = <?= Helpers::toJSON($exemplaire_disponibles); ?>;
   

    //Initialisation des composant de base
    (function(window, document, $) {
        //'use strict'

        $('#modal-emprunt').on('select2:open', 'select.code-livre', function(){
            mustUpdateY = true
            mustUpdateX = false
        })

        $('#modal-emprunt').on('select2:open', 'select.titre-livre', function(){
            mustUpdateX = true
            mustUpdateY = false
        })

        $('#modal-emprunt').on('change', 'select.code-livre', function(){
            let parent = $(this).parent().parent()
            updateItem(parent, true)
        })

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
        initRepeater()
        resetRepeater()
    })

    function resetRepeater() {
        $('[data-repeater-list]').empty()
        $('[data-repeater-create]').click()
    }

    function initRepeater() {
        items = $('.item-repeater').repeater({
            
            show: function () {
                $(this).slideDown();

                $('.select2-container').remove();

                $('select').select2({
                    width: '100%',
                    // placeholder: "Placeholder text",
                    // allowClear: true
                });

                initItem(this)
                
                $('#modal-emprunt').on('select2:open', 'select.code-livre', function(){
                    mustUpdateY = true
                    mustUpdateX = false
                    
                })

                $('#modal-emprunt').on('select2:open', 'select.titre-livre', function(){
                    mustUpdateX = true
                    mustUpdateY = false
                })
               

                $('#modal-emprunt').on('change', 'select.code-livre', function(){
                    let parent = $(this).parent().parent()
                    updateItem(parent, true)
                })

                $('#modal-emprunt').on('change', 'select.titre-livre', function(){
                    let parent = $(this).parent().parent()
                    updateItem(parent, false)
                })
                
            },
                
            hide: function(remove) {
                if (confirm('Etes vous sûre de supprimer cette élément?')) {
                    $(this).slideUp(remove);
                    // $(this).hide(remove);
                }
            }
        });
    }
    function updateItem(parent, isCode=true){
        let css_class = (isCode)? 'code-livre' : 'titre-livre'
        let selected = parent.find("." + css_class).val()
        console.log(selected)
        if(selected == null) return //aucune valeur selectionnée
        if(exemplaire_disponibles.length === 0) return
        let tmp = exemplaire_disponibles.filter((item)=>{
            return String(item.exemplaire_id) === String(selected)
        })
        let current = tmp[0]
       
        if(isCode){
            if(mustUpdateY){
                parent.find(".titre-livre").val( current.exemplaire_id )
                parent.find(".titre-livre").trigger('change')
            }
        }else{
            if(mustUpdateX){
                parent.find(".code-livre").val( current.exemplaire_id )
                parent.find(".code-livre").trigger('change')
            }
        }

        mustUpdateX = false
        mustUpdateY = false

        parent.find(".etat-livre").val( current.etat_document_id )
        parent.find(".etat-livre").trigger('change')
    }
    
    function initItem(target, isCode = true){
        let parent = $(target)
        updateItem(parent, isCode)
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