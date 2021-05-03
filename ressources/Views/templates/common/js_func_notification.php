
<script>


    function flash_msg(msg, timeout = 5 /* en seconde */ ){
        $.blockUI({
            message: msg,
            fadeIn: 700,
            fadeOut: 700,
            timeout: timeout*1000,
            showOverlay: false,
            centerY: false,
            css: {
                width:  text2pixel(msg)+'px',
                top: '20px',
                left: '',
                right: '20px',
                border: 'none',
                padding: '15px 5px',
                backgroundColor: '#333',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: 0.9,
                color: '#fff'
            }
        });
    }

    function notify(msg, timeout = 5 /* en seconde */ ){
        flash_msg(msg, timeout)
    }

    function alert(msg, title='Oupss.... ', type="error"){
        swal(title, msg, type);
    }

    function block_notification(msg, timeout = 5000){
        $.blockUI({
            message: msg,
            fadeIn: 700,
            fadeOut: 700,
            timeout: timeout,
            showOverlay: false,
            centerY: false,
            css: {
                width:  text2pixel(msg)+'px',
                top: '20px',
                left: '',
                right: '20px',
                border: 'none',
                padding: '15px 5px',
                backgroundColor: '#333',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: 0.9,
                color: '#fff'
            }
        });
    }


</script>




