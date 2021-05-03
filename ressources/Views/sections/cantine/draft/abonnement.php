<?php

use App\Model\DBTable;
use Core\Routing\URL; ?>
<!-- http://jsfiddle.net/cLqv5bo8/1/ -->

<!-- <a href="<?= URL::link('accueil') ?>">
    <i class="icon-home"></i>
    <span class="menu-title" data-i18n="nav.dash.main">Dashboard</span>
    <span class="badge badge badge-info badge-pill float-right mr-2">5</span>
</a>

<button class="dropdown-item" type="button">
    <span class="mr-1 badge badge-pill badge-default badge-success badge-glow">10</span> More Options
</button>

ft-chevrons-right

ft-chevrons-down
ft-menu
ft-list

<button class="dropdown-item" type="button"><i class="ft-link float-right"></i> Another action</button>


<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <span class="glyphicon glyphicon-minus" ></span>
          Collapsible Group Item #1
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        Collapsible Body 1
      </div>
    </div>
  </div>
  <div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            <span class="glyphicon glyphicon-plus" ></span>
          Collapsible Group Item #2
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        Collapsible Body 2
      </div>
    </div>
  </div>
  <div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            <span class="glyphicon glyphicon-plus" ></span>
          Collapsible Group Item #3
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body">
        Collapsible Body 3
      </div>
    </div>
  </div>
</div> -->

<!-- 
<script>
    $("#accordion").on("hidden.bs.collapse", function (e) {
        $(e.target).closest(".panel-primary")
            .find(".panel-heading span")
            .removeClass("glyphicon glyphicon-minus")
            .addClass("glyphicon glyphicon-plus")
    })
    $("#accordion").on("shown.bs.collapse", function (e) {
        $(e.target).closest(".panel-primary")
            .find(".panel-heading span")
            .removeClass("glyphicon glyphicon-plus")
            .addClass("glyphicon glyphicon-minus")
    })
</script> -->


