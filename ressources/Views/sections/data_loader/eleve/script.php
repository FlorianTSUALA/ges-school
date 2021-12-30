<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

?>

<script>
    $(document).ready(function() {

        $('.input_file_upload').on('click', function() {
            document.getElementById($(this).data('target')).click()
        })


    }())

    function load_table(input, selector) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $(selector)
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);

            var formData = new FormData();
            formData.append('file', input.files[0]);

            $.ajax({
                url: '<?= URL::link("loader_upload_file") ?>',
                type: 'POST',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function(data) {
                    console.log(data);
                    alert(data);
                }
            });


        }

    }
</script>