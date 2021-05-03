<?php
    use Core\Routing\URL;
?>

<script>
    var duallistboxDynamic
    /**
     * item = {classe, salle, eleves[Affecté et Non Affecté]}
     */
    function buildCard(item){
        
        let classe = item.classe
        let eleve_non_affecte = item.eleve_non_affecte
        let eleve_affecte = item.eleve_affecte  
        let salle_classes = item.salle_classes  

        let sections = " "

        if(eleve_affecte.length === 0){
            if(salle_classes.length === 0){
                //Pas de salle de classe associée à cette classe
                let salle_classe_code = "none" 
                let salle_classe = "-----------------------" 
                let animation = getRandomAnimation()
                sections += ' '+
                ' <section class="row with-custom-options '+ salle_classe_code +' "> <div class="col-12">'+
                '   <div class="card"  data-appear="appear" data-animation="'+animation+'">'+
                '    <div class="card-header">'+
                '        <h4 class="card-title"> Affectation Impossible pour le classe : '+ classe +'  </h4>'+
                '        <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>'+
                '        <div class="heading-elements">'+
                '            <ul class="list-inline mb-0">'+
                '                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>'+
                '                <li><a data-id="'+ salle_classe_code +'" data-action="reload"><i class="ft-rotate-cw"></i></a></li>'+
                '                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>'+
                '                <!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->'+
                '            </ul>'+
                '        </div>'+
                '    </div>'+
                '    <div class="bs-callout-pink callout-border-right callout-round callout-transparent py-1 pl-2 mr-5  pr-4 mb-2 ">'+
                '       <div class="media align-items-stretch ml-1">'+
                '           <div class="media-left d-flex align-items-center bg-pink callout-arrow-left position-relative p-2">'+
                '               <i class="fa fa-bullseye white font-medium-5"></i>'+
                '           </div>'+
                '           <div class="media-body p-1">'+
                '               <strong>La classe <code> '+classe+' </code> ne possede pas de salle de classe !!!</strong>'+
                '               <p class="mt-1">Veuillez creer des creer des salles de classes pour cette classe.</p>'+
                '           </div>'+
                '       </div>'+
                '    </div>'+
                '   </div>'+
                '</div> </section>'

            }else{
                //Pas d'affectation encore realisée pour la salle de classe en question
                alert('Cas déja geré; Contactez votre administrateur </>');
            }
        }else{

            for(let i = 0; i <eleve_affecte.length; i++){
                let item = eleve_affecte[i]

                let salle_classe = item.salle_classe
                let salle_classe_code = item.salle_classe_code
                let eleves = item.eleves

                let tmp = buildSection(classe, salle_classe, salle_classe_code, eleves, eleve_non_affecte)

                sections += (" " + tmp)
            }
        }
        console.log(sections)
        return sections
    }


    function buildSection(classe, salle_classe, salle_classe_code, eleve_affecte, eleve_non_affecte){
        let animation = getRandomAnimation()
        let html = " "+
            ' <section class="row with-custom-options '+ salle_classe_code +'"> <div class="col-12">'+
                '<div class="card"  data-appear="appear" data-animation="'+animation+'">'+
                '    <div class="card-header">'+
                '        <h4 class="card-title">Affectation  '+ classe +' - '+ salle_classe +' </h4>'+
                '        <a class="heading-elements-toggle"><i class="ft-ellipsis-h font-medium-3"></i></a>'+
                '        <div class="heading-elements">'+
                '            <ul class="list-inline mb-0">'+
                '                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>'+
                '                <li><a data-id="'+ salle_classe_code +'" data-action="reload"><i class="ft-rotate-cw"></i></a></li>'+
                '                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>'+
                '                <!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->'+
                '            </ul>'+
                '        </div>'+
                '    </div>'+
                '    <div class="card-content">'+
                '        <div class="card-body">'+
                '            <div class="form-group">'+
                '                <select name="'+salle_classe_code+'" multiple="multiple" size="10" class="duallistbox-dynamic">'

                for(let i = 0; i <eleve_affecte.length; i++){
                    let eleve = eleve_affecte[i];
                    let code = eleve.eleve_code
                    let nom_complet = eleve.nom_complet
                    html += '                   <option value="'+  code +'" selected="selected"> '+ nom_complet +' </option>'
                }

                for(let i = 0; i <eleve_non_affecte.length; i++){
                    let eleve = eleve_non_affecte[i];
                    let code = eleve.eleve_code
                    let nom_complet = eleve.nom_complet
                    html += '                   <option value="'+  code +'" > '+ nom_complet +' </option>'
                }
       

                html +=
                '                </select>'+
                '            </div>'+
                '            <div class="buttons block">'+
                '                <button data-id="'+ salle_classe_code +'" data-action="refresh" type="button" class="btn btn-info duallistbox-refresh">Actualiser</button>'+
                '                <button data-id="'+ salle_classe_code +'" data-action="cancel" type="button" class="btn btn-warning duallistbox-cancel">Annuler</button>'+
                '                <button data-id="'+ salle_classe_code +'" data-action="save" type="button" class="btn btn-primary duallistbox-save">Enregistrer</button>'+
                '            </div>'+
                '            <p class="mt-1">Cette section vous permet de définir des affectations. <code> <strong>Actauliser</strong></code> pour avoir l\'état recent des élèves dans le sytème.</p>'+
                '        </div>'+
                '    </div>'+
                '</div>'+
            '</div> </section>'

            return html
    }


    function apiSaveAffectationSalleClasseAffectation(salle_classe_code, affectations, desaffectations){
        let data = {}
        data.salle_classe_id = salle_classe_code
        data.affectations = affectations
        data.desaffectations = desaffectations

        // console.log(data)

       $.ajax({
            url: '<?= URL::link('api_save_affectation_eleve_salle_classe') ?>',
            type: 'post',
            data: data,
            dataType: 'json',
        
            success:function(data){
                // console.log(data)
                let html = ''
                for(var i = 0; i <data.length; i++) {
                    html += ' '
                    html += ' '
                    html += ' '
                    html += buildCard(data[i])
                }
                console.log(html)
                $('section.'+salle_classe_code).replaceWith(html)
                initDualList()
            },
            error: function (textStatus, errorThrown) {
                Success = false;
                console.log(textStatus, errorThrown);
            }, 
            complete: function(data) {

            }
        }) 
    }

    function apiRefreshCardSalleClasseAffectation(salle_classe_code){
        let data = {}
        data.salle_classe_id = salle_classe_code

        // console.log(data)

       $.ajax({
            url: '<?= URL::link('api_info_affectation_eleve_salle_classe') ?>',
            type: 'post',
            data: data,
            dataType: 'json',
        
            success:function(data){
                // console.log(data)
                let html = ''
                for(var i = 0; i <data.length; i++) {
                    html += ' '
                    html += ' '
                    html += ' '
                    html += buildCard(data[i])
                }
                console.log(html)
                $('section.'+salle_classe_code).replaceWith(html)
                initDualList()
            },
            error: function (textStatus, errorThrown) {
                Success = false;
                console.log(textStatus, errorThrown);
            }, 
            complete: function(data) {

            }
        }); 
    }

    function apiCall(){
        //jQuery > 1.4.3
        let id  = $('#menu .list-group a.list-group-item.active').attr("id")
        if(id.includes('ID_'))
            classe_id = id.replace('ID_', '')
        
        let data = {}
        if(classe_id === 'ALL'){
            data.classe_id = null
        }else{
            data.classe_id = classe_id
        }

        // console.log(data)

       $.ajax({
            url: '<?= URL::link('api_info_affectation_eleve') ?>',
            type: 'post',
            data: data,
            dataType: 'json',
        
            success:function(data){
                // console.log(data)
                let html = ''
                for(var i = 0; i <data.length; i++) {
                    html += ' '
                    html += ' '
                    html += ' '
                    html += buildCard(data[i])
                }

                $('.content-body').html(html)

                initDualList()
            },
            error: function (textStatus, errorThrown) {
                Success = false;
                console.log(textStatus, errorThrown);
            }, 
            complete: function(data) {

            }
        }); 
    }

    function initDualList(){
          // Add dynamic Option
            duallistboxDynamic = $('.duallistbox-dynamic').bootstrapDualListbox({
            moveOnSelect: false,
            selectorMinimalHeight: 250,

              // default text
                filterTextClear: 'voir tout',
                filterPlaceHolder: 'Entrer un mot pour filtrer',
                moveSelectedLabel: 'Déplacer la sélection',
                moveAllLabel: 'Déplacer tout',
                removeSelectedLabel: 'Supprimer la sélection',
                removeAllLabel: 'Supprimer tout',

                // text when all options are visible / false for no info text                      
                infoText: 'Element(s) affiché(s) : {0}',               

                // when not all of the options are visible due to the filter                                         
                infoTextFiltered: '<span class="badge badge-warning">Filtré </span> {0} à {1}', 

                // when there are no options present in the list
                infoTextEmpty: 'Liste vide',     
                
                
            // filterTextClear : "Show All Options",
            // filterPlaceHolder: "Filter Options",
            // infoText: 'Showing {0} Option(s)',
            // infoTextFiltered: '<span class="badge badge-info">Filtered List</span> {0} from {1}',
            // infoTextEmpty: 'No Options Listed',
            
        });
    }

</script>


