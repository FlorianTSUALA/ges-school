<?php

use Core\Routing\URL;
use App\Model\Emprunt;
use App\Helpers\Helpers;
use Config\Invariant\API;
use Core\HTML\Form\InputType;

include dirname(__DIR__)."/_common_lib/_select2_script.php";

?>
<!--
    ******  VARIABLES *****
     $base_route
     $fillables
     $msg_delete
-->


<script> 

  let msg  = 'Bienvenue à la section des paiement cantine'
  block_notification(msg)

        // C:\laragon\www\ges-school\_robust\_Robust\Robust\Robust\app-assets\js\scripts\pickers\dateTime\pick-a-datetime.js
        var filter_by = 'ALL'
        var start_date = moment()
        var end_date = moment()
        var code = ''

        var printCounter = 0
        var table
        var start = moment()
        var end = moment()

        function getDateStart(){
            console.log(start_date.format( 'YYYY-MM-DD  HH:mm:ss.000' ))
            return start_date.format( 'YYYY-MM-DD  HH:mm:ss.000' )
        }
        
        function getDateEnd(){
            console.log(end_date.format( 'YYYY-MM-DD  HH:mm:ss.000' ))
            return end_date.format( 'YYYY-MM-DD  HH:mm:ss.000' )
        }
        
        function init_data_table() {
          // $('#table-emprunt').append('<caption style="caption-side: top-right">Table caption</caption>');

            table = $('#table-emprunt').DataTable({
                //"serverSide": true,
                //Server-side processing is useful when working with large data sets (typically >50'000 records) as it means a database engine can be used to perform the sorting etc calculations - operations that modern database engines are highly optimised for, allowing use of DataTables with massive data sets (millions of rows).
                ajax:{
                    url: '<?= URL::link('biblio_api_emprunt_liste') ?>',
                    data: function(data){
                        data.code =  code,
                        data.filter_by = filter_by,
                        data.start_date = start_date.format( 'YYYY-MM-DD  HH:mm:ss.000' ),
                        data.end_date = end_date.format( 'YYYY-MM-DD  HH:mm:ss.000' )
                    } ,
                    type: 'POST'
                },
                "columns": [<?= Emprunt::getColumns() ?>],
                "columnDefs": [
                  {
                    targets: 0,
                    visible: false
                  },         
                  {
                    targets: 1,
                    visible: false
                  },         
                  {
                    targets: -2,
                    visible: false
                  },         
                  {
                    targets: -3,
                    visible: false
                  },
                  {
                  "targets": -1,
                  "data": null,
                  "render": function(data, type, full, meta){ 
                      console.log(data);
                        return '<span class="dropdown">  '+
                                    '<button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="fa fa-cog"></i></button> <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">  ' +
                                    '<a href="#" class="dropdown-item action action-voir" data-action="action-voir"  data-id="'+data.id+'"  ><i class="ft-eye"></i> voir</a>' +
                                    '<a href="#" class="dropdown-item action action-modifier" data-action="action-modifier"  data-id="'+data.id+'"  ><i class="ft-edit-2"></i> modifier</a>' +
                                    '<a href="#" class="dropdown-item action action-restituer" data-action="action-restituer"  data-id="'+data.id+'"  ><i class="ft-check"></i> restituer</a>' +
                                    '<a href="#" class="dropdown-item action action-reemprunter" data-action="action-reemprunter"  data-id="'+data.id+'"  ><i class="ft-upload"></i> re-emprunter</a>' +
                                    '<a href="#" class="dropdown-item action action-supprimer" data-action="action-supprimer"  data-id="'+data.id+'"  ><i class="ft-trash"></i> supprimer</a>  </span> </span>' 
                    }
                  // "defaultContent": "
                  // '<span class="dropdown">  '+
                  // '<button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="fa fa-cog"></i></button> <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">  ' +
                  // '<a href="#" class="dropdown-item action action-voir" data-action="action-voir"  data-id="action-voir"  ><i class="ft-eye"></i> voir</a>' +
                  // '<a href="#" class="dropdown-item action action-modifier" data-action="action-modifier"  data-id="action-modifier"  ><i class="ft-edit-2"></i> modifier</a>' +
                  // '<a href="#" class="dropdown-item action action-restituer" data-action="action-restituer"  data-id="action-restituer"  ><i class="ft-check"></i> restituer</a>' +
                  // '<a href="#" class="dropdown-item action action-reemprunter" data-action="action-reemprunter"  data-id="action-reemprunter"  ><i class="ft-upload"></i> re-emprunter</a>' +
                  // '<a href="#" class="dropdown-item action action-supprimer" data-action="action-supprimer"  data-id="action-supprimer"  ><i class="ft-trash"></i> supprimer</a>  </span> </span>"' 
                }
              ],
              "createdRow": function(row, data, index) {
                    // if (data[2] * 1 < 9000) 
                    {
                      // console.log(data.date_expiration)
                      let date_emprunt = new Date(data.date_emprunt).toLocaleDateString(window.navigator.language, {year: 'numeric',month: 'long',day: 'numeric',});
                      let date_expiration = new Date(data.date_expiration).toLocaleDateString(window.navigator.language, {year: 'numeric',month: 'long',day: 'numeric',});
                        //  console.log(date_expiration);
                        $('td', row).eq(3).text( date_emprunt );
                        $('td', row).eq(4).text( date_expiration );
                    }
                },
                "fnDrawCallback": function( oSettings ) {
                    // $('#table-emprunt').append('<caption style="caption-side: top-right">Table caption</caption>');
                },
                "destroy" : true,
                dom: 'Blfrtip',
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tout"]],
                stateSave: true,
              <?= Helpers::dataTableCommunOptions() ?>
               
            })


            $('#table-emprunt tbody').on( 'click', 'a.action', function () {
                var id = $(this).data('id');
                var action = $(this).data('action');
                console.log(id)
                console.log(action)
                var data = table.row( $(this).parents('tr') ).data()
                console.log(data)
                // let id = data.id
                let num = data.num
                let code_enregistrement = data.code_enregistrement
                let titre = data.titre
                let eleve = data.eleve
                let date_emprunt = data.date_emprunt
                let date_expiration = data.date_expiration
                let classe = data.classe
                let etat_document = data.etat_document

                switch(action){
                  case 'action-voir':
                      $('#modal-restitution').modal('show')
                    break;
                  case 'action-modifier':
                    $('#modal-restitution').modal('show')
                    break;
                  case 'action-restituer':
                    $('#modal-restitution').modal('show')
                    break;
                  case 'action-reemprunter':
                    $('#modal-restitution').modal('show')
                    break;
                  case 'action-supprimer':
                    $('#modal-restitution').modal('show')
                    break;
                }

                // alert( id, num, code_enregistrement, titre, eleve, date_emprunt, date_expiration, classe, etat_document )
            } )


            //Reload table data every 30 seconds (paging retained):
            setInterval( function () {
                table.ajax.reload( null, false ); // user paging is not reset on reload
            }, 5550000 );
        }


    (function(window, document, $){

    	// Localization
      $('.localeRange').daterangepicker({
        singleDatePicker: true,
        // ranges: {
        //   "Aujourd'hui": [moment(), moment()],
        //   'Hier': [moment().subtract('days', 1), moment().subtract('days', 1)],
        //   'Demain': [moment().add(1, 'days'), moment().add(1, 'days')],
        //   'Les 7 derniers jours': [moment().subtract('days', 6), moment()],
        //   'Les 7 prochains jours': [moment(), moment().add('days', 6)],
        //   'Les 30 derniers jours': [moment().subtract('days', 29), moment()],
        //   'Ce mois-ci': [moment().startOf('month'), moment().endOf('month')],
        //   'le mois dernier': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
        // },
        locale: {
          applyLabel: "Chercher",
          cancelLabel: 'Annuler',
          startLabel: 'Date initiale',
          endLabel: 'Date limite',
          customRangeLabel: 'Sélectionner une date',
          // daysOfWeek: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi','Samedi'],
          daysOfWeek: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve','Sa'],
          monthNames: ['Janvier', 'février', 'Mars', 'Avril', 'Маi', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
          firstDay: 1,
          format: 'DD-MM-YYYY'
        },

      // Max and Min date
      min: [2019,8,20],
      max: [2022,10,30],
        
      // Using Javascript
      // min: new Date(2015,3,20,7),
      // max: new Date(2015,7,14,18,30)

      // formatSubmit: 'dd/mm/yyyy',
      //Buttons class
      drops: "down",
      buttonClasses: "btn",
      applyClass: "btn-info",
      cancelClass: "btn-danger",

      //Events
      onStart: function() {
        console.log('pro - - - > Hi there!!!')
      },
      onRender: function() {
        console.log('pro - - - > Holla... rendered new')
      },
      onOpen: function() {
        console.log('pro - - - > Picker Opened')
      },
      onClose: function() {
        console.log("pro - - - > I'm Closed now")
      },
      onStop: function() {
        console.log('pro - - - > Have a great day ahead!!')
      },
      onSet: function(context) {
        console.log('pro - - - > All stuff:', context)
      }
  }, cb)

  init_data_table()
  
  function cb(start, end) {
    $('#resume_filtre').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    start_date = start
    end_date = end
    console.log(start_date.format( 'YYYY-MM-DD  HH:mm:ss.000' ))         
    console.log(end_date.format( 'YYYY-MM-DD  HH:mm:ss.000' ))         
    table.ajax.reload()
    // table.ajax({
    //               url: '<?= URL::link('cantine_abonnement_info') ?>',
    //               data: {
    //                   'code':  code,
    //                   'filter_by': filter_by,
    //                   'start_date': start_date,
    //                   'end_date': end_date
    //               },
    //               type: 'POST'
    //             })
    // table.ajax.url( "<?= URL::link('cantine_abonnement_info')?>?code="+code+"&filter_by="+filter_by+"&start_date="+start_date.format( 'YYYY-MM-DD  HH:mm:ss.000' )+"&end_date="+end_date.format( 'YYYY-MM-DD  HH:mm:ss.000' ) ).load()
}

  })(window, document, jQuery)
</script>



<script>
    // https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_active_element
    // Add active class to the current menu item (highlight it)
    var menu = document.getElementById("menu");
    var links = menu.getElementsByClassName("list-group-item");


    for (var i = 0; i < links.length; i++) {
        links[i].addEventListener('click', function() {
            var current = document.getElementsByClassName('active')
            if (current.length > 0) { 
                current[0].className = current[0].className.replace(' active', '')
            }
            this.className += ' active'
            if(this.id.includes('ID_')){
                let current_id = this.id.replace('ID_', '')
                if(current_id.includes('DOCU'))
                filter_by ='DOCUMENT'
                else
                filter_by = 'DOMAINE'
                code  =  current_id
            }else{
                filter_by = 'ALL'
                code = ''
            }

            start_date = moment()
            end_date = moment()
            // alert(code)
            table.ajax.reload()
        })
    }
    
    
    window.setInterval(function (){
      table.ajax.reload()
        }, <?= API::REALTIME_TIME_RECENT_TRANSACTION ?>);
</script>


<script>
   // Edit record
   $('#example').on('click', 'a.editor_edit', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        editor.edit( $(this).closest('tr'), {
            title: 'Edit record',
            buttons: 'Update'
        } );
        $('#modal-restitution').modal('show')
    } );
 
    $('#example tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        alert( data[0] +"'s salary is: "+ data[ 5 ] );
    } );

