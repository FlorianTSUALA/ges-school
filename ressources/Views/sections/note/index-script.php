<?php 
    use Core\Routing\URL;
    include_once dirname(__DIR__)."/_common_lib/_select2_script.php"; 
    include_once "affectation-script.php"; 
?>

<script>

    var session = 'ALL'
    var periode = 'ALL'
    var salle_classe = 'ALL'
    var $session = $('#session')
    var $periode = $('#periode')
    var $salle_classe = $('#salle_classe')
    // 

    $(document).ready(function(){
        // var trHead = $("thead:first tr");
        // $("thead:first tr th").height("100px");
        // $("th div", trHead).addClass("rotate").css('margin-left', '2px').css('position', 'absolute');

        var trHead = $("#basicScenario > div.jsgrid-grid-header.jsgrid-header-scrollbar > table > tr.jsgrid-header-row");
        $("#basicScenario > div.jsgrid-grid-header.jsgrid-header-scrollbar > table > tr.jsgrid-header-row th").height("100px");
        $("#basicScenario > div.jsgrid-grid-header.jsgrid-header-scrollbar > table > tr.jsgrid-header-row > th.jsgrid-header-cell", trHead).addClass("rotate").css('margin-left', '2px').css('position', 'absolute');
        // $("#basicScenario > div.jsgrid-grid-header.jsgrid-header-scrollbar > table > tr.jsgrid-header-row:first th", trHead).addClass("rotate").css('margin-left', '2px').css('position', 'absolute');
        
        //TODO: Chargement des session automatiquement au chargement avec du JS

        //CHANGE SESSION UPDATE PERIODE THEN UPDATE PERIODE WHO REFRESH JSGRID
        $("#description").on('change.select2', '#session', function(){
            session = $(this).find(':selected')[0].value
            $.ajax({
                type: 'POST',
                url: '<?= URL::link('api_liste_periode_session') ?>',
                data: {
                    'session_id': session
                },
                success: function (data) {
                    $periode.empty()
                    for (let item of JSON.parse(data)) {
                        $periode.append('<option data-id=' + item.periode_code + ' value=' + item.periode_code + '>' + item.periode + '</option>')
                    }
                    $periode.change()
                },
                complete: function() {
                    // console.log('Yes')
                    // updateJsGrid()
                }
            })
        })
        $session.change()

        //SALLE CLASSE EVENT CHANGE
        $("#description").on('change.select2', '#periode', function(){
            if($(this).find(':selected')[0] == undefined) periode = 'ALL'
            else periode = $(this).find(':selected')[0].id
            updateJsGrid()
        })

        //SALLE CLASSE EVENT CHANGE
        $("#description").on('change.select2', '#salle_classe', function(){
            if($(this).find(':selected')[0] == undefined) salle_classe = 'ALL'
            else salle_classe = $(this).find(':selected')[0].id
            updateJsGrid()
        })

        function updateJsGrid(){
            console.log('Hello')
            //manage error
            return
            $.ajax({
                url: '<?= URL::link('api_info_affectation_eleve') ?>',
                type: 'post',
                data: data,
                dataType: 'json',
            
                success:function(data){
                    // console.log(data)
                    let html = ''
                    for(var i = 0; i <data.length; i++) {
                        html += ' '
                        html += ' '
                        html += ' '
                        html += buildCard(data[i])
                    }

                    $('.content-body').html(html)

                    initDualList()
                },
                error: function (textStatus, errorThrown) {
                    Success = false;
                    console.log(textStatus, errorThrown);
                }, 
                complete: function(data) {

                }
            })
        }

    })

    function apiCall(){
        //jQuery > 1.4.3
        let id  = $('#menu .list-group a.list-group-item.active').attr("id")
        if(id.includes('ID_'))
            classe_id = id.replace('ID_', '')
        
        let data = {}
        if(classe_id === 'ALL'){
            data.classe_id = null
        }else{
            data.classe_id = classe_id
        }

        // console.log(data)

       $.ajax({
            url: '<?= URL::link('api_info_affectation_eleve') ?>',
            type: 'post',
            data: data,
            dataType: 'json',
        
            success:function(data){
                // console.log(data)
                let html = ''
                for(var i = 0; i <data.length; i++) {
                    html += ' '
                    html += ' '
                    html += ' '
                    html += buildCard(data[i])
                }

                $('.content-body').html(html)

                initDualList()
            },
            error: function (textStatus, errorThrown) {
                Success = false;
                console.log(textStatus, errorThrown);
            }, 
            complete: function(data) {

            }
        }); 
    }

</script>