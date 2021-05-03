<script>

    function text2pixel(str, margin = 5 /* margin is like offset */){
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext("2d");
        //https://www.w3schools.com/tags/canvas_font.asp - For more customization of message-box
        ctx.font = "message-box";        
        var width = ctx.measureText(str).width;
        return width + margin;
    }

    function getRandomBootstrapColor(){
        let items = Array("warning", "info","success", "danger", "primary", "dark")
        let item = items[Math.floor(Math.random() * items.length)]
        return item
    }
    

    function getRandomAnimation(){
        let items = ["slideInDown", "zoomIn", "fadeInDown", "slideInUp", "zoomInLeft", "fadeInLeft"]
        let item = items[Math.floor(Math.random() * items.length)]
        return item
    }

</script>