</script>


<script>
      // FOR SEARCH MENU

      function searchMenu(list) {
      
        // https://jsfiddle.net/sofoklis_stouraitis/zLzfpb1u/8/
        // https://stackoverflow.com/questions/2487747/selecting-element-by-data-attribute-with-jquery
        // https://www.w3schools.com/jquery/traversing_closest.asp
        // https://stackoverflow.com/questions/10260667/jquery-get-parent-parent-id
        // bonus https://codepen.io/CodifyAcademy/pen/wzBmXL


        var input = $(".menu-search");
        $(input)
        .change( function () {
          var filter = $(this).val().toUpperCase();
          if(filter) {
            let li = $(list).find("li a");
            for (i = 0; i < li.length; i++) {
              a = li[i]
              if (a.innerText.toUpperCase().indexOf(filter) > -1) {
                
                $(a).parent().children('a').show()
                if($(a).closest('div').hasClass('collapse')){

                  $(a).closest('div').addClass(' show')
                  let id = $(a).closest('div').attr('id')
                  $('[data-target="#'+id+'"]').show()

                }

              } else {
                $(a).parent().children('a').hide()
              }

            }
            
            // not_contains = $(list).find("li a:not(:Contains(" + filter + "))").hide();
            // console.log(not_contains)
            // return
            
            // not_contains.hide().parent().hide()
            // $(list).find("li a:Contains(" + filter + ")").show().parents('li').show().addClass('open').closest('li').children('a').show();
            var searchFilter = $(list).find("li a:Contains(" + filter + ")");
            if( searchFilter.parent().hasClass('has-sub') ){
              searchFilter.show()
              .parents('li').show()
              .addClass('open')
              .closest('li')
              .children('a').show()
              .children('li').show();
              alert('has')
              // searchFilter.parents('li').find('li').show().children('a').show();
              if(searchFilter.siblings('ul').length > 0){
                searchFilter.siblings('ul').children('li').show().children('a').show();
              }
      
            }
            else{
              searchFilter.show().parents('li').show().addClass('open').closest('li').children('a').show();
            }

          } else {
            // return to default
            console.log($('#menu').find("li > a"))
            // $('#menu>li a').hide()
            $('#menu').find("li > a").hide()
            // $('[data-parent="#menu"]').show()
               $('#menu div li a').show()
               $('#menu div div').removeClass('show')

          //--   $('.navigation-header').show();
            // $(list).find("li a").show().parent().show().removeClass('open');
            // alert('empty')
          }
          // $.app.menu.manualScroller.update();
          return false;
        })
        .keyup( function () {
            // fire the above change event after every letter
            $(this).change();
        });
    
      }
      searchMenu('#menu')

</script>
