
<script type="text/javascript">
    $(document).ready(function() {
        var printCounter = 0;
    });
</script>

<!-- Datatable initialization table -->
<script type="text/javascript">
    $(document).ready(function() {
        var printCounter = 0;
        var table;
        var start = moment().subtract(29, 'days');
        var end = moment();

        function getDateStart(){
            console.log(start.format( 'YYYY-MM-DD  HH:mm:ss.000' ));
            return start.format( 'YYYY-MM-DD  HH:mm:ss.000' );
        }
        
        function getDateEnd(){
            console.log(end.format( 'YYYY-MM-DD  HH:mm:ss.000' ));
            return end.format( 'YYYY-MM-DD  HH:mm:ss.000' );
        }
        
        function init_data_table() {
            

            // Append a caption to the table before the DataTables initialisation
            $('#tab-trans-pm').append('<caption style="caption-side: bottom">SUMBA REPORT DASHBOARD.</caption>');

            table = $('#tab-trans-pm').DataTable({
                processing : true,
                //"serverSide": true,
                //Server-side processing is useful when working with large data sets (typically >50'000 records) as it means a database engine can be used to perform the sorting etc calculations - operations that modern database engines are highly optimised for, allowing use of DataTables with massive data sets (millions of rows).

                ajax:{
                    url: " <?php echo KGS_APPS_URL ?>api/transaction/transaction_point_marchand_read_all.php",
                    // data: {
                    //     "compte_id": <?php echo $compte_id ?>,
                    //     "start_date": getDateStart(),
                    //     "end_date": getDateEnd()
                    // }
                },
                "columns": [<?php echo $columns ?>],
                "createdRow": function(row, data, index) {
                    if (data[2] * 1 < 9000) {
                        console.log(data[2]);
                        $('td', row).eq(2).addClass('highlight');
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
                            var today = new Date();
                            var time = today.toLocaleTimeString();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1;
                            var yyyy = today.getFullYear();
                            if (dd < 10) {
                                dd = '0' + dd;
                            }
                            if (mm < 10) {
                                mm = '0' + mm;
                            }
                            var today = yyyy + '' + mm + '' + dd;
                            var name = '<?php echo $_SESSION[SESSION::PM_DENOMINTION] ?>';

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
                                .prepend(
                                    '<img src="<?php echo KGS_APPS_URL . DIRECTORY_SEPARATOR . "ressources" . DIRECTORY_SEPARATOR . "img_pm" . DIRECTORY_SEPARATOR . $point_marchand->logo; ?>" style="position:absolute; top:0; left:0;" />'
                                );

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
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
            });
        }

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            console.log(start.format( 'YYYY-MM-DD  HH:mm:ss.000' ));         
            console.log(end.format( 'YYYY-MM-DD  HH:mm:ss.000' ));         
            table.ajax.url( " <?php echo KGS_APPS_URL ?>api/transaction/transaction_point_marchand_read_all.php?compte_id=<?php echo $compte_id ?>&start_date="+start.format( 'YYYY-MM-DD  HH:mm:ss.000' )+"&end_date="+end.format( 'YYYY-MM-DD  HH:mm:ss.000' ) ).load();
            //table.ajax.reload();
            //init_data_table(0, start.format( 'YYYY-MM-DD  HH:mm:ss.000' ), end.format( 'YYYY-MM-DD  HH:mm:ss.000' ));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        init_data_table();

        cb(start, end);

    });
</script>