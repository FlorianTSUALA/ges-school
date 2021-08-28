<?php

use App\Model\Eleve;
use Core\Routing\URL;
use App\Model\Emprunt;
use App\Helpers\Helpers;
use Config\Invariant\API;
use Core\HTML\Form\InputType;

include dirname(dirname(dirname(__DIR__))) . "/_common_lib/_select2_script.php";

?>
<!--
    ******  VARIABLES *****
     $base_route
     $fillables
     $msg_delete
-->


<script>
  let msg = 'Bienvenue à la liste des élèves inscrits'
  block_notification(msg)

  var filter_by = 'ALL'
  var code = ''

  var printCounter = 0
  var table
 
  (function(window, document, $) {
    init_data_table()
  })(window, document, jQuery)




















  function init_data_table() {
    // $('#table-eleve').append('<caption style="caption-side: top-right">Table caption</caption>');

    table = $('#table-eleve').DataTable({
      //"serverSide": true,
      //Server-side processing is useful when working with large data sets (typically >50'000 records) as it means a database engine can be used to perform the sorting etc calculations - operations that modern database engines are highly optimised for, allowing use of DataTables with massive data sets (millions of rows).
      ajax: {
        url: '<?= URL::link('eleve_api_eleve_inscrit') ?>',
        data: function(data) {
          data.code = code,
            data.filter_by = filter_by
        },
        type: 'POST'
      },
      "columns": [<?= Eleve::getColumns("table_eleve_inscrit") ?>],
      
      order: [
        [1, 'asc']
      ],
      scrollY: "700px",
      scrollX: true,
      scrollCollapse: true,
      // paging:         false,
      fixedColumns: true,
      "columnDefs": [{
          "targets": 0,
          width: '3%',
          "searchable": false,
          // "orderable": false,
          "class": "index",

        },

        {
          "targets": 2,
          width: '10%',
        },

        {
          "targets": -2,
          width: '3%',
          "data": null,
          "render": function(data, type, full, meta) {
            const date = new Date(data).toLocaleDateString(window.navigator.language, {
              year: 'numeric',
              month: 'long',
              day: 'numeric',
            });
            return date
          }
        },
        {
          "targets": -1,
          "data": null,
          "render": function(data, type, full, meta){ 
                        return '  '+
                                    '<button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info dropdown-toggle"><i class="fa fa-cog"></i></button> <span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">  ' +
                                    '<a href="#" class="dropdown-item action action-voir" data-action="action-voir"  data-id="'+data.id+'"  ><i class="ft-eye"></i> voir</a>' +
                                    '<a href="#" class="dropdown-item action action-modifier" data-action="action-modifier"  data-id="'+data.id+'"  ><i class="ft-edit-2"></i> modifier</a>' +
                                    '<a href="#" class="dropdown-item action action-restituer" data-action="action-restituer"  data-id="'+data.id+'"  ><i class="ft-check"></i> restituer</a>' +
                                    '<a href="#" class="dropdown-item action action-reemprunter" data-action="action-reemprunter"  data-id="'+data.id+'"  ><i class="ft-upload"></i> re-emprunter</a>' +
                                    '<a href="#" class="dropdown-item action action-supprimer" data-action="action-supprimer"  data-id="'+data.id+'"  ><i class="ft-trash"></i> supprimer</a>  </span>' 
          },
        }
      ],
      "createdRow": function(row, data, index) {
        // let date = new Date(data.date).toLocaleDateString(window.navigator.language, {year: 'numeric',month: 'long',day: 'numeric',});
      },
      "fnDrawCallback": function(oSettings) {
        // $('#table-emprunt').append('<caption style="caption-side: top-right">Table caption</caption>');
      },
      <?= Helpers::dataTableCommunOptions() ?>
      dom: "<'d-flex justify-content-between'<'p-2'l><'p-2'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      renderer: 'bootstrap',
      // "destroy" : true,
      // dom: 'Blfrtip',
      // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tout"]],
      stateSave: true,

    })

    table.on('order.dt search.dt', function() {
      table.column(0, {
        search: 'applied',
        order: 'applied'
      }).nodes().each(function(cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

    $('#table-eleve tbody').on('click', 'button.action', function() {
      // var id = $(this).data('id');
      var action = $(this).data('action');
      //alert('hello')
      console.log(action)
      var data = table.row($(this).parents('tr')).data()
      console.log(data)
      let id = data.id
      console.log(data)
      console.log(id)
      // return

      // let num = data.num
      // let code_enregistrement = data.code_enregistrement
      // let titre = data.titre
      // let eleve = data.eleve
      // let date_emprunt = data.date_emprunt
      // let date_expiration = data.date_expiration
      // let classe = data.classe
      // let etat_document = data.etat_document

  

      // alert( id, num, code_enregistrement, titre, eleve, date_emprunt, date_expiration, classe, etat_document )
    })


  }

  //Reload table data every 30 seconds (paging retained):
  setInterval(function() {
    table.ajax.reload(null, false); // user paging is not reset on reload
  }, <?= REFRESH_TIME_DATATABLE ?>);


</script>


<script>
  $('#menu .list-group a.list-group-item').click(function(e) {
    $('#menu .list-group a.list-group-item.active').removeClass('active');
    var $current = $(this)
    $current.addClass('active');
    e.preventDefault();
    if (this.id.includes('ID_')) {
      let current_id = this.id.replace('ID_', '')
      code = current_id
      filter_by = 'classe'
    } else {
      filter_by = 'ALL'
      code = ''
    }
    console.log(code)

    table.ajax.reload()
  });
</script>