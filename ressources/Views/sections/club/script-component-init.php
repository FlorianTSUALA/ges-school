<?php include dirname(__DIR__)."/_common_lib/_select2_script.php"; ?>

<script>

    $(document).ready(function(){
        $('.select-multiple-2').each(function() {
            $(this).select2({  placeholder: "Saisir un mot pour rechercher", tags: true, multiple: true, minimumResultsForSearch: 50, dropdownParent: $(this).parent()});
        })
    });

</script>

<script>
    //DECLARATION DES FONCTIONS DE BASE DE LA SECTION CANTINE
    function pad(number, length = 2) {
        var str = '' + number;
        while (str.length < length) str = '0' + str
        return str;
    }
    
    function strToLocaleDateTime(str_date){
        let pattern = /(\d{2})\/(\d{2})\/(\d{4})/
        let date = new Date(str_date.toString().replace(pattern,'$3-$2-$1'))
        return  date
    }

    function isValidDate(d) {
        return d instanceof Date && !isNaN(d);
    }

    function toSQLDateTime(str_date){
        let dt
        if(!isValidDate(str_date)){ //---> '27/07/2021' Invalid Date
            dt = strToLocaleDateTime(str_date)
            console.log(' bad ' + str_date + ' Goood' + dt)
        }else{
            dt = new Date(str_date)
            // console.log('oklm  '+ str_date + ' Goood' + dt)
        }

        // don't remove console
        return dt.getFullYear() + '-' + pad(dt.getMonth()+1) + '-' + pad(dt.getDate()) + ' ' + 
                pad(dt.getHours()) + ':' + pad(dt.getMinutes()) + ':' + pad(dt.getSeconds())
    }
    
    function addDaysToStr(date, days){
        date = strToLocaleDateTime(date)
        let _date = new Date(date)
        _date.setDate(_date.getDate() + days)
        return  _date.toLocaleDateString()
    }

    function strToLocaleDateTime(str_date){
        let pattern = /(\d{2})\/(\d{2})\/(\d{4})/
        let date = new Date(str_date.toString().replace(pattern,'$3-$2-$1'))
        return  date
    }

   
</script>