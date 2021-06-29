<?php

use Core\Routing\URL;
use App\Model\Emprunt;
use App\Model\Eleve;
use App\Helpers\Helpers;
use Config\Invariant\API;

?>
<!--
    ******  VARIABLES *****
     $base_route
     $fillables
     $msg_delete
-->


<script>

  let msg  = 'Bienvenue à la section versement'

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

            table = $('#table-versements').DataTable({
                scrollX: true,
                paging: true,
                // responsive: true,
                //"serverSide": true,
                //Server-side processing is useful when working with large data sets (typically >50'000 records) as it means a database engine can be used to perform the sorting etc calculations - operations that modern database engines are highly optimised for, allowing use of DataTables with massive data sets (millions of rows).
                ajax:{
                    url: '<?= URL::link('versement-list_all') ?>',
                    data: function(data){
                      console.log(data)
                        data.code =  code,
                        data.filter_by =  filter_by
                    } ,
                    type: 'POST'
                },
                "columns": [<?= Eleve::getColumns() ?>],
                fixedColumns: true,
              "columnDefs": [
                {
                  "targets": 0,
                  width: '5%',
                  "searchable": false,
                  // "orderable": false,
                  "class": "index",

                },

                {
                  "targets": -1,
                  width: '7%',
                  "data": null,
                  "render": function(data, type, full, meta){
                      // console.log(data);
                        return  ' '+
                                ' <div class="btn-group" role="group" aria-label="Basic example"> '+
                                '      <button type="button" data-action="action-voir" class="action btn btn-sm btn-icon btn-primary mr-0" title="voir"><i class="ft-eye"></i></button> '+
                                '      <button type="button" data-action="action-modifier" class="action btn btn-sm btn-icon btn-success mr-0" title="modifier"><i class="ft-edit-2"></i></button> '+
                                '      <button type="button" data-action="action-supprimer" class="action btn btn-sm btn-icon btn-warning mr-0" title="supprimer"><i class="ft-trash"></i></button> '+
                                '  </div>'

                    }
                }
            ],
            "createdRow": function(row, data, index) {
                  // let date = new Date(data.date).toLocaleDateString(window.navigator.language, {year: 'numeric',month: 'long',day: 'numeric',});
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

            // $('#table-emprunt').on('show.bs.dropdown', function () {
            //   $('.dataTables_scrollBody').addClass('dropdown-visible')
            // }).on('hide.bs.dropdown', function () {
            //   $('.dataTables_scrollBody').removeClass('dropdown-visible')
            // })


            // $('#table-emprunt tbody .dropdown-toggle').dropdown();

            $('#table-versements tbody').on( 'click', 'a.action', function (event)
              {
                var id = $(this).data('id')
                var action = $(this).data('action');
                // console.log(id)
                // console.log(action)
                // var data = table.row( $(this).parents('tr') ).data()
                // console.log(data)
                // // let id = data.id
                // let num = data.num
                // let code_enregistrement = data.code_enregistrement
                // let titre = data.titre
                // let eleve = data.eleve
                // let date_emprunt = data.date_emprunt
                // let date_expiration = data.date_expiration
                // let classe = data.classe
                // let etat_document = data.etat_document
                // $('#modal-restitution').modal('show')
                // $('.dropdown-toggle').dropdown()
                // $(".dropdown").dropdown("toggle");
                console.log(action)
                // switch(action){
                //   case 'action-voir':
                //       $('#modal-restitution').modal('show')
                //     break;
                //   case 'action-modifier':
                //     $('#modal-restitution').modal('show')
                //     break;
                //   case 'action-restituer':
                //     $('#modal-restitution').modal('show')
                //     break;
                //   case 'action-reemprunter':
                //     $('#modal-restitution').modal('show')
                //     break;
                //   case 'action-supprimer':
                //     $('#modal-restitution').modal('show')
                //     break;
                // }

                // alert( id, num, code_enregistrement, titre, eleve, date_emprunt, date_expiration, classe, etat_document )
                // return false
              }
            )


            //Reload table data every 30 seconds (paging retained):
            setInterval( function () {
                table.ajax.reload( null, false ); // user paging is not reset on reload
            }, 5550000 );
        }


    (function(window, document, $){

    	// Localization
      $('.localeRange').daterangepicker({
        singleDatePicker: false,
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
      // max: [2022,10,30],

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

    window.setInterval(
      function (){
        table.ajax.reload()
      },
      <?= API::REALTIME_TIME_RECENT_TRANSACTION ?>
    )

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


<!-- <script>

        (function () {
          if (typeof EventTarget !== "undefined") {
              let func = EventTarget.prototype.addEventListener;
              EventTarget.prototype.addEventListener = function (type, fn, capture) {
                  this.func = func;
                  if(typeof capture !== "boolean"){
                      capture = capture || {};
                      capture.passive = false;
                  }
                  this.func(type, fn, capture);
              };
          };
      }());
    </script> -->
