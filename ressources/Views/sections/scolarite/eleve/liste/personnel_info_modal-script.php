<?php 
    use Core\Routing\URL;
?>


<script>


    function deleteItem(id){
        $.ajax({
            url: '<?= URL::link('personnel_api_delete_personnel');?>'+id,
            type: 'post',
            dataType: 'json',
            beforeSend:function(){
            },
            success:function(data){
                
                table.ajax.reload( null, false ); // user paging is not reset on reload
                swal("Bingo !!!", "Suppression réalisée avec sucess !!!", 'success')

            },
            error: function (textStatus, errorThrown) {
                Success = false;
                swal("Erreur", "Erreur de communication avec le serveur :)", "error");
                console.log(textStatus, errorThrown);
            }
        });    
    }
    
    // Must use FileSaver.js 2.0.2 because 2.0.3 has issues.
    function download(imagePath){
        let fileName = getFileName(imagePath)
        console.log(fileName)
        console.log(imagePath)
        saveAs(imagePath, fileName)
    }
    
    function getFileName(str) {
        return str.substring(str.lastIndexOf('/') + 1)
    }
</script>