<script>
  // C:\laragon\www\ges-school\_robust\_Robust\Robust\Robust\app-assets\js\scripts\pickers\dateTime\pick-a-datetime.js
    var current_classe = 'all'
    var criteria = 'all'
    var start_date = moment()
    var end_date = moment()

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
            

            // Append a caption to the table before the DataTables initialisation
            $('#table-cantine').append('<caption style="caption-side: bottom">SUMBA REPORT DASHBOARD.</caption>')

            table = $('#table-cantine').DataTable({
                processing : true,
                //"serverSide": true,
                //Server-side processing is useful when working with large data sets (typically >50'000 records) as it means a database engine can be used to perform the sorting etc calculations - operations that modern database engines are highly optimised for, allowing use of DataTables with massive data sets (millions of rows).

                ajax:{
                    url: " <?= URL::link('') ?>",
                    // data: {
                    //     "compte_id": <?php echo $compte_id ?>,
                    //     "start_date": getDateStart(),
                    //     "end_date": getDateEnd()
                    // }
                },
                "columns": [<?php echo $columns ?>],
                "createdRow": function(row, data, index) {
                    if (data[2] * 1 < 9000) {
                        console.log(data[2])
                        $('td', row).eq(2).addClass('highlight')
                    }
                },
                "destroy" : true,
                dom: 'Blfrtip',
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tout"]],
                stateSave: true,
                buttons: [
                    //'columnsToggle',
                    {
                        extend: 'colvis',
                        collectionLayout: 'fixed two-column'
                    },
                    'copyHtml5',
                    {
                        extend: 'excel',
                        messageTop: 'Informations sur les transaction point marchand <?php $point_marchand->denomination ?>.',
                        exportOptions: {
                            columns: ':visible'
                        },
                        filename: function() {
                            var today = new Date()
                            var time = today.toLocaleTimeString()
                            var dd = today.getDate()
                            var mm = today.getMonth() + 1;
                            var yyyy = today.getFullYear()
                            if (dd < 10) {
                                dd = '0' + dd;
                            }
                            if (mm < 10) {
                                mm = '0' + mm;
                            }
                            var today = yyyy + '' + mm + '' + dd;
                            var name = '<?= DBTable::ABONNEMENT_CANTINE ?>';

                            return name + "_REPORT_" + today + "_" + time;
                        },
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        messageBottom: null,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        autoPrint: false,
                        messageTop: function() {
                            printCounter++;

                            if (printCounter === 1) {
                                return 'Bien joué !!! Votre premiere impression de document.';
                            } else {
                                return 'ôh, super !!! C\'est la ' + printCounter + ' imporession.';
                            }
                        },

                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '10pt')

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit')
                        },
                        messageBottom: null,
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ],
                columnDefs: [{
                    targets: 1,
                    visible: false
                }],
                language: {
                    "scrollY": "1000px",
                    "scrollCollapse": true,
                    "scrollX": true,
                    //"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tout"]],
                    "iDisplayLength": -1,
                    "lengthMenu": "Afficher _MENU_ éléments par page",
                    "zeroRecords": "Oups... Aucune transaction depuis votre point marchand",
                    "info": "Page _PAGE_ sur _PAGES_",
                    "infoEmpty": "Aucun enregistrement disponible",
                    "infoFiltered": "(filtre appliquer sur _MAX_ éléments au total du tableau actuel)",
                    "decimal": ",",
                    "thousands": " ",
                    "paginate": {
                        "first": "Premier",
                        "last": "Dernier",
                        "next": "Suiv.",
                        "previous": "Préc."
                    },
                    "search": "Mini-Recherche (sur les éléments visibles ci-dessous)  :",
                    buttons: {
                        colvis: '<i class="fa fa-eye" aria-hidden="true"></i>Visibilité',
                        copy: '<span class="i-Stamp-1">Copiez</span>',
                        print: '<span class="i-Stamp-1">Imprimez</span>',
                        copyTitle: 'Ajouté au presse-papiers',
                        copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
                        copySuccess: {
                            _: '%d lignes copiées',
                            1: '1 ligne copiée'
                        },
                    }
                },
            })
        }


    (function(window, document, $){

    	// Localization
      $('.localeRange').daterangepicker({
        ranges: {
          "Aujourd'hui": [moment(), moment()],
          'Hier': [moment().subtract('days', 1), moment().subtract('days', 1)],
          'Demain': [moment().add(1, 'days'), moment().add(1, 'days')],
          'Les 7 derniers jours': [moment().subtract('days', 6), moment()],
          'Les 7 prochains jours': [moment(), moment().add('days', 6)],
          'Les 30 derniers jours': [moment().subtract('days', 29), moment()],
          'Ce mois-ci': [moment().startOf('month'), moment().endOf('month')],
          'le mois dernier': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
        },
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
        console.log('Hi there!!!')
      },
      onRender: function() {
        console.log('Holla... rendered new')
      },
      onOpen: function() {
        console.log('Picker Opened')
      },
      onClose: function() {
        console.log("I'm Closed now")
      },
      onStop: function() {
        console.log('Have a great day ahead!!')
      },
      onSet: function(context) {
        console.log('All stuff:', context)
      }
  }, cb)

  init_data_table()

  
  function cb(start, end) {
    $('#resume_filtre').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    console.log(start.format( 'YYYY-MM-DD  HH:mm:ss.000' ))         
    console.log(end.format( 'YYYY-MM-DD  HH:mm:ss.000' ))         
    table.ajax.url( " <?php echo KGS_APPS_URL ?>api/transaction/transaction_point_marchand_read_all.php?compte_id=<?php echo $compte_id ?>&start_date="+start.format( 'YYYY-MM-DD  HH:mm:ss.000' )+"&end_date="+end.format( 'YYYY-MM-DD  HH:mm:ss.000' ) ).load()
    //table.ajax.reload()
    //init_data_table(0, start.format( 'YYYY-MM-DD  HH:mm:ss.000' ), end.format( 'YYYY-MM-DD  HH:mm:ss.000' ))
}


  })(window, document, jQuery)
</script>