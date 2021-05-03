<?php

namespace Core\Helper;

trait DebugHelpers{

    // https://stackoverflow.com/questions/4458837/how-to-define-global-functions-in-php
    // https://www.sigerr.org/make-php-lib-functions-like-dump-or-dd-globally-available
    // https://stackoverflow.com/questions/19816438/make-var-dump-look-pretty

    //https://stackoverflow.com/questions/1214043/find-out-which-class-called-a-method-in-another-class

    function declareDebug(){
        // we can delcalre all funciton that we want to use in projet


        function dd1($expression, ...$_ ){
            highlight_string("<?php\n " . var_export($expression, true) . "?>");
            echo '<script>document.getElementsByTagName("code")[0].getElementsByTagName("span")[1].remove() ;document.getElementsByTagName("code")[0].getElementsByTagName("span")[document.getElementsByTagName("code")[0].getElementsByTagName("span").length - 1].remove() ; </script>';
            die();
        }
        
        function dd2($expression, ...$_ ){
            // var_dump($expression, $_);
            echo '<pre>' . var_export($expression, true) . '</pre>';
            die('---------------- || -------------------');
        }

        function dd($expression , $title = " -ges-school- ", ...$_){

            $background="#EEEEEE";
            $color="#000000";            
            
            //Print File called function
            $trace = debug_backtrace();
            if (isset($trace[1])) {
                // $trace[0] is ourself
                // $trace[1] is our caller
                // and so on...
                $function = $trace[1]['function']??'None';
                $class = $trace[1]['class']??'None';
                $line = $trace[1]['line']??'None';
                // var_dump($trace[1]);
                // echo  format('called by', true) ." {$class} ::  ".format('function', true)."  {$function} :: at ".format('line', true)." {$line}";
            }



            dump($expression, $title, $background, $color, $class, $function, $line, $_);
            echo "<br>";
            
          
            

            die();
        }
        
        function format($text, $isKey =  false){
            
            $color="#000000";
            
            if($isKey){
                $color="#a70c27";
                return    "<span style='color:$color;'><b>$text</b> </span>";
            }else{
                return   "<span style='color:$color;'><b>$text</b> </span>";
            }        
        }

        function vd($expression, ...$_ ){
            // echo '<pre>' . var_export($expression, true) . '</pre>';
            // var_dump($expression, $_);

            $background="#EEEEEE";
            $color="#000000";
            $title = " -ges-school- ";
            echo '<pre><br><br></pre>';

            //Print File called function
            $trace = debug_backtrace();
            if (isset($trace[1])) {
                // $trace[0] is ourself
                // $trace[1] is our caller
                // and so on...
                $function = $trace[1]['function']??'None';
                $class = $trace[1]['class']??'None';
                $line = $trace[1]['line']??'None';
                // var_dump($trace[1]);
                // echo  format('called by', true) ." {$class} ::  ".format('function', true)."  {$function} :: at ".format('line', true)." {$line}";
            }

            dump($expression, $title, $background, $color, $class, $function, $line, $_);
        }
    
        function dump($data, $title="", $background="#EEEEEE", $color="#000000", $class, $function, $line, ...$_){
            //=== Style  
            echo "  
            <style>
                /* Styling pre tag */
                pre {
                    padding:10px 20px;
                    white-space: pre-wrap;
                    white-space: -moz-pre-wrap;
                    white-space: -pre-wrap;
                    white-space: -o-pre-wrap;
                    word-wrap: break-word;
                }
        
                /* ===========================
                == To use with XDEBUG 
                =========================== */
                /* Source file */
                pre small:nth-child(1) {
                    font-weight: bold;
                    font-size: 14px;
                    color: #CC0000;
                }
                pre small:nth-child(1)::after {
                    content: '';
                    position: relative;
                    width: 100%;
                    height: 20px;
                    left: 0;
                    display: block;
                    clear: both;
                }
        
                /* Separator */
                pre i::after{
                    content: '';
                    position: relative;
                    width: 100%;
                    height: 15px;
                    left: 0;
                    display: block;
                    clear: both;
                    border-bottom: 1px solid grey;
                }  
            </style>
            ";
        
            //=== Content            
            echo "<pre style='background:$background; color:$color; padding:10px 20px; border:2px inset $color'>";
            echo    "<h2>$title</h2>";
            var_dump($data); 
            
            $caller = format('Called by', true);
            $at_line = format('Line', true);
            $at_function = format('Function', true);
            // var_dump($class);
            echo "<br>";

            echo  "$caller :: $class | $at_function :: $function | $at_line :: $line";

            echo "</pre>";
        
        }

        function var_view($var)
        {

            ini_set("highlight.keyword", "#a50000;  font-weight: bolder");
            ini_set("highlight.string", "#5825b6; font-weight: lighter; ");

            ob_start();
            highlight_string("<?php\n" . var_export($var, true) . "?>");
            $highlighted_output = ob_get_clean();

            $highlighted_output = str_replace( ["&lt;?php","?&gt;"] , '', $highlighted_output );

            echo $highlighted_output;
            die();
        }



    }


}