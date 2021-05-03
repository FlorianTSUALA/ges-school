<?php include dirname(__DIR__)."/_common_lib/_select2_script.php"; ?>


<script>
    $(document).ready(function(){
        $('.select-multiple-2').each(function() {
            $(this).select2({  placeholder: "Saisir un mot pour rechercher", tags: true, multiple: true, minimumResultsForSearch: 50, dropdownParent: $(this).parent()});
        })
    });



</script>