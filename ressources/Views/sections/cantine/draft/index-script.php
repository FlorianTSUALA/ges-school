
<script>
   $(document).ready(function() {

var groupingTable = $('.row-grouping').DataTable({
    // responsive: false,
    // autoWidth: true,
    // rowReorder: true,
    'columnDefs': [
        // { 'orderable': false, 'className': 'reorder', 'targets': -1 },
        { "width": "5%", "targets": 0 }
        // { 'orderable': true, 'targets': '_all' }
    ]
} );

// Checkbox & Radio 1
$('.icheck input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
});

$('#class-list').on( 'draw.dt', function () {
    // Checkbox & Radio 1
    $('.icheck input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
    });
} );

});
</script>