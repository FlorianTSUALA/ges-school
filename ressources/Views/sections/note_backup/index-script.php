<script>
    $(document).ready(function(){
        // var trHead = $("thead:first tr");
        // $("thead:first tr th").height("100px");
        // $("th div", trHead).addClass("rotate").css('margin-left', '2px').css('position', 'absolute');

        var trHead = $("#basicScenario > div.jsgrid-grid-header.jsgrid-header-scrollbar > table > tr.jsgrid-header-row");
        $("#basicScenario > div.jsgrid-grid-header.jsgrid-header-scrollbar > table > tr.jsgrid-header-row th").height("100px");
        $("#basicScenario > div.jsgrid-grid-header.jsgrid-header-scrollbar > table > tr.jsgrid-header-row > th.jsgrid-header-cell", trHead).addClass("rotate").css('margin-left', '2px').css('position', 'absolute');
        // $("#basicScenario > div.jsgrid-grid-header.jsgrid-header-scrollbar > table > tr.jsgrid-header-row:first th", trHead).addClass("rotate").css('margin-left', '2px').css('position', 'absolute');
        

    })
</script>

<?php include 'index-script_search_menu.php' ?>



<?php include dirname(__DIR__)."/_common_lib/_select2_script.php"; ?>

