<?php 
    use Core\Routing\URL;
?>


<script>


    
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