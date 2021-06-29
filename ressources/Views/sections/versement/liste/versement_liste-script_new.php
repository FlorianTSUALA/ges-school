<style>
	.dataTables_filter {
		width: 50%;
		float: right;
		text-align: right;
	}

    @media (max-width: 768px) { /* use the max to specify at each container level */
    .specifictd {
        width:360px;  /* adjust to desired wrapping */
        display:table;
        white-space: pre-wrap; /* css-3 */
        white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
        white-space: -pre-wrap; /* Opera 4-6 */
        white-space: -o-pre-wrap; /* Opera 7 */
        word-wrap: break-word; /* Internet Explorer 5.5+ */
    }
}
</style>

<script type="text/javascript">
    $(document).ready(function() {
        var printCounter = 0;
        $('#datatable').DataTable( {
               dom: 'flitp',
               language: {
                    "scrollY": "1000px",
                    "scrollCollapse": true,
                    "scrollX": true,
                    //"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tout"]],
                    "iDisplayLength": -1,
                    "lengthMenu": "Afficher _MENU_ éléments par page",
                    "zeroRecords": "Oups... Aucune données disponible",
                    "info": "Page _PAGE_ sur _PAGES_",
                    "infoEmpty": "Aucun enregistrement disponible",
                    "infoFiltered": "(filtre appliqué sur _MAX_ éléments au total du tableau actuel)",
                    "decimal": ",",
                    "thousands": " ",
                    "paginate": {
                        "first": "Premier",
                        "last": "Dernier",
                        "next": "Suiv.",
                        "previous": "Préc."
                    },
                    "search": "Zone de recherche :",
                    searchPlaceholder: "entrer un mot clé",
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
          } );

    });

</script>
